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
                                    <form action="{{ route('cart.update') }}" method="POST" class="d-inline js-cart-qty-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="key" value="{{ $item['key'] }}">
                                        <input
                                            type="number"
                                            name="quantity"
                                            class="js-cart-qty"
                                            data-line="{{ $item['key'] }}"
                                            data-unit="{{ integer_price($item['unit_price']) }}"
                                            value="{{ $item['quantity'] }}"
                                            min="1"
                                            max="{{ $item['stock'] ?: 20 }}"
                                            style="width:70px"
                                        >
                                    </form>
                                </td>
                                <td class="js-line-total" data-line-total="{{ $item['key'] }}">{{ format_price($item['unit_price'] * $item['quantity']) }}</td>
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
                            <form action="{{ route('cart.update') }}" method="POST" class="js-cart-qty-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="key" value="{{ $item['key'] }}">
                                <input
                                    type="number"
                                    name="quantity"
                                    class="js-cart-qty"
                                    data-line="{{ $item['key'] }}"
                                    data-unit="{{ integer_price($item['unit_price']) }}"
                                    value="{{ $item['quantity'] }}"
                                    min="1"
                                    max="{{ $item['stock'] ?: 20 }}"
                                >
                            </form>
                        </div>
                        <div class="cart-card__row">
                            <span>Total</span>
                            <strong class="js-line-total" data-line-total="{{ $item['key'] }}">{{ format_price($item['unit_price'] * $item['quantity']) }}</strong>
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
                    <h4 class="js-cart-grand-total">Total : {{ format_price($total) }}</h4>
                    <a href="{{ route('shop.index') }}" class="main-btn main-btn-2">Continuer mes achats</a>
                    <a href="{{ route('checkout.show') }}" class="main-btn">Commander</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function () {
    function formatGnf(value) {
        return Math.round(Number(value) || 0).toLocaleString('fr-FR') + ' GNF';
    }

    function clamp(input) {
        var min = parseInt(input.min, 10);
        var max = parseInt(input.max, 10);
        var qty = parseInt(input.value, 10);

        if (isNaN(qty) || qty < min) {
            qty = min || 1;
        }
        if (!isNaN(max) && qty > max) {
            qty = max;
        }

        input.value = qty;
        return qty;
    }

    function refreshTotals(source) {
        if (source) {
            var sourceKey = source.getAttribute('data-line');
            var sourceQty = clamp(source);
            document.querySelectorAll('.js-cart-qty[data-line="' + sourceKey + '"]').forEach(function (el) {
                el.value = sourceQty;
            });
        }

        var total = 0;
        var seen = {};

        document.querySelectorAll('.js-cart-qty').forEach(function (input) {
            var key = input.getAttribute('data-line');
            if (seen[key]) {
                return;
            }
            seen[key] = true;

            var qty = parseInt(input.value, 10) || 1;
            var unit = parseInt(input.getAttribute('data-unit'), 10) || 0;
            var line = unit * qty;
            total += line;

            document.querySelectorAll('[data-line-total="' + key + '"]').forEach(function (el) {
                el.textContent = formatGnf(line);
            });
        });

        document.querySelectorAll('.js-cart-grand-total').forEach(function (el) {
            el.textContent = 'Total : ' + formatGnf(total);
        });
    }

    var timers = {};

    document.querySelectorAll('.js-cart-qty').forEach(function (input) {
        input.addEventListener('input', function () {
            refreshTotals(input);

            var form = input.closest('form');
            if (!form) {
                return;
            }

            var key = input.getAttribute('data-line');
            clearTimeout(timers[key]);
            timers[key] = setTimeout(function () {
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            }, 250);
        });
    });
})();
</script>
@endpush
