@extends('layouts.app')

@section('title', 'Boutique - A2 Consulting')

@section('content')

    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Boutique', 'subtitle' => 'Supports, produits et ressources', 'bannerKey' => 'shop'])

    <section id="shop-page" class="pt-120 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
                    <div class="shop-top-search">
                        <div class="shop-bar">
                            <ul class="nav">
                                <li class="nav-item">
                                    Affichage de {{ $products->count() }} sur {{ $products->total() }} résultats
                                </li>
                            </ul>
                        </div>
                        <div class="shop-select">
                            <form method="GET" action="{{ route('shop.index') }}">
                                <select name="category" class="js-auto-submit" onchange="this.form.submit()">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @forelse($products as $product)
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
                                    @if($product->category)
                                        <small class="product-card__cat">{{ $product->category->name }}</small>
                                    @endif
                                    <a href="{{ route('shop.show', $product->id) }}"><h6>{{ $product->title }}</h6></a>
                                    @include('partials.product-price', ['product' => $product])
                                </div>
                                <div class="button">
                                    @include('partials.add-to-cart', ['type' => 'product', 'id' => $product->id, 'label' => 'Ajouter'])
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center mt-40">Aucun produit dans cette catégorie pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="mt-40">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
