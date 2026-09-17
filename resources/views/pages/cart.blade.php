@extends('layouts.app')
@section('title', 'Panier')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Panier', 'bannerKey' => 'shop'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            @if(empty($items))
                <div class="text-center cart-empty">
                    <p>Votre panier est vide.</p>
                    <a href="{{ route('shop.index') }}" class="main-btn">Voir la boutique</a>
                    <a href="{{ route('courses.index') }}" class="main-btn main-btn-2">Voir les formations</a>
                </div>
            @else
                <div class="cart-table-wrap" style="background:#fff;padding:30px;border-radius:8px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Type</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item['title'] }}</strong>
                                </td>
                                <td>{{ $item['type'] === 'course' ? 'Formation' : 'Produit' }}</td>
                                <td>{{ format_price($item['unit_price']) }}</td>
                                <td>
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="key" value="{{ $item['key'] }}">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?: 20 }}" style="width:70px" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>{{ format_price($item['unit_price'] * $item['quantity']) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="key" value="{{ $item['key'] }}">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Retirer</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cart-cards">
                    @foreach($items as $item)
                    <article class="cart-card">
                        <h3>{{ $item['title'] }}</h3>
                        <div class="cart-card__meta">
                            <span>{{ $item['type'] === 'course' ? 'Formation' : 'Produit' }}</span>
                            <strong>{{ format_price($item['unit_price']) }}</strong>
                        </div>
                        <div class="cart-card__row">
                            <span>Quantité</span>
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="key" value="{{ $item['key'] }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?: 20 }}" onchange="this.form.submit()">
                            </form>
                        </div>
                        <div class="cart-card__row">
                            <span>Total</span>
                            <strong>{{ format_price($item['unit_price'] * $item['quantity']) }}</strong>
                        </div>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="key" value="{{ $item['key'] }}">
                            <button type="submit" class="btn btn-outline-danger">Retirer</button>
                        </form>
                    </article>
                    @endforeach
                </div>

                <div class="cart-actions text-md-right mt-30" style="background:#fff;padding:20px;border-radius:8px;">
                    <h4>Total : {{ format_price($total) }}</h4>
                    <a href="{{ route('shop.index') }}" class="main-btn main-btn-2">Continuer mes achats</a>
                    <a href="{{ route('checkout.show') }}" class="main-btn">Commander</a>
                </div>
            @endif
        </div>
    </section>
@endsection
