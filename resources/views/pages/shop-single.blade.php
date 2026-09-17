@extends('layouts.app')
@section('title', $product->title)
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $product->title, 'bannerKey' => 'shop'])

    @php $gallery = $product->galleryImages(); @endphp

    <section id="shop-singel" class="pt-120 pb-120 gray-bg">
        <div class="container">
            <div class="shop-destails">
                <div class="row align-items-start">
                    <div class="col-lg-6">
                        <div class="shop-left pt-30">
                            <div class="product-gallery" data-product-gallery>
                                <div class="product-gallery__grid">
                                    @foreach($gallery as $index => $view)
                                        <a href="{{ asset($view['src']) }}"
                                           class="product-gallery__shot shop-items {{ $view['detail'] ? 'is-detail' : '' }} {{ $index === 0 ? 'is-active' : '' }}"
                                           title="{{ $product->title }} — {{ $view['label'] }}">
                                            <span class="product-gallery__frame">
                                                <img src="{{ asset($view['src']) }}" alt="{{ $product->title }} — {{ $view['label'] }}">
                                            </span>
                                            <span class="product-gallery__caption">{{ $view['label'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                                <p class="product-gallery__hint">Cliquez sur une vue pour l’agrandir.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shop-left pt-30">
                            <div class="shop-content">
                                @if($product->category)<p class="product-card__cat">{{ $product->category->name }}</p>@endif
                                <h3>{{ $product->title }}</h3>
                                @include('partials.product-price', ['product' => $product, 'size' => 'product-price--lg'])
                                @if($product->description)
                                    <p class="shop-content__desc">{!! nl2br(e($product->description)) !!}</p>
                                @endif
                                @if($product->content)
                                    <div class="shop-content__body">{!! $product->content !!}</div>
                                @endif
                                @if(session('success'))<div class="alert alert-success mt-20">{{ session('success') }}</div>@endif
                                @if(session('error'))<div class="alert alert-danger mt-20">{{ session('error') }}</div>@endif
                                @if(($product->stock_quantity ?? 0) > 0)
                                    @include('partials.add-to-cart', [
                                        'type' => 'product',
                                        'id' => $product->id,
                                        'showQty' => true,
                                        'max' => $product->stock_quantity,
                                        'label' => 'Ajouter au panier',
                                    ])
                                @else
                                    <p class="mt-20 shop-stock-out">Rupture de stock</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
