@extends('layouts.app')
@section('title', 'Commande')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Finaliser la commande', 'bannerKey' => 'shop'])

    <section class="pt-90 pb-120 gray-bg">
        <div class="container">
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-lg-7">
                    <div style="background:#fff;padding:30px;border-radius:8px;" class="checkout-box">
                        <h4>Vos coordonnées</h4>
                        <form action="{{ route('checkout.store') }}" method="POST" class="mt-20">
                            @csrf
                            <div class="form-singel mt-20">
                                <input type="text" name="name" placeholder="Nom complet *" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-singel mt-20">
                                <input type="email" name="email" placeholder="Email *" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-singel mt-20">
                                <input type="text" name="phone" placeholder="Téléphone *" value="{{ old('phone') }}" required>
                            </div>
                            <div class="form-singel mt-20">
                                <input type="text" name="address" placeholder="Adresse de livraison / ville *" value="{{ old('address') }}" required>
                            </div>
                            <div class="form-singel mt-20">
                                <textarea name="notes" placeholder="Message (facultatif)" rows="4">{{ old('notes') }}</textarea>
                            </div>

                            @php $payMethod = old('payment_method', 'cash_on_delivery'); @endphp
                            <h4 class="mt-40">Mode de paiement</h4>
                            <p class="mb-0"><small>Choisissez comment régler votre commande.</small></p>
                            <div class="row mt-20 checkout-pay-methods">
                                <div class="col-12 col-md-6 mb-2">
                                    <label class="checkout-pay-card">
                                        <input type="radio" name="payment_method" value="cash_on_delivery" {{ $payMethod === 'cash_on_delivery' ? 'checked' : '' }} required>
                                        <span class="checkout-pay-card__title">Paiement à la livraison</span>
                                        <span class="checkout-pay-card__hint">Vous réglez en espèces ou Mobile Money à la réception.</span>
                                    </label>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <label class="checkout-pay-card">
                                        <input type="radio" name="payment_method" value="mobile_money" {{ $payMethod === 'mobile_money' ? 'checked' : '' }} required>
                                        <span class="checkout-pay-card__title">Paiement Mobile Money</span>
                                        <span class="checkout-pay-card__hint">Orange Money ou MTN — paiement immédiat.</span>
                                    </label>
                                </div>
                            </div>

                            <div id="js-momo-fields" class="checkout-momo-fields" @if($payMethod !== 'mobile_money') hidden @endif>
                                <h5 class="mt-30">Paiement Mobile Money</h5>
                                <p class="mb-0"><small>Choisissez l’opérateur et le numéro qui enverra l’argent.</small></p>
                                <div class="row mt-20">
                                    @foreach(['orange' => 'Orange Money', 'mtn' => 'MTN Mobile Money'] as $opValue => $opName)
                                    <div class="col-12 col-md-6 mb-2">
                                        <label class="checkout-pay-card checkout-pay-card--sm">
                                            <input type="radio" name="payment_operator" value="{{ $opValue }}" {{ old('payment_operator', 'orange') === $opValue ? 'checked' : '' }}>
                                            <strong>{{ $opName }}</strong>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-singel mt-20">
                                    <input type="text" name="momo_phone" placeholder="Numéro Mobile Money *" value="{{ old('momo_phone') }}">
                                </div>
                            </div>

                            <div class="form-singel mt-30">
                                <button type="submit" class="main-btn" id="js-checkout-submit">Confirmer la commande</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div style="background:#fff;padding:30px;border-radius:8px;" class="checkout-box">
                        <h4>Récapitulatif</h4>
                        <ul class="mt-20 checkout-recap">
                            @foreach($items as $item)
                                <li class="mb-2">
                                    {{ $item['title'] }}
                                    <small>({{ $item['type'] === 'course' ? 'Formation' : 'Produit' }} × {{ $item['quantity'] }})</small>
                                    <strong>{{ format_price($item['unit_price'] * $item['quantity']) }}</strong>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <h5>Total : {{ format_price($total) }}</h5>
                        <p class="mt-20"><small>Paiement à la livraison ou Mobile Money, au choix.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function () {
    var form = document.querySelector('.checkout-box form');
    if (!form) return;
    var momo = document.getElementById('js-momo-fields');
    var submit = document.getElementById('js-checkout-submit');

    function syncPay() {
        var method = (form.querySelector('input[name="payment_method"]:checked') || {}).value;
        var isMomo = method === 'mobile_money';
        if (momo) momo.hidden = !isMomo;
        form.querySelectorAll('input[name="payment_operator"]').forEach(function (el) {
            el.required = isMomo;
        });
        var phone = form.querySelector('input[name="momo_phone"]');
        if (phone) phone.required = isMomo;
        if (submit) submit.textContent = isMomo ? 'Payer par Mobile Money' : 'Confirmer la commande';
    }

    form.querySelectorAll('input[name="payment_method"]').forEach(function (el) {
        el.addEventListener('change', syncPay);
    });
    syncPay();
})();
</script>
@endpush
