@extends('layouts.app')
@section('title', $service->title)
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $service->title, 'bannerKey' => 'services'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
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
