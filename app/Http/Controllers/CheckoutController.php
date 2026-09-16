<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Order;
use App\Models\ShopProduct;
use App\Services\Cart;
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
            'site' => \App\Models\SiteSetting::current(),
        ]);
    }

    public function store(Request $request)
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
            'payment_operator' => 'required|in:orange,mtn,moov',
            'momo_phone' => 'required|string|max:50',
        ]);

        try {
            $order = DB::transaction(function () use ($validated, $items) {
            $order = Order::create([
                'reference' => 'CMD-' . now()->format('YmdHis') . '-' . random_int(10, 99),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'notes' => $validated['notes'] ?? null,
                'total' => Cart::total(),
                'status' => 'pending',
                'payment_method' => 'mobile_money',
                'payment_operator' => $validated['payment_operator'],
                'momo_phone' => $validated['momo_phone'],
                'payment_status' => 'awaiting',
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
                        throw new \RuntimeException('Stock insuffisant pour ' . $item['title']);
                    }
                    $product->decrement('stock_quantity', $item['quantity']);
                }

                if ($item['type'] === 'course' && Course::where('id', $item['id'])->exists()) {
                    CourseRegistration::create([
                        'course_id' => $item['id'],
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'message' => 'Commande ' . $order->reference,
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

        return redirect()->route('checkout.thanks', $order)
            ->with('success', 'Votre commande a bien été enregistrée.');
    }

    public function thanks(Order $order)
    {
        $this->assertOwnsOrder($order);
        $order->load('items');
        $site = \App\Models\SiteSetting::current();

        return view('pages.checkout-thanks', compact('order', 'site'));
    }

    public function confirmPayment(Request $request, Order $order)
    {
        $this->assertOwnsOrder($order);

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

    private function assertOwnsOrder(Order $order): void
    {
        $ids = array_map('intval', session('checkout_orders', []));
        abort_unless(in_array((int) $order->id, $ids, true), 403);
    }
}
