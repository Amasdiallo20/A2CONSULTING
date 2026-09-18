@extends('layouts.app')
@section('title', 'Logiciels')
@section('meta_description', 'A2StocK, A2SchooL et A2Resto : logiciels de gestion A2 Consulting.')
@section('og_image', share_asset_url($site?->pageBanner('services') ?? 'images/page-banner-2.jpg'))
@section('canonical', route('software.index'))
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', [
        'title' => 'Logiciels',
        'subtitle' => 'Applications métier conçues par A2 Consulting',
        'bannerKey' => 'services',
    ])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            @include('partials.share-bar', [
                'url' => route('software.index'),
                'title' => 'Logiciels A2 Consulting',
                'text' => 'Découvrez A2StocK, A2SchooL et A2Resto.',
                'compact' => true,
            ])
            <div class="row justify-content-center">
                @forelse($products as $product)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="mt-30">
                        @include('partials.software-card', ['product' => $product])
                    </div>
                </div>
                @empty
                <div class="col-12"><p class="text-center mt-40">Aucun logiciel pour le moment.</p></div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
