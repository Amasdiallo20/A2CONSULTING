@extends('layouts.app')
@section('title', 'Paiement Mobile Money')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Paiement Mobile Money', 'bannerKey' => 'shop'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            @php
                $merchant = $site->mobileMoneyNumber($order->payment_operator);
            @endphp

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div style="background:#fff;padding:30px;border-radius:8px;">
                        <h3>Commande {{ $order->reference }}</h3>
                        <p>Montant à payer : <strong>{{ format_price($order->total) }}</strong></p>
                        <p>Opérateur : <strong>{{ $order->operatorLabel() }}</strong></p>
                        <p>Votre numéro : <strong>{{ $order->momo_phone }}</strong></p>

                        @if($order->payment_status === 'paid')
                            <div class="alert alert-success">Paiement confirmé. Merci.</div>
                        @elseif($order->payment_status === 'declared')
                            <div class="alert alert-info">Votre paiement est en cours de vérification par A2 Consulting.</div>
                        @else
                            <div class="alert alert-warning">
                                <strong>Étape 1 — Envoyez le paiement</strong><br>
                                Transférez <strong>{{ format_price($order->total) }}</strong> via {{ $order->operatorLabel() }} vers le numéro :
                                <br><span style="font-size:22px;font-weight:700;">{{ $merchant }}</span>
                                <br><small>Indiquez la référence <strong>{{ $order->reference }}</strong> dans le motif du transfert.</small>
                            </div>

                            <h5>Étape 2 — Confirmez le transfert</h5>
                            <form action="{{ route('checkout.confirmPayment', $order) }}" method="POST" class="mt-20">
                                @csrf
                                <div class="form-singel">
                                    <input type="text" name="payment_reference" placeholder="ID / référence de la transaction Mobile Money *" required>
                                </div>
                                <div class="form-singel mt-20">
                                    <button type="submit" class="main-btn">J’ai payé</button>
                                </div>
                            </form>
                        @endif

                        <div class="mt-30">
                            @foreach($order->items as $item)
                                <p>{{ $item->title }} × {{ $item->quantity }} — {{ format_price($item->line_total) }}</p>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center mt-30">
                        <a href="{{ route('shop.index') }}" class="main-btn main-btn-2">Retour à la boutique</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
