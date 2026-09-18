@if($product->hasDemoAccess())
    @php
        $demoUrl = $product->demoUrl();
        $demoHost = $demoUrl ? (parse_url($demoUrl, PHP_URL_HOST) ?: $demoUrl) : null;
    @endphp
    <section class="software-demo" data-software-demo>
        <div class="software-demo__head">
            <p class="software-demo__kicker">Accès démo</p>
            <h4>Testez {{ $product->name }} en ligne</h4>
            <p>Un espace de démonstration est ouvert. Connectez-vous avec les identifiants ci-dessous, sans engagement.</p>
        </div>

        @if($demoUrl)
            <a class="software-demo__cta" href="{{ $demoUrl }}" target="_blank" rel="noopener noreferrer">
                <span>Ouvrir la démo</span>
                @if($demoHost)<small>{{ $demoHost }}</small>@endif
            </a>
        @endif

        @if($product->demo_login || $product->demo_password)
            <div class="software-demo__creds">
                @if($product->demo_login)
                    <div class="software-demo__row">
                        <span class="software-demo__label">Identifiant</span>
                        <code data-copy-value="{{ $product->demo_login }}">{{ $product->demo_login }}</code>
                        <button type="button" class="software-demo__copy" data-copy aria-label="Copier l’identifiant">Copier</button>
                    </div>
                @endif
                @if($product->demo_password)
                    <div class="software-demo__row">
                        <span class="software-demo__label">Mot de passe</span>
                        <code data-copy-value="{{ $product->demo_password }}" data-secret>{{ $product->demo_password }}</code>
                        <button type="button" class="software-demo__toggle" data-toggle-secret aria-label="Afficher le mot de passe">Afficher</button>
                        <button type="button" class="software-demo__copy" data-copy aria-label="Copier le mot de passe">Copier</button>
                    </div>
                @endif
            </div>
        @endif

        <p class="software-demo__note">Compte de démonstration — données fictives, à usage de test uniquement.</p>
    </section>
@endif
