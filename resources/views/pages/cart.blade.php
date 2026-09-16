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
                <div class="text-center">
                    <p>Votre panier est vide.</p>
                    <a href="{{ route('shop.index') }}" class="main-btn">Voir la boutique</a>
                    <a href="{{ route('courses.index') }}" class="main-btn main-btn-2">Voir les formations</a>
                </div>
            @else
                <div class="table-responsive" style="background:#fff;padding:30px;border-radius:8px;">
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
                                <td>{{ number_format($item['unit_price'], 2) }} GNF</td>
                                <td>
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="key" value="{{ $item['key'] }}">
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?: 20 }}" style="width:70px" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>{{ number_format($item['unit_price'] * $item['quantity'], 2) }} GNF</td>
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
                    <div class="text-right">
                        <h4>Total : {{ number_format($total, 2) }} GNF</h4>
                        <a href="{{ route('shop.index') }}" class="main-btn main-btn-2">Continuer mes achats</a>
                        <a href="{{ route('checkout.show') }}" class="main-btn">Commander</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
