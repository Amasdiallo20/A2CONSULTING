@extends('layouts.app')
@section('title', 'Webhook paiement')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Webhook paiement', 'bannerKey' => 'shop'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div style="background:#fff;padding:30px;border-radius:8px;">
                        <h3>Webhook opérationnel</h3>
                        <p>Cette adresse sert uniquement aux notifications de l’API de paiement (<strong>POST</strong>). Elle n’est pas une page à ouvrir dans le navigateur pour payer.</p>
                        <p class="mb-0">Les opérateurs (CinetPay ou API générique) doivent envoyer leurs confirmations ici. Un accès GET comme celui-ci confirme simplement que l’URL est joignable.</p>
                    </div>
                    <div class="text-center mt-30">
                        <a href="{{ route('home') }}" class="main-btn">Retour à l’accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
