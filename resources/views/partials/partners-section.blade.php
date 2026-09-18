@if(isset($partners) && $partners->isNotEmpty())
<section class="trust-section trust-section--partners" id="partenaires">
    <div class="container">
        <div class="partners-panel">
        <div class="trust-section__intro trust-section__intro--center">
            <p class="trust-section__eyebrow">Réseau</p>
            <h2>Nos partenaires</h2>
            <p class="trust-section__lead">Institutions, entreprises et organisations qui collaborent avec A2 Consulting.</p>
        </div>
        <div class="partner-grid">
            @foreach($partners as $partner)
                @if($partner->website_url)
                    <a class="partner-chip" href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer">
                        @if($partner->logo)
                            <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}">
                        @else
                            <span class="partner-chip__mark">{{ $partner->initials() }}</span>
                        @endif
                        <span class="partner-chip__name">{{ $partner->name }}</span>
                    </a>
                @else
                    <div class="partner-chip">
                        @if($partner->logo)
                            <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}">
                        @else
                            <span class="partner-chip__mark">{{ $partner->initials() }}</span>
                        @endif
                        <span class="partner-chip__name">{{ $partner->name }}</span>
                    </div>
                @endif
            @endforeach
        </div>
        </div>
    </div>
</section>
@endif
