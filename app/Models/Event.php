<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'venue',
        'capacity',
        'registered_count',
        'price',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'price' => 'integer',
        'capacity' => 'integer',
        'registered_count' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function formattedStartTime(): ?string
    {
        return $this->formatClock($this->getRawOriginal('start_time') ?? $this->attributes['start_time'] ?? null);
    }

    public function formattedEndTime(): ?string
    {
        return $this->formatClock($this->getRawOriginal('end_time') ?? $this->attributes['end_time'] ?? null);
    }

    public function formattedTimeRange(): ?string
    {
        $start = $this->formattedStartTime();
        if (! $start) {
            return null;
        }

        $end = $this->formattedEndTime();

        return $end ? $start.' - '.$end : $start;
    }

    public function placeLabel(): ?string
    {
        $parts = array_filter([$this->location, $this->venue]);

        return $parts ? implode(' — ', array_unique($parts)) : null;
    }

    private function formatClock(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            return Carbon::parse($value)->format('H:i');
        } catch (\Throwable) {
            $text = (string) $value;

            return strlen($text) >= 5 ? substr($text, -8, 5) : $text;
        }
    }

    /**
     * Scope a query to only include active events.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured events.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->whereDate('event_date', '>=', now()->toDateString());
    }

    /**
     * Scope a query to only include past events.
     */
    public function scopePast($query)
    {
        return $query->where('event_date', '<', now());
    }
}
