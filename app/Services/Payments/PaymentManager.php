<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class PaymentManager
{
    public function initiate(Order $order, SiteSetting $site): PaymentResult
    {
        $provider = $this->provider($site);

        if ($provider === 'manual') {
            return new PaymentResult(true);
        }

        if ($provider === 'sandbox' || ($provider !== 'manual' && $this->shouldSimulate($site))) {
            $url = route('checkout.simulate', $order);
            $order->update([
                'payment_method' => 'api',
                'payment_status' => 'processing',
                'payment_url' => $url,
            ]);

            return new PaymentResult(true, $url);
        }

        try {
            return match ($provider) {
                'cinetpay' => $this->initiateCinetPay($order, $site),
                'generic' => $this->initiateGeneric($order, $site),
                default => new PaymentResult(true),
            };
        } catch (\Throwable $e) {
            Log::error('Paiement API: '.$e->getMessage());

            if ($this->isSandbox($site)) {
                $url = route('checkout.simulate', $order);
                $order->update([
                    'payment_method' => 'api',
                    'payment_status' => 'processing',
                    'payment_url' => $url,
                ]);

                return new PaymentResult(true, $url, null, 'Mode test : simulateur local.');
            }

            return new PaymentResult(false, null, null, 'Le paiement en ligne est indisponible. Réessayez ou choisissez le transfert manuel.');
        }
    }

    public function handleWebhook(Request $request, SiteSetting $site): ?Order
    {
        $provider = $this->provider($site);

        if ($provider === 'cinetpay') {
            return $this->handleCinetPayWebhook($request, $site);
        }

        $reference = (string) ($request->input('reference') ?: $request->input('transaction_id') ?: '');
        $status = strtolower((string) $request->input('status', ''));
        $transactionId = (string) ($request->input('transaction_id') ?: $request->input('payment_token') ?: '');

        if ($site->payment_api_secret) {
            $header = (string) $request->header('X-Payment-Secret', '');
            if (! hash_equals((string) $site->payment_api_secret, $header)) {
                return null;
            }
        }

        $order = $this->findOrder($reference, $transactionId);
        if (! $order) {
            return null;
        }

        if (in_array($status, ['paid', 'success', 'accepted', 'complete'], true)) {
            $this->markPaid($order, $transactionId ?: $order->payment_reference);
        } elseif (in_array($status, ['failed', 'cancelled', 'refused', 'error'], true)) {
            $order->update(['payment_status' => 'failed']);
        }

        return $order;
    }

    public function markPaid(Order $order, ?string $transactionId = null): void
    {
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'payment_reference' => $transactionId ?: $order->payment_reference ?: $order->reference,
        ]);
    }

    public function provider(SiteSetting $site): string
    {
        $provider = $site->payment_provider ?: 'sandbox';

        return in_array($provider, ['manual', 'sandbox', 'cinetpay', 'generic'], true)
            ? $provider
            : 'sandbox';
    }

    public function isSandbox(SiteSetting $site): bool
    {
        return ($site->payment_mode ?: 'sandbox') !== 'live';
    }

    private function shouldSimulate(SiteSetting $site): bool
    {
        if ($this->provider($site) === 'sandbox') {
            return true;
        }

        if (! $this->isSandbox($site)) {
            return false;
        }

        return match ($this->provider($site)) {
            'cinetpay' => blank($site->payment_api_key) || blank($site->payment_site_id),
            'generic' => blank($site->payment_api_url),
            default => true,
        };
    }

    private function initiateCinetPay(Order $order, SiteSetting $site): PaymentResult
    {
        $endpoint = $this->isSandbox($site)
            ? 'https://api-checkout.cinetpay.com/v2/payment'
            : ($site->payment_api_url ?: 'https://api-checkout.cinetpay.com/v2/payment');

        $payload = [
            'apikey' => $site->payment_api_key,
            'site_id' => $site->payment_site_id,
            'transaction_id' => $order->reference,
            'amount' => integer_price($order->total),
            'currency' => $site->payment_currency ?: 'GNF',
            'description' => 'Commande '.$order->reference,
            'notify_url' => route('payments.webhook'),
            'return_url' => URL::signedRoute('checkout.return', $order),
            'channels' => 'MOBILE_MONEY',
            'lang' => 'fr',
            'metadata' => (string) $order->id,
            'customer_name' => $order->name,
            'customer_surname' => $order->name,
            'customer_email' => $order->email,
            'customer_phone_number' => $this->digits($order->momo_phone ?: $order->phone),
        ];

        $response = Http::timeout(30)->acceptJson()->post($endpoint, $payload);
        $body = $response->json() ?? [];

        if (($body['code'] ?? null) === '201' && ! empty($body['data']['payment_url'])) {
            $url = $body['data']['payment_url'];
            $order->update([
                'payment_method' => 'cinetpay',
                'payment_status' => 'processing',
                'payment_url' => $url,
                'payment_token' => $body['data']['payment_token'] ?? null,
            ]);

            return new PaymentResult(true, $url, $body['data']['payment_token'] ?? null);
        }

        throw new \RuntimeException($body['message'] ?? 'Réponse CinetPay invalide.');
    }

    private function initiateGeneric(Order $order, SiteSetting $site): PaymentResult
    {
        $endpoint = $site->payment_api_url;
        if (blank($endpoint)) {
            throw new \RuntimeException('URL de l’API de paiement manquante.');
        }

        $payload = [
            'amount' => integer_price($order->total),
            'currency' => $site->payment_currency ?: 'GNF',
            'reference' => $order->reference,
            'description' => 'Commande '.$order->reference,
            'operator' => $order->payment_operator,
            'customer' => [
                'name' => $order->name,
                'email' => $order->email,
                'phone' => $order->momo_phone ?: $order->phone,
            ],
            'notify_url' => route('payments.webhook'),
            'return_url' => URL::signedRoute('checkout.return', $order),
        ];

        $request = Http::timeout(30)->acceptJson();
        if (filled($site->payment_api_key)) {
            $request = $request->withToken($site->payment_api_key);
        }
        if (filled($site->payment_api_secret)) {
            $request = $request->withHeaders(['X-Payment-Secret' => $site->payment_api_secret]);
        }

        $body = $request->post($endpoint, $payload)->json() ?? [];
        $url = $body['payment_url'] ?? $body['redirect_url'] ?? $body['data']['payment_url'] ?? null;

        if (! ($body['success'] ?? false) && blank($url)) {
            throw new \RuntimeException($body['message'] ?? 'Réponse API invalide.');
        }

        $transactionId = $body['transaction_id'] ?? $body['token'] ?? null;
        $order->update([
            'payment_method' => 'api',
            'payment_status' => 'processing',
            'payment_url' => $url,
            'payment_token' => $transactionId,
            'payment_reference' => $transactionId,
        ]);

        return new PaymentResult(true, $url, $transactionId);
    }

    private function handleCinetPayWebhook(Request $request, SiteSetting $site): ?Order
    {
        $transactionId = (string) ($request->input('cpm_trans_id') ?: $request->input('transaction_id') ?: '');
        if ($transactionId === '') {
            return null;
        }

        $check = Http::timeout(30)->acceptJson()->post('https://api-checkout.cinetpay.com/v2/payment/check', [
            'apikey' => $site->payment_api_key,
            'site_id' => $site->payment_site_id,
            'transaction_id' => $transactionId,
        ])->json() ?? [];

        $order = $this->findOrder($transactionId, $transactionId);
        if (! $order) {
            return null;
        }

        $status = strtoupper((string) data_get($check, 'data.status', $request->input('cpm_trans_status')));
        if (in_array($status, ['ACCEPTED', 'SUCCESS'], true)) {
            $this->markPaid($order, $transactionId);
        } elseif (in_array($status, ['REFUSED', 'CANCELED', 'CANCELLED', 'FAILED'], true)) {
            $order->update(['payment_status' => 'failed']);
        }

        return $order;
    }

    private function findOrder(string $reference, string $token): ?Order
    {
        if ($reference !== '') {
            $order = Order::query()->where('reference', $reference)->first();
            if ($order) {
                return $order;
            }
        }

        if ($token !== '') {
            return Order::query()
                ->where('payment_token', $token)
                ->orWhere('payment_reference', $token)
                ->first();
        }

        return null;
    }

    private function digits(?string $phone): string
    {
        return preg_replace('/\D+/', '', (string) $phone) ?: '000000000';
    }
}
