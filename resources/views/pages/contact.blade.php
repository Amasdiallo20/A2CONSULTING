@extends('layouts.app')
@section('title', 'Contact')
@section('meta_description', 'Contactez A2 Consulting à Conakry : formation, conseil et accompagnement.')
@section('og_image', share_asset_url($site?->pageBanner('contact') ?? 'images/page-banner-1.jpg'))
@section('canonical', route('contact'))
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Contact', 'subtitle' => 'Une question ? Écrivons-nous', 'bannerKey' => 'contact'])

    <section id="contact-page" class="pt-90 pb-120 gray-bg">
        <div class="container">
            @include('partials.share-bar', [
                'url' => route('contact'),
                'title' => 'Contact A2 Consulting',
                'text' => 'Contactez A2 Consulting pour vos formations et services.',
                'compact' => true,
            ])
            <div class="row">
                <div class="col-lg-7">
                    <div class="contact-from mt-30">
                        <div class="section-title">
                            <h5>Contact</h5>
                            <h2>Écrivez-nous</h2>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success mt-20" role="alert">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger mt-20" role="alert">
                                Veuillez corriger les champs indiqués ci-dessous.
                            </div>
                        @endif
                        <div class="main-form pt-45">
                            <form id="contact-form" action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <p class="form-message" role="status"></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="singel-form form-group">
                                            <input name="name" type="text" placeholder="Votre nom" value="{{ old('name') }}" required maxlength="255" autocomplete="name">
                                            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="singel-form form-group">
                                            <input name="email" type="email" placeholder="Email" value="{{ old('email') }}" required maxlength="255" autocomplete="email">
                                            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="singel-form form-group">
                                            <input name="subject" type="text" placeholder="Sujet" value="{{ old('subject', request('sujet')) }}" maxlength="255">
                                            @error('subject')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="singel-form form-group">
                                            <input name="phone" type="text" placeholder="Téléphone" value="{{ old('phone') }}" maxlength="255" autocomplete="tel">
                                            @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="singel-form form-group">
                                            <textarea name="message" placeholder="Message" required minlength="5">{{ old('message') }}</textarea>
                                            @error('message')<div class="text-danger">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="singel-form">
                                            <button type="submit" class="main-btn">Envoyer</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="contact-address mt-30">
                        <ul>
                            @if($site->address)
                            <li>
                                <div class="singel-address">
                                    <div class="icon"><i class="fa fa-home"></i></div>
                                    <div class="cont"><p>{{ $site->address }}</p></div>
                                </div>
                            </li>
                            @endif
                            @if($site->phone)
                            <li>
                                <div class="singel-address">
                                    <div class="icon"><i class="fa fa-phone"></i></div>
                                    <div class="cont"><p>{{ $site->phone }}</p></div>
                                </div>
                            </li>
                            @endif
                            @if($site->email)
                            <li>
                                <div class="singel-address">
                                    <div class="icon"><i class="fa fa-envelope-o"></i></div>
                                    <div class="cont"><p>{{ $site->email }}</p></div>
                                </div>
                            </li>
                            @endif
                            @if($site->opening_hours)
                            <li>
                                <div class="singel-address">
                                    <div class="icon"><i class="fa fa-clock-o"></i></div>
                                    <div class="cont"><p>{{ $site->opening_hours }}</p></div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
