<form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form {{ $class ?? '' }} {{ !empty($showQty) ? 'add-to-cart-form--qty' : '' }}">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="id" value="{{ $id }}">
    @if(!empty($showQty))
        <label class="qty-field">
            <span>Qté</span>
            <input type="number" name="quantity" value="1" min="1" max="{{ $max ?? 10 }}" aria-label="Quantité">
        </label>
    @endif
    <button type="submit" class="{{ $btnClass ?? 'btn-add-cart' }}">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        @if(($label ?? null) !== '')
            <span>{{ $label ?? 'Ajouter au panier' }}</span>
        @endif
    </button>
</form>
