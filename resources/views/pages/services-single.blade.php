@extends('layouts.app')
@section('title', $service->title)
@section('meta_description', share_plain_text($service->description ?: $service->title))
@section('og_image', share_asset_url($service->image ?: ($site?->pageBanner('services') ?? 'images/page-banner-2.jpg')))
@section('og_type', 'article')
@section('canonical', route('services.show', $service->id))
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $service->title, 'bannerKey' => 'services'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @include('partials.share-bar', [
                        'url' => route('services.show', $service->id),
                        'title' => $service->title,
                        'text' => share_plain_text($service->description ?: $service->title) ?: $service->title,
                    ])
                    @if($service->image)
                        <img src="{{ asset($service->image) }}" alt="{{ $service->title }}">
                    @endif
                    <h3 class="mt-30">{{ $service->title }}</h3>
                    @if($service->description)<p>{!! nl2br(e($service->description)) !!}</p>@endif
                    @if($service->content)<div>{!! $service->content !!}</div>@endif
                </div>
                <div class="col-lg-4">
                    @if($service->price)
                        <p><strong>Tarif :</strong> {{ format_price($service->price) }}</p>
                    @endif
                    <a href="{{ route('contact') }}" class="main-btn">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>
@endsection
