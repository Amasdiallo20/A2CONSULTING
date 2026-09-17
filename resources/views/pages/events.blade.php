@extends('layouts.app')
@section('title', 'Événements')
@section('meta_description', 'Rencontres, ateliers et sessions à venir chez A2 Consulting.')
@section('og_image', share_asset_url($site?->pageBanner('events') ?? 'images/page-banner-3.jpg'))
@section('canonical', route('events.index'))
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Événements', 'subtitle' => 'Rencontres, ateliers et sessions à venir', 'bannerKey' => 'events'])

    <section id="event-page" class="pt-90 pb-120 gray-bg">
        <div class="container">
            @include('partials.share-bar', [
                'url' => route('events.index'),
                'title' => 'Événements A2 Consulting',
                'text' => 'Découvrez les événements A2 Consulting.',
                'compact' => true,
            ])
            <div class="row">
                @forelse($events as $event)
                <div class="col-12 col-lg-6">
                    <div class="singel-event-list mt-30">
                        <div class="event-thum">
                            <img src="{{ asset($event->image ?: 'images/event/e-1.jpg') }}" alt="{{ $event->title }}">
                        </div>
                        <div class="event-cont">
                            <span><i class="fa fa-calendar"></i> {{ $event->event_date->translatedFormat('d F Y') }}</span>
                            @if($event->formattedTimeRange())
                                <span><i class="fa fa-clock-o"></i> {{ $event->formattedTimeRange() }}</span>
                            @endif
                            <a href="{{ route('events.show', $event->id) }}"><h4>{{ $event->title }}</h4></a>
                            <span><i class="fa fa-map-marker"></i> {{ $event->placeLabel() ?: 'Lieu à confirmer' }}</span>
                            <p>{{ \Illuminate\Support\Str::limit($event->description, 140) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><p class="text-center mt-40">Aucun événement pour le moment.</p></div>
                @endforelse
            </div>
            <div class="mt-40">{{ $events->links() }}</div>
        </div>
    </section>
@endsection
