<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SoftwareProduct extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'content',
        'image',
        'youtube_url',
        'screenshots',
        'demo_url',
        'demo_login',
        'demo_password',
        'modules',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'modules' => 'array',
        'screenshots' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * @return list<string>
     */
    public function moduleList(): array
    {
        $modules = $this->modules;

        if (! is_array($modules)) {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn ($item) => trim((string) $item),
            $modules
        )));
    }

    /**
     * @return list<string>
     */
    public function screenshotList(): array
    {
        $shots = $this->screenshots;

        if (! is_array($shots)) {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn ($item) => trim((string) $item),
            $shots
        )));
    }

    public function youtubeId(): ?string
    {
        return self::parseYoutubeId($this->youtube_url);
    }

    public function videoEmbedUrl(): ?string
    {
        $id = $this->youtubeId();
        if ($id) {
            return 'https://www.youtube-nocookie.com/embed/'.$id;
        }

        $facebook = self::facebookEmbedUrl($this->youtube_url);
        if ($facebook) {
            return $facebook;
        }

        return null;
    }

    public function youtubeEmbedUrl(): ?string
    {
        return $this->videoEmbedUrl();
    }

    public static function isValidVideoUrl(?string $url): bool
    {
        $url = trim((string) $url);

        return $url !== '' && (self::parseYoutubeId($url) || self::facebookEmbedUrl($url));
    }

    public static function facebookEmbedUrl(?string $url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $path = (string) parse_url($url, PHP_URL_PATH);
        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

        $isFacebook = str_contains($host, 'facebook.com')
            || $host === 'fb.com'
            || str_ends_with($host, '.fb.com')
            || $host === 'fb.watch'
            || str_ends_with($host, '.fb.watch');

        if (! $isFacebook) {
            return null;
        }

        if (str_contains($path, '/plugins/video.php') && ! empty($query['href'])) {
            return $url;
        }

        $href = $url;
        if (isset($query['v']) && is_numeric($query['v'])) {
            $href = 'https://www.facebook.com/watch/?v='.$query['v'];
        }

        return 'https://www.facebook.com/plugins/video.php?href='.rawurlencode($href).'&show_text=false&width=560&height=315';
    }

    public static function parseYoutubeId(?string $url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $url)) {
            return $url;
        }

        $host = parse_url($url, PHP_URL_HOST) ?: '';
        $path = parse_url($url, PHP_URL_PATH) ?: '';
        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

        if (isset($query['v']) && is_string($query['v']) && preg_match('/^[A-Za-z0-9_-]{11}$/', $query['v'])) {
            return $query['v'];
        }

        if (preg_match('#(?:youtu\.be/|/(?:embed|shorts|live|v)/)([A-Za-z0-9_-]{11})#', $url, $match)) {
            return $match[1];
        }

        if (str_contains($host, 'youtube') && preg_match('#/([A-Za-z0-9_-]{11})/?$#', $path, $match)) {
            return $match[1];
        }

        return null;
    }

    public function hasDemoAccess(): bool
    {
        return $this->demoUrl() !== null
            || filled($this->demo_login)
            || filled($this->demo_password);
    }

    public function demoUrl(): ?string
    {
        $url = trim((string) $this->demo_url);
        if ($url === '') {
            return null;
        }

        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://'.$url;
        }

        return $url;
    }

    public function demoSubject(): string
    {
        return 'Demande de démo '.$this->name;
    }

    public static function slugFromName(string $name, ?string $slug = null): string
    {
        $value = $slug !== null && $slug !== '' ? $slug : $name;

        return Str::slug($value) ?: 'logiciel';
    }
}
