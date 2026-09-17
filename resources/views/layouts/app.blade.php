<!doctype html>
<html lang="fr">
<head>
   
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', share_plain_text($site?->about_text, 160) ?: ($site?->site_name ?? 'A2 Consulting'))">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    @php
        $ogTitle = trim($__env->yieldContent('title', $site?->site_name ?? 'A2 Consulting'));
        $ogDescription = trim($__env->yieldContent('meta_description', share_plain_text($site?->about_text, 160) ?: ($site?->site_name ?? 'A2 Consulting')));
        $ogImage = trim($__env->yieldContent('og_image', share_asset_url($site?->logoUrl() ?? 'images/logo.png')));
        $ogType = trim($__env->yieldContent('og_type', 'website'));
        $ogUrl = trim($__env->yieldContent('canonical', url()->current()));
    @endphp
    <meta property="og:locale" content="fr_FR">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:site_name" content="{{ $site?->site_name ?? 'A2 Consulting' }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    
    <!--====== Title ======-->
    <title>@yield('title', $site?->site_name ?? 'A2 Consulting')</title>
    
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset($site?->faviconUrl() ?? 'images/favicon.png') }}" type="image/png">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">

    <!--====== Animate css ======-->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    
    <!--====== Nice Select css ======-->
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    
    <!--====== Nice Number css ======-->
    <link rel="stylesheet" href="{{ asset('css/jquery.nice-number.min.css') }}">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    
    <!--====== Fontawesome css ======-->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{ asset('css/default.css') }}">
    
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=brand5">
    
    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site-mobile.css') }}?v=m15">
  
    @stack('styles')
    <style>
        :root {
            --primary-color: #0168a3;
            --secondary-color: #ebae62;
        }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            max-width: 100%;
        }
        .brand-logo:hover,
        .brand-logo:focus {
            text-decoration: none;
        }
        .brand-logo__mark {
            height: 49px;
            width: auto;
            max-height: 49px;
            filter: none;
        }
        .brand-logo__copy {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            line-height: 1.15;
        }
        .brand-logo__text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #1d2025;
            white-space: nowrap;
        }
        .brand-logo__slogan {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 10px;
            letter-spacing: 0.04em;
            text-transform: none;
            color: #6b7c90;
            margin-top: 2px;
            white-space: nowrap;
        }
        .brand-logo--light .brand-logo__mark {
            filter: brightness(0) invert(1);
        }
        .brand-logo--light .brand-logo__text {
            color: #fff;
        }
        .brand-logo--light .brand-logo__slogan {
            color: rgba(255, 255, 255, 0.85);
        }
        .header-logo-support .logo img,
        .footer-about .logo img {
            height: 49px;
            width: auto;
            max-width: 100%;
        }
        .product-card {
            overflow: hidden;
            border-radius: 16px;
            padding: 12px;
            box-shadow: 0 8px 28px rgba(1, 104, 163, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 36px rgba(1, 104, 163, 0.14);
        }
        .product-card .image {
            overflow: hidden;
            border-radius: 12px;
        }
        .product-card .image img {
            height: 210px;
            object-fit: cover;
        }
        .product-card .cont {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            padding-top: 16px;
        }
        .product-card .cont .name,
        .product-card .cont .button {
            width: 100%;
        }
        .product-card .cont .name a h6 {
            font-size: 15px;
            line-height: 1.4;
            margin: 4px 0 10px;
            color: #0168a3;
        }
        .product-card__cat {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #6b7c90;
            margin-bottom: 0;
        }
        .product-price {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .product-price__old {
            font-size: 12px;
            color: #9aa6b4;
            text-decoration: line-through;
            white-space: nowrap;
        }
        .singel-publication .cont .name .product-price__old {
            font-size: 12px;
            color: #9aa6b4;
        }
        .product-price__row {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 6px 8px;
        }
        .product-price__amount,
        .singel-publication .cont .name .product-price__amount {
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: #0168a3;
            line-height: 1.1;
            white-space: nowrap;
        }
        .product-price__currency,
        .singel-publication .cont .name .product-price__currency {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #6b7c90;
            background: transparent;
            border-radius: 0;
            padding: 0;
            line-height: 1.2;
        }
        .product-price__badge,
        .singel-publication .cont .name .product-price__badge {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #0168a3;
            background: #ebae62;
            border-radius: 999px;
            padding: 3px 8px;
            text-decoration: none;
        }
        .product-price--lg {
            margin: 12px 0 18px;
        }
        .product-price--lg .product-price__amount {
            font-size: 32px;
        }
        .product-price--lg .product-price__currency {
            font-size: 13px;
            padding: 4px 10px;
        }
        .add-to-cart-form {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            width: 100%;
        }
        .add-to-cart-form--qty {
            flex-wrap: wrap;
            margin-top: 8px;
        }
        .qty-field {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            background: #f4f7fb;
            border: 1px solid #e4ebf3;
            border-radius: 999px;
            padding: 6px 8px 6px 14px;
        }
        .qty-field span {
            font-size: 12px;
            font-weight: 700;
            color: #6b7c90;
            text-transform: uppercase;
        }
        .qty-field input {
            width: 64px;
            height: 36px;
            border: 0;
            background: transparent;
            font-weight: 700;
            color: #0168a3;
            text-align: center;
            -moz-appearance: textfield;
            appearance: textfield;
        }
        .qty-field input::-webkit-outer-spin-button,
        .qty-field input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .btn-add-cart {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            border: 0;
            border-radius: 999px;
            background: #0168a3;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 700;
            line-height: 1;
            padding: 13px 18px;
            cursor: pointer;
            transition: background 0.25s ease, transform 0.2s ease, color 0.25s ease;
        }
        .btn-add-cart:hover {
            background: #ebae62;
            color: #0168a3;
        }
        .btn-add-cart i {
            font-size: 14px;
        }
        .shop-content .btn-add-cart {
            width: auto;
            min-width: 220px;
            padding: 16px 26px;
            font-size: 14px;
        }
        .shop-cart-icon {
            width: 42px;
            height: 42px;
            border: 1px solid #ebae62;
            border-radius: 50%;
            background: transparent;
            color: #ebae62;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.25s ease, color 0.25s ease;
        }
        .shop-cart-icon:hover {
            background: #ebae62;
            color: #0168a3;
        }
        .singel-publication .image .add-cart ul li a {
            width: 42px;
            height: 42px;
            line-height: 42px;
            border-radius: 50%;
        }
        .singel-publication .image .add-cart form {
            display: inline;
        }
        .shop-content__desc {
            color: #5b6b7c;
            margin-top: 8px;
        }
        .shop-stock-out {
            display: inline-block;
            background: #fdecec;
            color: #b42318;
            font-weight: 700;
            border-radius: 999px;
            padding: 8px 14px;
        }
        .form-singel input,
        .form-singel textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        .singel-course .thum .price span,
        .singel-course-2 > .thum .price span {
            display: inline-block;
            width: auto !important;
            height: auto !important;
            min-width: 0;
            line-height: 1.25 !important;
            padding: 10px 12px;
            border-radius: 24px;
            white-space: nowrap;
            font-size: 12px;
        }
        @media (min-width: 992px) {
            .navigation .navbar {
                justify-content: center;
            }
            .navigation .navbar-collapse {
                justify-content: center;
            }
            .navigation .navbar .navbar-nav {
                flex-wrap: nowrap;
                align-items: center;
                justify-content: center;
                width: 100%;
            }
            .navigation .navbar .navbar-nav li {
                margin-right: 28px;
            }
            .navigation .navbar .navbar-nav li:last-child {
                margin-right: 0;
            }
            .navigation .navbar .navbar-nav li a {
                font-size: 14px;
                white-space: nowrap;
            }
        }
        @media (min-width: 1200px) {
            .navigation .navbar .navbar-nav li {
                margin-right: 36px;
            }
        }
    </style>
</head>

<body>
   
    <!--====== HEADER PART START ======-->
    
    <header id="header-part">
       
        <div class="header-top d-none d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header-contact text-lg-left text-center">
                            <ul>
                                @if($site?->address)
                                <li><img src="{{ asset('images/all-icon/map.png') }}" alt="icon"><span>{{ $site->address }}</span></li>
                                @endif
                                @if($site?->email)
                                <li><img src="{{ asset('images/all-icon/email.png') }}" alt="icon"><span>{{ $site->email }}</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="header-opening-time text-lg-right text-center">
                            <p>{{ $site?->opening_hours }}</p>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- header top -->
        
        <div class="header-logo-support pt-30 pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="logo">
                            @include('partials.brand-logo')
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="support-button float-right d-none d-md-block">
                            <div class="support float-left">
                                <div class="icon">
                                    <img src="{{ asset('images/all-icon/support.png') }}" alt="icon">
                                </div>
                                <div class="cont">
                                    <p>Besoin d'aide ? Appelez-nous</p>
                                    <span>{{ $site?->phone }}</span>
                                </div>
                            </div>
                            <div class="button float-left">
                                <a href="{{ route('contact') }}" class="main-btn">Nous contacter</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- header logo support -->
        
        <div class="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-9 col-8">
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul class="navbar-nav mx-auto">
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">Formations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">À propos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">Événements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('shop.*') ? 'active' : '' }}" href="{{ route('shop.index') }}">Boutique</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </nav> <!-- nav -->
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                        <div class="right-icon text-right">
                            <ul>
                                <li><a href="#" id="search"><i class="fa fa-search"></i></a></li>
                                <li>
                                    <a href="{{ route('cart.index') }}">
                                        <i class="fa fa-shopping-bag"></i>
                                        <span>{{ $cartCount ?? 0 }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div> <!-- right icon -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
        
    </header>
    
    <!--====== HEADER PART ENDS ======-->
   
    <!--====== SEARCH BOX PART START ======-->
    
    <div class="search-box">
        <div class="serach-form">
            <div class="closebtn">
                <span></span>
                <span></span>
            </div>
            <form action="{{ route('courses.index') }}" method="GET">
                <input type="text" name="q" placeholder="Rechercher une formation" value="{{ request('q') }}">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div> <!-- serach form -->
    </div>
    
    <!--====== SEARCH BOX PART ENDS ======-->
   
    <!--====== CONTENT PART START ======-->
    
    @yield('content')
    
    <!--====== CONTENT PART ENDS ======-->
   
    <!--====== FOOTER PART START ======-->
    
    <footer id="footer-part">
        <div class="footer-top pt-40 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-about mt-40">
                            <div class="logo">
                                @include('partials.brand-logo', ['variant' => 'brand-logo--light'])
                            </div>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($site?->about_text), 180) }}</p>
                            <ul class="mt-20">
                                @if($site?->facebook)<li><a href="{{ $site->facebook }}"><i class="fa fa-facebook-f"></i></a></li>@endif
                                @if($site?->twitter)<li><a href="{{ $site->twitter }}"><i class="fa fa-twitter"></i></a></li>@endif
                                @if($site?->instagram)<li><a href="{{ $site->instagram }}"><i class="fa fa-instagram"></i></a></li>@endif
                                @if($site?->linkedin)<li><a href="{{ $site->linkedin }}"><i class="fa fa-linkedin"></i></a></li>@endif
                            </ul>
                        </div> <!-- footer about -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-link mt-40">
                            <div class="footer-title pb-25">
                                <h6>Plan du site</h6>
                            </div>
                            <ul>
                                <li><a href="{{ route('home') }}"><i class="fa fa-angle-right"></i>Accueil</a></li>
                                <li><a href="{{ route('courses.index') }}"><i class="fa fa-angle-right"></i>Formations</a></li>
                                <li><a href="{{ route('services.index') }}"><i class="fa fa-angle-right"></i>Services</a></li>
                                <li><a href="{{ route('about') }}"><i class="fa fa-angle-right"></i>À propos</a></li>
                            </ul>
                            <ul>
                                <li><a href="{{ route('events.index') }}"><i class="fa fa-angle-right"></i>Événements</a></li>
                                <li><a href="{{ route('blog.index') }}"><i class="fa fa-angle-right"></i>Blog</a></li>
                                <li><a href="{{ route('shop.index') }}"><i class="fa fa-angle-right"></i>Boutique</a></li>
                                <li><a href="{{ route('contact') }}"><i class="fa fa-angle-right"></i>Contact</a></li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-link support mt-40">
                            <div class="footer-title pb-25">
                                <h6>Assistance</h6>
                            </div>
                            <ul>
                                <li><a href="{{ route('contact') }}"><i class="fa fa-angle-right"></i>Contact</a></li>
                            </ul>
                        </div> <!-- support -->
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-address mt-40">
                            <div class="footer-title pb-25">
                                <h6>Nous contacter</h6>
                            </div>
                            <ul>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="cont">
                                        <p>{{ $site?->address }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="cont">
                                        <p>{{ $site?->phone }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="cont">
                                        <p>{{ $site?->email }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div> <!-- footer address -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer top -->
        
        <div class="footer-copyright pt-10 pb-25">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="copyright text-md-left text-center pt-15">
                            <p>&copy; {{ date('Y') }} {{ $site?->site_name ?? 'A2 Consulting' }}. Tous droits réservés.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="copyright text-md-right text-center pt-15">
                           
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer copyright -->
    </footer>
    
    <!--====== FOOTER PART ENDS ======-->
   
    <!--====== BACK TO TP PART START ======-->
    
    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
    
    <!--====== BACK TO TP PART ENDS ======-->
   
    <!--====== jquery js ======-->
    <script src="{{ asset('js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>

    <!--====== Bootstrap js ======-->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    
    <!--====== Slick js ======-->
    <script src="{{ asset('js/slick.min.js') }}"></script>
    
    <!--====== Magnific Popup js ======-->
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    
    <!--====== Counter Up js ======-->
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    
    <!--====== Nice Select js ======-->
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    
    <!--====== Nice Number js ======-->
    <script src="{{ asset('js/jquery.nice-number.min.js') }}"></script>
    
    <!--====== Count Down js ======-->
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    
    <!--====== Validator js ======-->
    <script src="{{ asset('js/validator.min.js') }}"></script>
    
    <!--====== Ajax Contact js ======-->
    <script src="{{ asset('js/ajax-contact.js') }}"></script>
    
    <!--====== Main js ======-->
    <script src="{{ asset('js/main.js') }}?v=m11"></script>
    <script>
    (function () {
        document.querySelectorAll('[data-share-native]').forEach(function (button) {
            if (navigator.share) {
                button.hidden = false;
            }
        });

        function feedback(root, message) {
            if (!root) return;
            var el = root.querySelector('[data-share-feedback]');
            if (!el) return;
            el.hidden = false;
            el.textContent = message;
            window.setTimeout(function () {
                el.hidden = true;
            }, 3500);
        }

        function copyLink(url, root, instagram) {
            var done = function () {
                feedback(root, instagram
                    ? 'Lien copié. Ouvrez Instagram et collez-le dans une story ou un message.'
                    : 'Lien copié. Vous pouvez le coller où vous voulez.');
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(done).catch(function () {
                    window.prompt('Copiez ce lien :', url);
                });
                return;
            }
            window.prompt('Copiez ce lien :', url);
            done();
        }

        document.addEventListener('click', function (event) {
            var copyBtn = event.target.closest('[data-share-copy]');
            if (copyBtn) {
                event.preventDefault();
                copyLink(
                    copyBtn.getAttribute('data-share-copy'),
                    copyBtn.closest('[data-share-bar]'),
                    copyBtn.getAttribute('data-share-instagram') === '1'
                );
                return;
            }

            var nativeBtn = event.target.closest('[data-share-native]');
            if (nativeBtn && navigator.share) {
                event.preventDefault();
                navigator.share({
                    title: nativeBtn.getAttribute('data-share-title') || document.title,
                    text: nativeBtn.getAttribute('data-share-text') || '',
                    url: nativeBtn.getAttribute('data-share-url') || window.location.href
                }).catch(function () {});
            }
        });
    })();
    </script>
    
    @stack('scripts')
</body>
</html>

