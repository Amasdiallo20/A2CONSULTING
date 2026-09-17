@extends('layouts.app')
@section('title', 'Formations')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Formations', 'subtitle' => 'Parcours concrets pour progresser et réussir', 'bannerKey' => 'courses'])

    <section id="courses-part" class="pt-120 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('courses.index') }}" class="courses-toolbar">
                        @if(request()->filled('q'))
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif
                        <div class="courses-toolbar__meta">{{ $courses->total() }} formation(s)</div>
                        <div class="courses-toolbar__filters">
                            @if($categories->isNotEmpty())
                            <label class="courses-toolbar__field">
                                <span class="courses-toolbar__label">Catégorie</span>
                                <select name="category" class="courses-filter-select js-auto-submit js-skip-nice-select" onchange="this.form.submit()">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            @endif
                            <label class="courses-toolbar__field">
                                <span class="courses-toolbar__label">Format</span>
                                <select name="mode" class="courses-filter-select js-auto-submit js-skip-nice-select" onchange="this.form.submit()">
                                    <option value="">Tous les formats</option>
                                    @foreach(\App\Models\Course::DELIVERY_MODES as $value => $label)
                                        <option value="{{ $value }}" {{ request('mode') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @forelse($courses as $course)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="mt-30">
                        @include('partials.course-card', ['course' => $course])
                    </div>
                </div>
                @empty
                <div class="col-12"><p class="text-center mt-40">Aucune formation pour ces critères.</p></div>
                @endforelse
            </div>
            <div class="mt-40">{{ $courses->links() }}</div>
        </div>
    </section>
@endsection
