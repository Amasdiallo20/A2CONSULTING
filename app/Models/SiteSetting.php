<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'phone',
        'email',
        'address',
        'opening_hours',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'hero_button_text',
        'hero_button_url',
        'about_title',
        'about_text',
        'about_image',
        'orange_money_number',
        'mtn_money_number',
        'moov_money_number',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'A2 Consulting',
                'hero_title' => 'A2 Consulting',
                'about_title' => 'À propos',
            ]
        );
    }

    public function mobileMoneyNumber(?string $operator): ?string
    {
        $number = match ($operator) {
            'orange' => $this->orange_money_number,
            'mtn' => $this->mtn_money_number,
            'moov' => $this->moov_money_number,
            default => null,
        };

        return $number ?: $this->phone;
    }
}
