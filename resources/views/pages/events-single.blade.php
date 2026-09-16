@extends('layouts.app')
@section('title', $event->title)
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $event->title, 'bannerKey' => 'events'])

    <section id="event-singel" class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="events-area">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="events-left mt-30">
                            <h3>{{ $event->title }}</h3>
                            <img src="{{ asset($event->image ?: 'images/event/e-1.jpg') }}" alt="{{ $event->title }}">
                            @if($event->description)
                                <p class="mt-30">{!! nl2br(e($event->description)) !!}</p>
                            @endif
                            @if($event->content)
                                <div class="mt-20">{!! $event->content !!}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="events-right mt-30">
                            <div class="events-coundown pt-45 pb-50">
                                <ul>
                                    <li><i class="fa fa-calendar"></i> {{ $event->event_date->translatedFormat('d F Y') }}</li>
                                    @if($event->start_time)<li><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</li>@endif
                                    @if($event->location)<li><i class="fa fa-map-marker"></i> {{ $event->location }}</li>@endif
                                    @if($event->venue)<li><i class="fa fa-building"></i> {{ $event->venue }}</li>@endif
                                    @if($event->price !== null)<li><i class="fa fa-money"></i> {{ $event->price > 0 ? number_format($event->price, 2).' GNF' : 'Gratuit' }}</li>@endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
