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
                    <div style="background:#fff;padding:30px;border-radius:8px;">
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

                            <h4 class="mt-40">Paiement Mobile Money</h4>
                            <p class="mb-0"><small>Choisissez l’opérateur et le numéro qui enverra l’argent.</small></p>
                            <div class="row mt-20">
                                @foreach(['orange' => 'Orange Money', 'mtn' => 'MTN Mobile Money', 'moov' => 'Moov Money'] as $value => $label)
                                <div class="col-md-4 mb-2">
                                    <label style="display:block;border:1px solid #ddd;border-radius:8px;padding:12px;cursor:pointer;">
                                        <input type="radio" name="payment_operator" value="{{ $value }}" {{ old('payment_operator', 'orange') === $value ? 'checked' : '' }} required>
                                        <strong>{{ $label }}</strong>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="form-singel mt-20">
                                <input type="text" name="momo_phone" placeholder="Numéro Mobile Money *" value="{{ old('momo_phone') }}" required>
                            </div>

                            <div class="form-singel mt-30">
                                <button type="submit" class="main-btn">Payer par Mobile Money</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div style="background:#fff;padding:30px;border-radius:8px;">
                        <h4>Récapitulatif</h4>
                        <ul class="mt-20">
                            @foreach($items as $item)
                                <li class="mb-2">
                                    {{ $item['title'] }}
                                    <small>({{ $item['type'] === 'course' ? 'Formation' : 'Produit' }} × {{ $item['quantity'] }})</small>
                                    <strong class="float-right">{{ number_format($item['unit_price'] * $item['quantity'], 2) }} GNF</strong>
                                </li>
                            @endforeach
                        </ul>
                        <hr>
                        <h5>Total : {{ number_format($total, 2) }} GNF</h5>
                        <p class="mt-20"><small>Après validation, vous recevrez les instructions pour payer via Orange Money, MTN ou Moov.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
