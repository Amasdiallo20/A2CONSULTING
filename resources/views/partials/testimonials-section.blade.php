@if(isset($testimonials) && $testimonials->isNotEmpty())
<section class="trust-section trust-section--quotes" id="temoignages">
    <div class="container">
        <div class="trust-section__intro">
            <p class="trust-section__eyebrow">Ils nous font confiance</p>
            <h2>Témoignages clients</h2>
            <p class="trust-section__lead">Des retours concrets de professionnels formés ou accompagnés par A2 Consulting.</p>
        </div>
        <div class="quote-grid">
            @foreach($testimonials as $item)
            <article class="quote-card {{ $loop->first ? 'quote-card--featured' : '' }}">
                <div class="quote-card__mark" aria-hidden="true">“</div>
                <div class="quote-card__stars" aria-label="Note {{ $item->rating }} sur 5">
                    @for($star = 1; $star <= 5; $star++)
                        <i class="fa {{ $star <= $item->rating ? 'fa-star' : 'fa-star-o' }}"></i>
                    @endfor
                </div>
                <p class="quote-card__text">{{ $item->quote }}</p>
                <div class="quote-card__person">
                    @if($item->photo)
                        <img src="{{ asset($item->photo) }}" alt="">
                    @else
                        <span class="quote-card__avatar">{{ $item->initials() }}</span>
                    @endif
                    <div>
                        <strong>{{ $item->client_name }}</strong>
                        @if($item->roleLine())
                            <span>{{ $item->roleLine() }}</span>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
