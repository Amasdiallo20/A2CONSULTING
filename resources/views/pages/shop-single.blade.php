@extends('layouts.app')
@section('title', $product->title)
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $product->title, 'bannerImage' => 'images/page-banner-5.jpg'])

    <section id="shop-singel" class="pt-120 pb-120 gray-bg">
        <div class="container">
            <div class="shop-destails">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="shop-left pt-30">
                            <div class="shop-image">
                                <img src="{{ asset($product->image ?: 'images/shop-singel/ss-1.jpg') }}" alt="{{ $product->title }}">
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
