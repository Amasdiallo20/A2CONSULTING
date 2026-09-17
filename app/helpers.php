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
