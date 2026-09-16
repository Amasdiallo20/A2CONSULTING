@extends('layouts.app')
@section('title', $teacher->name)
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $teacher->name, 'bannerKey' => 'teachers'])

    <section id="teacher-singel" class="pt-70 pb-120 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="teacher-singel-left mt-30">
                        <div class="teacher-image">
                            <img src="{{ asset($teacher->image ?: 'images/teachers/teacher-2/t-1.jpg') }}" alt="{{ $teacher->name }}">
                        </div>
                        <div class="teacher-name pt-20">
                            <h6>{{ $teacher->name }}</h6>
                            <span>{{ $teacher->position ?: $teacher->title }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="teacher-singel-right mt-30">
                        @if($teacher->bio || $teacher->description)
                        <div class="teacher-description">
                            <h5>Biographie</h5>
                            <p>{!! nl2br(e($teacher->bio ?: $teacher->description)) !!}</p>
                        </div>
                        @endif
                        @if($teacher->courses->isNotEmpty())
                        <div class="teacher-courses mt-40">
                            <h5>Formations</h5>
                            <div class="row">
                                @foreach($teacher->courses as $course)
                                <div class="col-md-6 mt-20">
                                    <a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
