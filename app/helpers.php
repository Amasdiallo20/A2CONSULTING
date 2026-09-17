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
