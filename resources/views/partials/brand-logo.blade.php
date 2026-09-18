@php
    $brandName = $brandName ?? ((isset($site) && $site ? $site->site_name : null) ?: 'A2 Consulting');
    $href = $href ?? route('home');
    $variant = $variant ?? '';
@endphp
<a href="{{ $href }}" class="brand-logo {{ $variant }}">
    <img class="brand-logo__mark" src="{{ asset(($site?->logoUrl() ?? 'images/logo-mark.png')) }}" alt="{{ $brandName }}">
    <span class="brand-logo__copy">
        <span class="brand-logo__text">{{ $brandName }}</span>
        <span class="brand-logo__slogan">Formation &amp; Services</span>
    </span>
</a>
