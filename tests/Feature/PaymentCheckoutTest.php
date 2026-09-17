<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\ShopProduct;
use App\Models\SiteSetting;
use App\Services\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_sandbox_checkout_redirects_to_simulator_then_marks_paid(): void
    {
        $product = ShopProduct::create([
            'title' => 'Guide test',
            'slug' => 'guide-test',
            'price' => 15000,
            'stock_quantity' => 5,
            'is_active' => true,
        ]);

        $site = SiteSetting::current();
        $site->update([
            'payment_provider' => 'sandbox',
            'payment_mode' => 'sandbox',
            'payment_currency' => 'GNF',
        ]);

        $this->withSession([
            Cart::SESSION_KEY => [
                'product:'.$product->id => [
                    'type' => 'product',
                    'id' => $product->id,
                    'title' => $product->title,
                    'image' => null,
                    'unit_price' => 15000,
                    'stock' => 5,
                    'quantity' => 1,
                ],
            ],
        ]);

        $response = $this->post(route('checkout.store'), [
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'phone' => '620000000',
            'address' => 'Conakry',
            'payment_operator' => 'orange',
            'momo_phone' => '621111111',
        ]);

        $order = Order::query()->first();
        $this->assertNotNull($order);
        $response->assertRedirect(route('checkout.simulate', $order));
        $this->assertSame('processing', $order->fresh()->payment_status);

        $this->post(route('checkout.simulate.submit', $order), ['outcome' => 'paid'])
            ->assertRedirect(route('checkout.thanks', $order));

        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame('confirmed', $order->fresh()->status);
    }

    public function test_webhook_marks_order_paid(): void
    {
        SiteSetting::current()->update([
            'payment_provider' => 'generic',
            'payment_mode' => 'live',
            'payment_api_secret' => 'hook-secret',
        ]);

        $order = Order::create([
            'reference' => 'CMD-TEST-1',
            'name' => 'Client',
            'email' => 'a@b.c',
            'phone' => '620000000',
            'address' => 'Conakry',
            'total' => 1000,
            'status' => 'pending',
            'payment_status' => 'processing',
        ]);

        $this->postJson(route('payments.webhook'), [
            'reference' => 'CMD-TEST-1',
            'status' => 'paid',
            'transaction_id' => 'TX-99',
        ], [
            'X-Payment-Secret' => 'hook-secret',
        ])->assertOk()->assertJson(['ok' => true]);

        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame('TX-99', $order->fresh()->payment_reference);
    }
}
