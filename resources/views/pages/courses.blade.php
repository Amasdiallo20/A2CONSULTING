@extends('layouts.app')
@section('title', 'Formations')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Formations', 'bannerImage' => 'images/page-banner-2.jpg'])

    <section id="courses-part" class="pt-120 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="courses-top-search">
                        <ul class="nav float-left">
                            <li class="nav-item">{{ $courses->total() }} formation(s)</li>
                        </ul>
                        @if($categories->isNotEmpty())
                        <div class="courses-search float-right">
                            <form method="GET" action="{{ route('courses.index') }}">
                                <select name="category" onchange="this.form.submit()">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($courses as $course)
                <div class="col-lg-4 col-md-6">
                    <div class="mt-30">
                        @include('partials.course-card', ['course' => $course])
                    </div>
                </div>
                @empty
                <div class="col-12"><p class="text-center mt-40">Aucune formation pour le moment.</p></div>
                @endforelse
            </div>
            <div class="mt-40">{{ $courses->links() }}</div>
        </div>
    </section>
@endsection
