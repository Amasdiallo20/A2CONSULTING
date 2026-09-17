<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const PAGE_BANNERS = [
        'about' => ['label' => 'À propos', 'default' => 'images/page-banner-1.jpg'],
        'courses' => ['label' => 'Formations', 'default' => 'images/page-banner-2.jpg'],
        'services' => ['label' => 'Services', 'default' => 'images/page-banner-1.jpg'],
        'events' => ['label' => 'Événements', 'default' => 'images/page-banner-3.jpg'],
        'teachers' => ['label' => 'Formateurs', 'default' => 'images/page-banner-3.jpg'],
        'blog' => ['label' => 'Actualités / Blog', 'default' => 'images/page-banner-4.jpg'],
        'shop' => ['label' => 'Boutique / Panier', 'default' => 'images/page-banner-5.jpg'],
        'contact' => ['label' => 'Contact', 'default' => 'images/page-banner-6.jpg'],
    ];

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
        'logo_image',
        'favicon_image',
        'about_bg_image',
        'banner_about',
        'banner_courses',
        'banner_services',
        'banner_events',
        'banner_teachers',
        'banner_blog',
        'banner_shop',
        'banner_contact',
        'orange_money_number',
        'mtn_money_number',
        'moov_money_number',
        'payment_provider',
        'payment_mode',
        'payment_currency',
        'payment_api_url',
        'payment_api_key',
        'payment_api_secret',
        'payment_site_id',
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

    public function pageBanner(string $key): string
    {
        $column = 'banner_'.$key;
        $custom = $this->{$column} ?? null;

        if (filled($custom)) {
            return $custom;
        }

        return self::PAGE_BANNERS[$key]['default'] ?? 'images/page-banner-1.jpg';
    }

    public function logoUrl(): string
    {
        return filled($this->logo_image) ? $this->logo_image : 'images/logo-mark.png';
    }

    public function faviconUrl(): string
    {
        return filled($this->favicon_image) ? $this->favicon_image : 'images/favicon.png';
    }

    public function aboutBgUrl(): string
    {
        return filled($this->about_bg_image) ? $this->about_bg_image : 'images/about/bg-1.png';
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

    public function usesManualPayment(): bool
    {
        return ($this->payment_provider ?: 'sandbox') === 'manual';
    }
}
