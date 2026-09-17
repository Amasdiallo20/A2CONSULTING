@php
    $hasSale = $product->hasPromo();
    $amount = $product->sellingPrice();
@endphp
<div class="product-price {{ $size ?? '' }}">
    @if($hasSale)
        <span class="product-price__old">{{ format_price($product->price) }}</span>
        <span class="product-price__row">
            <span class="product-price__amount">{{ number_format(integer_price($amount), 0, ',', ' ') }}</span>
            <span class="product-price__currency">GNF</span>
            <span class="product-price__badge">Promo</span>
        </span>
    @else
        <span class="product-price__row">
            <span class="product-price__amount">{{ number_format(integer_price($amount), 0, ',', ' ') }}</span>
            <span class="product-price__currency">GNF</span>
        </span>
    @endif
</div>
