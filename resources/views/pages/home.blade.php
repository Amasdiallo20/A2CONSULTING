@extends('layouts.app')

@section('title', $site->site_name ?? 'A2 Consulting')

@section('content')
    @include('partials.preloader')

    @if($site->hero_title || $site->hero_subtitle)
    <section id="slider-part" class="hero-wrap">
        <div class="container">
            <div class="hero-banner">
                <div class="hero-banner__media" style="background-image: url({{ asset($site->hero_image ?: 'images/slider/s-1.jpg') }})"></div>
                <div class="hero-banner__overlay"></div>
                <div class="hero-banner__glow" aria-hidden="true"></div>
                <div class="hero-banner__panel">
                    @if($site->hero_title)
                        <h1>{{ $site->hero_title }}</h1>
                    @endif
                    @if($site->hero_subtitle)
                        <p class="hero-banner__lead">{{ $site->hero_subtitle }}</p>
                    @endif
                    <div class="hero-banner__actions">
                        @if($site->hero_button_text)
                            <a class="main-btn" href="{{ $site->hero_button_url ?: route('courses.index') }}">
                                {{ $site->hero_button_text }}
                            </a>
                        @endif
                        <a class="hero-banner__ghost" href="{{ route('contact') }}">Nous contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($categories->isNotEmpty())
    @php
        $categoryIcons = ['fa fa-laptop', 'fa fa-bullhorn', 'fa fa-briefcase', 'fa fa-book', 'fa fa-line-chart', 'fa fa-cogs', 'fa fa-users', 'fa fa-graduation-cap'];
        $categoryColors = ['color-1', 'color-2', 'color-3'];
    @endphp
    <section id="category-part">
        <div class="container">
            <div class="category home-categories pt-40 pb-50">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="category-text pt-20 pb-20">
                            <h2>Nos catégories de formations</h2>
                            <p>Choisissez un domaine et explorez les parcours adaptés à vos objectifs.</p>
                            <a class="main-btn mt-20" href="{{ route('courses.index') }}">Toutes les formations</a>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach($categories as $index => $category)
                            @php
                                $iconClass = $category->icon ?: $categoryIcons[$index % count($categoryIcons)];
                                $colorClass = $categoryColors[$index % count($categoryColors)];
                            @endphp
                            <div class="col-12 col-sm-6 col-md-4">
                                <a class="home-category-card {{ $colorClass }}" href="{{ route('courses.index', ['category' => $category->slug]) }}">
                                    <span class="home-category-icon">
                                        @if($category->image)
                                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                                        @else
                                            <i class="{{ $iconClass }}"></i>
                                        @endif
                                    </span>
                                    <span class="home-category-name">{{ $category->name }}</span>
                                    <span class="home-category-meta">
                                        {{ $category->courses_count }} formation{{ $category->courses_count > 1 ? 's' : '' }}
                                    </span>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($site->about_title || $site->about_text || $events->isNotEmpty())
    <section id="about-part" class="pt-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    @if($site->about_title || $site->about_text)
                    <div class="section-title mt-50">
                        <h5>À propos</h5>
                        <h2>{{ $site->about_title ?: $site->site_name }}</h2>
                    </div>
                    <div class="about-cont">
                        <p>{!! $site->about_text !!}</p>
                        <a href="{{ route('about') }}" class="main-btn mt-55">En savoir plus</a>
                    </div>
                    @endif
                </div>
                @if($events->isNotEmpty())
                <div class="col-lg-6 offset-lg-1">
                    <div class="about-event mt-50">
                        <div class="event-title">
                            <h3>Événements à venir</h3>
                        </div>
                        <ul>
                            @foreach($events as $event)
                            <li>
                                <div class="singel-event">
                                    <span><i class="fa fa-calendar"></i> {{ $event->event_date->translatedFormat('d F Y') }}</span>
                                    <a href="{{ route('events.show', $event->id) }}"><h4>{{ $event->title }}</h4></a>
                                    @if($event->formattedTimeRange())
                                        <span><i class="fa fa-clock-o"></i> {{ $event->formattedTimeRange() }}</span>
                                    @endif
                                    @if($event->placeLabel())
                                        <span><i class="fa fa-map-marker"></i> {{ $event->placeLabel() }}</span>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="about-bg">
            <img src="{{ asset($site->aboutBgUrl()) }}" alt="">
        </div>
    </section>
    @endif

    @if($services->isNotEmpty())
    <section id="apply-aprt" class="pb-120">
        <div class="container">
            <div class="apply">
                <div class="row no-gutters">
                    @foreach($services as $service)
                    <div class="col-lg-6">
                        <div class="apply-cont {{ $loop->first ? 'apply-color-1' : 'apply-color-2' }}">
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->description }}</p>
                            <a href="{{ route('services.show', $service->id) }}" class="main-btn">Découvrir</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($courses->isNotEmpty())
    <section id="course-part" class="pt-115 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-45">
                        <h5>Nos formations</h5>
                        <h2>Formations en vedette</h2>
                    </div>
                </div>
            </div>
            <div class="row course-slied mt-30">
                @foreach($courses as $course)
                <div class="col-lg-4">
                    @include('partials.course-card', ['course' => $course])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($softwareProducts->isNotEmpty())
    <section id="software-part" class="pt-70 pb-110">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-7">
                    <div class="section-title pb-45">
                        <h5>Logiciels</h5>
                        <h2>Nos applications</h2>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="products-btn text-right pb-45">
                        <a href="{{ route('software.index') }}" class="main-btn">Tous les logiciels</a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($softwareProducts as $product)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="mt-20">
                        @include('partials.software-card', ['product' => $product, 'compact' => true])
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($teachers->isNotEmpty())
    <section id="teachers-part" class="pt-70 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-title mt-50">
                        <h5>Formateurs</h5>
                        <h2>Rencontrez nos formateurs</h2>
                    </div>
                    <div class="teachers-cont">
                        <a href="{{ route('teachers.index') }}" class="main-btn mt-55">Tous les formateurs</a>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="teachers mt-20">
                        <div class="row">
                            @foreach($teachers as $teacher)
                            <div class="col-sm-6">
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
                </div>
            </div>
        </div>
    </section>
    @endif

    @if($products->isNotEmpty())
    <section id="publication-part" class="pt-115 pb-120 gray-bg">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6">
                    <div class="section-title pb-60">
                        <h5>Boutique</h5>
                        <h2>Nos produits</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="products-btn text-right pb-60">
                        <a href="{{ route('shop.index') }}" class="main-btn">Tous les produits</a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="singel-publication product-card mt-30">
                        <div class="image">
                            <img src="{{ asset($product->image ?: 'images/publication/p-1.jpg') }}" alt="{{ $product->title }}">
                            <div class="add-cart">
                                <ul>
                                    <li>
                                        @include('partials.add-to-cart', [
                                            'type' => 'product',
                                            'id' => $product->id,
                                            'label' => '',
                                            'btnClass' => 'shop-cart-icon',
                                        ])
                                    </li>
                                    <li><a href="{{ route('shop.show', $product->id) }}" title="Voir le produit"><i class="fa fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="cont">
                            <div class="name">
                                <a href="{{ route('shop.show', $product->id) }}"><h6>{{ $product->title }}</h6></a>
                                @include('partials.product-price', ['product' => $product])
                            </div>
                            <div class="button">
                                @include('partials.add-to-cart', ['type' => 'product', 'id' => $product->id, 'label' => 'Ajouter'])
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('partials.testimonials-section')
    @include('partials.partners-section')

    @if($posts->isNotEmpty())
    <section id="news-part" class="pt-115 pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-50">
                        <h5>Actualités</h5>
                        <h2>Derniers articles</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($posts as $post)
                <div class="col-lg-6">
                    <div class="singel-news mt-30">
                        <div class="news-thum">
                            <img src="{{ asset($post->image ?: 'images/news/n-1.jpg') }}" alt="{{ $post->title }}">
                        </div>
                        <div class="news-cont">
                            <ul>
                                @if($post->published_at)
                                <li><a href="#"><i class="fa fa-calendar"></i>{{ $post->published_at->format('d M Y') }}</a></li>
                                @endif
                                @if($post->category)
                                <li><span>{{ $post->category->name }}</span></li>
                                @endif
                            </ul>
                            <a href="{{ route('blog.show', $post->id) }}"><h3>{{ $post->title }}</h3></a>
                            <p>{{ $post->excerpt }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection

@push('styles')
<style>
.home-categories {
    box-shadow: 0 18px 40px rgba(1, 104, 163, 0.22);
    padding-left: 30px;
    padding-right: 30px;
}
.home-categories .category-text h2 {
    font-size: 28px;
    line-height: 1.3;
    margin-bottom: 12px;
}
.home-categories .category-text p {
    color: #fff;
    font-size: 15px;
    margin-bottom: 0;
    opacity: 0.92;
}
.home-category-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 170px;
    margin: 12px 0;
    padding: 22px 16px;
    border-radius: 12px;
    color: #fff;
    text-decoration: none;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.home-category-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.2);
    color: #fff;
    text-decoration: none;
}
.home-category-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}
.home-category-icon i {
    font-size: 24px;
    color: #fff;
}
.home-category-icon img {
    max-width: 36px;
    max-height: 36px;
}
.home-category-name {
    display: block;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    font-family: 'Montserrat', sans-serif;
    line-height: 1.35;
}
.home-category-meta {
    display: block;
    margin-top: 6px;
    color: rgba(255, 255, 255, 0.85);
    font-size: 13px;
}
@media (max-width: 991px) {
    .home-categories {
        margin-top: -40px;
    }
    .home-categories .category-text {
        text-align: center;
        margin-bottom: 10px;
    }
}
</style>
@endpush
