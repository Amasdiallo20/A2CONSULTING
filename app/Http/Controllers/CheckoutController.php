<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Order;
use App\Models\ShopProduct;
use App\Models\SiteSetting;
use App\Services\Cart;
use App\Services\Payments\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show()
    {
        $items = Cart::items();
        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        return view('pages.checkout', [
            'items' => $items,
            'total' => Cart::total(),
            'site' => SiteSetting::current(),
        ]);
    }

    public function store(Request $request, PaymentManager $payments)
    {
        $items = Cart::items();
        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:2000',
            'payment_method' => 'required|in:cash_on_delivery,mobile_money',
            'payment_operator' => 'required_if:payment_method,mobile_money|nullable|in:orange,mtn',
            'momo_phone' => 'required_if:payment_method,mobile_money|nullable|string|max:50',
        ], [
            'payment_method.required' => 'Choisissez un mode de paiement.',
            'payment_operator.required_if' => 'Choisissez un opérateur Mobile Money.',
            'momo_phone.required_if' => 'Indiquez le numéro Mobile Money qui paiera.',
        ]);

        $isCod = $validated['payment_method'] === 'cash_on_delivery';

        try {
            $order = DB::transaction(function () use ($validated, $items, $isCod) {
                $order = Order::create([
                    'reference' => 'CMD-'.now()->format('YmdHis').'-'.random_int(10, 99),
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                    'notes' => $validated['notes'] ?? null,
                    'total' => Cart::total(),
                    'status' => 'pending',
                    'payment_method' => $isCod ? 'cash_on_delivery' : 'mobile_money',
                    'payment_operator' => $isCod ? null : ($validated['payment_operator'] ?? null),
                    'momo_phone' => $isCod ? null : ($validated['momo_phone'] ?? null),
                    'payment_status' => $isCod ? 'cod' : 'awaiting',
                ]);

                foreach ($items as $item) {
                    $order->items()->create([
                        'item_type' => $item['type'],
                        'item_id' => $item['id'],
                        'title' => $item['title'],
                        'unit_price' => $item['unit_price'],
                        'quantity' => $item['quantity'],
                        'line_total' => $item['unit_price'] * $item['quantity'],
                    ]);

                    if ($item['type'] === 'product') {
                        $product = ShopProduct::where('id', $item['id'])->lockForUpdate()->first();
                        if (! $product || $product->stock_quantity < $item['quantity']) {
                            throw new \RuntimeException('Stock insuffisant pour '.$item['title']);
                        }
                        $product->decrement('stock_quantity', $item['quantity']);
                    }

                    if ($item['type'] === 'course' && Course::where('id', $item['id'])->exists()) {
                        CourseRegistration::create([
                            'course_id' => $item['id'],
                            'name' => $validated['name'],
                            'email' => $validated['email'],
                            'phone' => $validated['phone'],
                            'message' => 'Commande '.$order->reference,
                            'status' => 'pending',
                        ]);
                    }
                }

                return $order;
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        Cart::clear();

        $orderIds = session('checkout_orders', []);
        $orderIds[] = $order->id;
        session(['checkout_orders' => array_values(array_unique($orderIds))]);

        if ($isCod) {
            return redirect()->route('checkout.thanks', $order)
                ->with('success', 'Votre commande est enregistrée. Vous paierez à la livraison.');
        }

        $result = $payments->initiate($order, SiteSetting::current());
        $order->refresh();

        if (! $result->ok) {
            return redirect()->route('checkout.thanks', $order)
                ->with('error', $result->message ?: 'Le paiement en ligne est indisponible.');
        }

        if ($result->redirectUrl) {
            return redirect()->away($result->redirectUrl);
        }

        return redirect()->route('checkout.thanks', $order)
            ->with('success', 'Votre commande a bien été enregistrée.');
    }

    public function thanks(Request $request, Order $order)
    {
        if (! $request->hasValidSignature()) {
            $this->assertOwnsOrder($order);
        }

        $order->load('items');
        $site = SiteSetting::current();

        return view('pages.checkout-thanks', compact('order', 'site'));
    }

    public function confirmPayment(Request $request, Order $order)
    {
        $this->assertOwnsOrder($order);

        if ($order->isCashOnDelivery()) {
            return back()->with('error', 'Cette commande se paie à la livraison.');
        }

        if ($order->payment_status === 'paid') {
            return back()->with('success', 'Cette commande est déjà marquée comme payée.');
        }

        $validated = $request->validate([
            'payment_reference' => 'required|string|max:120',
        ]);

        $order->update([
            'payment_reference' => $validated['payment_reference'],
            'payment_status' => 'declared',
        ]);

        return back()->with('success', 'Merci. Votre paiement Mobile Money est en cours de vérification.');
    }

    public function simulate(Order $order)
    {
        $this->assertOwnsOrder($order);
        if ($order->isCashOnDelivery()) {
            return redirect()->route('checkout.thanks', $order);
        }
        $site = SiteSetting::current();

        if ($site->usesManualPayment()) {
            return redirect()->route('checkout.thanks', $order);
        }

        return view('pages.checkout-simulate', compact('order', 'site'));
    }

    public function simulateSubmit(Request $request, Order $order, PaymentManager $payments)
    {
        $this->assertOwnsOrder($order);

        $validated = $request->validate([
            'outcome' => 'required|in:paid,failed',
        ]);

        if ($validated['outcome'] === 'paid') {
            $payments->markPaid($order, 'SIM-'.$order->reference);
        } else {
            $order->update(['payment_status' => 'failed']);
        }

        return redirect()->route('checkout.thanks', $order);
    }

    public function returnFromProvider(Request $request, Order $order)
    {
        if (! $request->hasValidSignature()) {
            $this->assertOwnsOrder($order);
        } else {
            $ids = array_map('intval', session('checkout_orders', []));
            $ids[] = (int) $order->id;
            session(['checkout_orders' => array_values(array_unique($ids))]);
        }

        return redirect()->route('checkout.thanks', $order);
    }

    public function webhookStatus()
    {
        return view('pages.checkout-webhook');
    }

    public function webhook(Request $request, PaymentManager $payments)
    {
        if ($request->isMethod('HEAD')) {
            return response('', 200);
        }

        $order = $payments->handleWebhook($request, SiteSetting::current());

        return response()->json([
            'ok' => (bool) $order,
            'reference' => $order?->reference,
        ]);
    }

    private function assertOwnsOrder(Order $order): void
    {
        $ids = array_map('intval', session('checkout_orders', []));
        abort_unless(in_array((int) $order->id, $ids, true), 403);
    }
}
