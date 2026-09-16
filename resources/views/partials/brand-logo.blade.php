@php
    $label = $label ?? ((isset($site) && $site ? $site->site_name : null) ?: 'A2 Consulting');
    $href = $href ?? route('home');
    $variant = $variant ?? '';
@endphp
<a href="{{ $href }}" class="brand-logo {{ $variant }}">
    <img class="brand-logo__mark" src="{{ asset('images/logo-mark.png') }}?v=4" alt="">
    <span class="brand-logo__copy">
        <span class="brand-logo__text">{{ $label }}</span>
        <span class="brand-logo__slogan">Formation &amp; Services</span>
    </span>
</a>
