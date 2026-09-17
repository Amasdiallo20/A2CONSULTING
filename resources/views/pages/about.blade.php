@extends('layouts.app')
@section('title', 'À propos')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'À propos', 'subtitle' => 'Cabinet de formation et de conseil à Conakry', 'bannerKey' => 'about'])

    <section id="about-page" class="pt-70 pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-title mt-50">
                        <h5>À propos</h5>
                        <h2>{{ $site->about_title ?: $site->site_name }}</h2>
                    </div>
                    <div class="about-cont">
                        <p>{!! $site->about_text !!}</p>
                    </div>
                </div>
                @if($site->about_image)
                <div class="col-lg-7">
                    <div class="about-image mt-50">
                        <img src="{{ asset($site->about_image) }}" alt="{{ $site->site_name }}">
                    </div>
                </div>
                @endif
            </div>

            @if($services->isNotEmpty())
            <div class="about-items pt-60">
                <div class="row justify-content-center">
                    @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <div class="about-singel-items mt-30">
                            <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h4><a href="{{ route('services.show', $service->id) }}">{{ $service->title }}</a></h4>
                            <p>{{ $service->description }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    @if($teachers->isNotEmpty())
    <section id="teachers-part" class="pt-70 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                @foreach($teachers as $teacher)
                <div class="col-lg-3 col-sm-6">
                    <div class="singel-teachers mt-30 text-center">
                        <div class="image">
                            <img src="{{ asset($teacher->image ?: 'images/teachers/t-1.jpg') }}" alt="{{ $teacher->name }}">
                        </div>
                        <div class="cont">
                            <a href="{{ route('teachers.show', $teacher->id) }}"><h6>{{ $teacher->name }}</h6></a>
                            <span>{{ $teacher->position ?: $teacher->title }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
