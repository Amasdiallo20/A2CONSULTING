@extends('layouts.app')
@section('title', 'Simulateur de paiement')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Paiement (test)', 'bannerKey' => 'shop'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div style="background:#fff;padding:30px;border-radius:8px;">
                        <h3>Simulateur Mobile Money</h3>
                        <p>Mode configuré dans l’administration : <strong>{{ $site->payment_provider ?: 'sandbox' }}</strong> / <strong>{{ $site->payment_mode ?: 'sandbox' }}</strong></p>
                        <p>Commande <strong>{{ $order->reference }}</strong></p>
                        <p>Montant : <strong>{{ format_price($order->total) }}</strong></p>
                        <p>Opérateur : <strong>{{ $order->operatorLabel() }}</strong> — {{ $order->momo_phone }}</p>
                        <p class="text-muted">Aucun argent réel n’est débité. Utilisez ces boutons pour tester le retour API.</p>

                        <form action="{{ route('checkout.simulate.submit', $order) }}" method="POST" class="mt-20">
                            @csrf
                            <input type="hidden" name="outcome" value="paid">
                            <button type="submit" class="main-btn">Simuler un paiement réussi</button>
                        </form>
                        <form action="{{ route('checkout.simulate.submit', $order) }}" method="POST" class="mt-20">
                            @csrf
                            <input type="hidden" name="outcome" value="failed">
                            <button type="submit" class="main-btn main-btn-2">Simuler un échec</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
