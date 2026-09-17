<?php

namespace App\Services\Payments;

class PaymentResult
{
    public function __construct(
        public readonly bool $ok,
        public readonly ?string $redirectUrl = null,
        public readonly ?string $transactionId = null,
        public readonly ?string $message = null,
    ) {
    }
}
