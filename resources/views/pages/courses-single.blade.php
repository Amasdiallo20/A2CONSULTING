@extends('layouts.app')
@section('title', $course->title)
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $course->title, 'bannerKey' => 'courses'])

    <section id="corses-singel" class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="corses-singel-left mt-30">
                        <div class="title"><h3>{{ $course->title }}</h3></div>
                        <div class="course-terms">
                            <ul>
                                @if($course->teacher)
                                <li>
                                    <div class="teacher-name">
                                        <div class="thum">
                                            <img src="{{ asset($course->teacher->image ?: 'images/course/teacher/t-1.jpg') }}" alt="{{ $course->teacher->name }}">
                                        </div>
                                        <div class="name">
                                            <span>Formateur</span>
                                            <h6>{{ $course->teacher->name }}</h6>
                                        </div>
                                    </div>
                                </li>
                                @endif
                                @if($course->category)
                                <li>
                                    <div class="course-category">
                                        <span>Catégorie</span>
                                        <h6>{{ $course->category->name }}</h6>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="corses-singel-image pt-50">
                            <img src="{{ asset($course->image ?: 'images/course/cu-1.jpg') }}" alt="{{ $course->title }}">
                        </div>
                        <div class="overview-description">
                            @if($course->description)
                            <div class="singel-description pt-40">
                                <h6>Description</h6>
                                <p>{!! nl2br(e($course->description)) !!}</p>
                            </div>
                            @endif
                            @if($course->content)
                            <div class="singel-description pt-40">
                                <h6>Contenu</h6>
                                <div>{!! $course->content !!}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="corses-singel-right mt-30">
                        <div class="course-features mt-30">
                            <h4>Détails</h4>
                            <ul>
                                @if($course->duration)<li><i class="fa fa-clock-o"></i> Durée : {{ $course->duration }}</li>@endif
                                <li><i class="fa fa-book"></i> Leçons : {{ $course->lessons_count }}</li>
                                <li><i class="fa fa-users"></i> Étudiants : {{ $course->students_count }}</li>
                                <li>
                                    <i class="fa fa-money"></i>
                                    @if($course->isFree()) Gratuit @else {{ format_price($course->price) }} @endif
                                </li>
                            </ul>
                            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                                </div>
                            @endif
                            <form action="{{ route('courses.register', $course->id) }}" method="POST">
                                @csrf
                                <div class="form-singel mt-20">
                                    <input type="text" name="name" placeholder="Nom complet *" value="{{ old('name') }}" required>
                                </div>
                                <div class="form-singel mt-20">
                                    <input type="email" name="email" placeholder="Email *" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-singel mt-20">
                                    <input type="text" name="phone" placeholder="Téléphone" value="{{ old('phone') }}">
                                </div>
                                <div class="form-singel mt-20">
                                    <textarea name="message" placeholder="Message" rows="3">{{ old('message') }}</textarea>
                                </div>
                                <div class="form-singel mt-20">
                                    <button type="submit" class="main-btn">S'inscrire</button>
                                </div>
                            </form>
                            <div class="mt-20">
                                @include('partials.add-to-cart', [
                                    'type' => 'course',
                                    'id' => $course->id,
                                    'label' => 'Ajouter au panier',
                                    'class' => 'mt-0',
                                ])
                            </div>
                        </div>
                        @if($relatedCourses->isNotEmpty())
                        <div class="You-makelike mt-30">
                            <h4>Formations similaires</h4>
                            @foreach($relatedCourses as $related)
                            <div class="singel-makelike mt-20">
                                <div class="image">
                                    <img src="{{ asset($related->image ?: 'images/course/cu-1.jpg') }}" alt="{{ $related->title }}">
                                </div>
                                <div class="cont">
                                    <a href="{{ route('courses.show', $related->id) }}"><h4>{{ $related->title }}</h4></a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
.corses-singel-left .title h3 {
    position: relative;
    z-index: 1;
    padding-right: 0;
}
.corses-singel-left .course-terms ul li .teacher-name {
    display: flex;
    align-items: center;
}
.corses-singel-left .course-terms ul li .teacher-name .thum {
    position: static;
    transform: none;
    width: 50px;
    height: 50px;
    overflow: hidden;
    border-radius: 50%;
    margin-right: 12px;
}
.corses-singel-left .course-terms ul li .teacher-name .thum img {
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.corses-singel-left .course-terms ul li .teacher-name .name {
    padding-left: 0;
}
</style>
@endpush
