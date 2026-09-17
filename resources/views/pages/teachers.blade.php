@extends('layouts.app')
@section('title', 'Formateurs')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Formateurs', 'bannerKey' => 'teachers'])

    <section id="teachers-page" class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                @forelse($teachers as $teacher)
                <div class="col-12 col-sm-6 col-lg-3">
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
                @empty
                <div class="col-12"><p class="text-center mt-40">Aucun formateur pour le moment.</p></div>
                @endforelse
            </div>
            <div class="mt-40">{{ $teachers->links() }}</div>
        </div>
    </section>
@endsection
