<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'reference',
        'name',
        'email',
        'phone',
        'address',
        'notes',
        'total',
        'status',
        'payment_method',
        'payment_operator',
        'momo_phone',
        'payment_status',
        'payment_reference',
        'payment_url',
        'payment_token',
    ];

    protected $casts = [
        'total' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function operatorLabel(): string
    {
        return match ($this->payment_operator) {
            'orange' => 'Orange Money',
            'mtn' => 'MTN Mobile Money',
            'moov' => 'Moov Money',
            default => 'Mobile Money',
        };
    }

    public function paymentStatusLabel(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Payé',
            'declared' => 'Déclaré par le client',
            'processing' => 'Paiement en cours',
            'failed' => 'Échoué',
            default => 'En attente de paiement',
        };
    }
}
