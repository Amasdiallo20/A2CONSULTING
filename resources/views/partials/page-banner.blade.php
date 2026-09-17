@php
    $bannerKey = $bannerKey ?? null;
    $bannerImage = $bannerImage
        ?? (isset($site) && $bannerKey ? $site->pageBanner($bannerKey) : null)
        ?? 'images/page-banner-1.jpg';
@endphp
<section id="page-banner" class="page-hero-wrap">
    <div class="container">
        <div class="page-hero">
            <div class="page-hero__media" style="background-image: url({{ asset($bannerImage) }})"></div>
            <div class="page-hero__overlay"></div>
            <div class="page-hero__inner">
                <nav class="page-hero__nav" aria-label="Fil d’Ariane">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
                <h1>{{ $title }}</h1>
                @if(! empty($subtitle))
                    <p class="page-hero__lead">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
