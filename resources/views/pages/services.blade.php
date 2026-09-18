@extends('layouts.app')
@section('title', 'Services')
@section('meta_description', 'Accompagnement sur mesure : conseil, formation et services A2 Consulting.')
@section('og_image', share_asset_url($site?->pageBanner('services') ?? 'images/page-banner-2.jpg'))
@section('canonical', route('services.index'))
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Services', 'subtitle' => 'Accompagnement sur mesure pour vos projets', 'bannerKey' => 'services'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            @include('partials.share-bar', [
                'url' => route('services.index'),
                'title' => 'Services A2 Consulting',
                'text' => 'Découvrez les services A2 Consulting.',
                'compact' => true,
            ])
            <div class="row">
                @forelse($services as $service)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="singel-course mt-30">
                        <div class="thum">
                            <div class="image">
                                <img src="{{ asset($service->image ?: 'images/course/cu-1.jpg') }}" alt="{{ $service->title }}">
                            </div>
                        </div>
                        <div class="cont">
                            <a href="{{ route('services.show', $service->id) }}"><h4>{{ $service->title }}</h4></a>
                            <p>{{ \Illuminate\Support\Str::limit($service->description, 120) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><p class="text-center mt-40">Aucun service pour le moment.</p></div>
                @endforelse
            </div>
            <div class="mt-40">{{ $services->links() }}</div>
        </div>
    </section>
@endsection
