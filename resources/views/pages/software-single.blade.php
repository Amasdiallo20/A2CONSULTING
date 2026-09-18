@extends('layouts.app')
@section('title', $product->name)
@section('meta_description', share_plain_text($product->description ?: $product->tagline ?: $product->name))
@section('og_image', share_asset_url($product->image ?: ($site?->pageBanner('services') ?? 'images/page-banner-2.jpg')))
@section('og_type', 'article')
@section('canonical', route('software.show', $product))
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', [
        'title' => $product->name,
        'subtitle' => $product->tagline,
        'bannerKey' => 'services',
    ])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @include('partials.share-bar', [
                        'url' => route('software.show', $product),
                        'title' => $product->name,
                        'text' => share_plain_text($product->description ?: $product->name) ?: $product->name,
                    ])
                    <article class="software-detail__panel">
                        @if($product->image)
                            <img class="software-detail__image" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                        @endif
                        <p class="software-detail__name">{{ $product->name }}</p>
                        @if($product->tagline)
                            <h3>{{ $product->tagline }}</h3>
                        @endif
                        @if($product->description)<p class="software-detail__lead">{{ $product->description }}</p>@endif
                        @if($product->content)<div class="software-detail__body mt-20">{!! $product->content !!}</div>@endif

                        @include('partials.software-demo', ['product' => $product])

                        @if($product->videoEmbedUrl() || $product->screenshotList())
                            <div class="software-media mt-40">
                                @if($product->videoEmbedUrl())
                                    <div class="software-media__video">
                                        <h4>Vidéo de présentation</h4>
                                        <div class="software-video">
                                            <iframe
                                                src="{{ $product->videoEmbedUrl() }}"
                                                title="Présentation {{ $product->name }}"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen
                                                loading="lazy"
                                                referrerpolicy="strict-origin-when-cross-origin"
                                            ></iframe>
                                        </div>
                                    </div>
                                @endif
                                @if($product->screenshotList())
                                    <div class="software-media__shots">
                                        <h4>Captures d’écran</h4>
                                        <div class="software-shots" data-software-shots>
                                            @foreach($product->screenshotList() as $index => $shotPath)
                                                <button type="button" class="software-shots__item" data-src="{{ asset($shotPath) }}" aria-label="Agrandir la capture {{ $index + 1 }}">
                                                    <img src="{{ asset($shotPath) }}" alt="Capture {{ $product->name }} {{ $index + 1 }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($product->moduleList())
                            <h4 class="mt-40">Modules</h4>
                            <ul class="software-detail__mods">
                                @foreach($product->moduleList() as $moduleName)
                                    <li>{{ $moduleName }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </article>
                </div>
                <div class="col-lg-4">
                    <aside class="software-detail__aside">
                        <p class="software-demo__kicker">Accompagnement</p>
                        <h4>Essayer {{ $product->name }}</h4>
                        <p>Besoin d’une présentation guidée ? Nous paramétrons une démo selon votre activité et formons vos équipes.</p>
                        <a class="main-btn" href="{{ route('contact', ['sujet' => $product->demoSubject()]) }}">Demander une démo</a>
                        <a class="main-btn main-btn-2 mt-15" href="{{ route('software.index') }}">Tous les logiciels</a>
                        @if($others->isNotEmpty())
                            <p class="mt-30 mb-10"><strong>Autres logiciels</strong></p>
                            @foreach($others as $other)
                                <p><a href="{{ route('software.show', $other) }}">{{ $other->name }}</a></p>
                            @endforeach
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function () {
    var root = document.querySelector('[data-software-shots]');
    if (root) {
        var overlay = document.createElement('div');
        overlay.className = 'software-shots-overlay';
        overlay.hidden = true;
        overlay.innerHTML = '<button type="button" class="software-shots-overlay__close" aria-label="Fermer">&times;</button><img alt="">';
        document.body.appendChild(overlay);
        var img = overlay.querySelector('img');
        function close() { overlay.hidden = true; }
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay || e.target.classList.contains('software-shots-overlay__close')) close();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') close();
        });
        root.querySelectorAll('[data-src]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                img.src = btn.getAttribute('data-src');
                overlay.hidden = false;
            });
        });
    }

    var demo = document.querySelector('[data-software-demo]');
    if (!demo) return;

    demo.querySelectorAll('[data-copy]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var row = btn.closest('.software-demo__row');
            var code = row ? row.querySelector('[data-copy-value]') : null;
            var value = code ? code.getAttribute('data-copy-value') : '';
            if (!value || !navigator.clipboard) return;
            navigator.clipboard.writeText(value).then(function () {
                var previous = btn.textContent;
                btn.textContent = 'Copié';
                btn.classList.add('is-copied');
                setTimeout(function () {
                    btn.textContent = previous;
                    btn.classList.remove('is-copied');
                }, 1600);
            });
        });
    });

    demo.querySelectorAll('[data-toggle-secret]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var row = btn.closest('.software-demo__row');
            var code = row ? row.querySelector('[data-secret]') : null;
            if (!code) return;
            var hidden = code.classList.toggle('is-hidden');
            btn.textContent = hidden ? 'Afficher' : 'Masquer';
        });
        var row = btn.closest('.software-demo__row');
        var code = row ? row.querySelector('[data-secret]') : null;
        if (code) {
            code.classList.add('is-hidden');
        }
    });
})();
</script>
@endpush
