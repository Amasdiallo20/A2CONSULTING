@extends('layouts.app')
@section('title', 'Événements')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Événements', 'bannerImage' => 'images/page-banner-3.jpg'])

    <section id="event-page" class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                @forelse($events as $event)
                <div class="col-lg-6">
                    <div class="singel-event-list mt-30">
                        <div class="event-thum">
                            <img src="{{ asset($event->image ?: 'images/event/e-1.jpg') }}" alt="{{ $event->title }}">
                        </div>
                        <div class="event-cont">
                            <span><i class="fa fa-calendar"></i> {{ $event->event_date->translatedFormat('d F Y') }}</span>
                            <a href="{{ route('events.show', $event->id) }}"><h4>{{ $event->title }}</h4></a>
                            <span><i class="fa fa-map-marker"></i> {{ $event->location ?: $event->venue }}</span>
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
