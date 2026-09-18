@php
    $compact = ! empty($compact);
@endphp
<article class="software-card {{ $compact ? 'software-card--home' : '' }}">
    <div class="software-card__media">
        <img src="{{ asset($product->image ?: 'images/course/cu-1.jpg') }}" alt="{{ $product->name }}">
    </div>
    <div class="software-card__body">
        <p class="software-card__name">{{ $product->name }}</p>
        <h3>{{ $product->tagline ?: $product->name }}</h3>
        @if($product->description)
            <p>{{ \Illuminate\Support\Str::limit($product->description, $compact ? 110 : 220) }}</p>
        @endif
        @if(! $compact && $product->moduleList())
            <ul class="software-card__mods">
                @foreach($product->moduleList() as $moduleName)
                    <li>{{ $moduleName }}</li>
                @endforeach
            </ul>
        @endif
        <a class="main-btn" href="{{ route('software.show', $product) }}">Découvrir</a>
    </div>
</article>
