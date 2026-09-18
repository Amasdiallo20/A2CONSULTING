<?php

function integer_price(mixed $amount): int
{
    if ($amount === null || $amount === '') {
        return 0;
    }

    return (int) round((float) $amount);
}

function format_price(mixed $amount): string
{
    return number_format(integer_price($amount), 0, ',', ' ').' GNF';
}

function course_listing_url(array $overrides = []): string
{
    $query = request()->only(['category', 'mode', 'q']);

    foreach ($overrides as $key => $value) {
        if ($value === null || $value === '') {
            unset($query[$key]);
        } else {
            $query[$key] = $value;
        }
    }

    return route('courses.index', array_filter($query, fn ($value) => $value !== null && $value !== ''));
}

function share_asset_url(?string $path = null): string
{
    $path = $path ?: 'images/logo.png';

    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }

    return asset(ltrim($path, '/'));
}

function share_plain_text(?string $value, int $limit = 180): string
{
    $text = html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = trim(preg_replace('/\s+/', ' ', $text) ?: '');

    return $text === '' ? '' : \Illuminate\Support\Str::limit($text, $limit);
}
