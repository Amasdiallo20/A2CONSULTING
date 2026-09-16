@php
    $hasSale = !empty($product->sale_price) && (float) $product->sale_price > 0 && (float) $product->sale_price < (float) $product->price;
    $amount = $hasSale ? $product->sale_price : $product->price;
@endphp
<div class="product-price {{ $size ?? '' }}">
    @if($hasSale)
        <span class="product-price__old">{{ number_format($product->price, 0, ',', ' ') }}&nbsp;GNF</span>
        <span class="product-price__row">
            <span class="product-price__amount">{{ number_format($amount, 0, ',', ' ') }}</span>
            <span class="product-price__currency">GNF</span>
            <span class="product-price__badge">Promo</span>
        </span>
    @else
        <span class="product-price__row">
            <span class="product-price__amount">{{ number_format($amount, 0, ',', ' ') }}</span>
            <span class="product-price__currency">GNF</span>
        </span>
    @endif
</div>
