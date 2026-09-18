<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'price',
        'price_type',
        'duration',
        'teacher_id',
        'category_id',
        'delivery_mode',
        'lessons_count',
        'quizzes_count',
        'students_count',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'lessons_count' => 'integer',
        'quizzes_count' => 'integer',
        'students_count' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Course $course) {
            $course->price = integer_price($course->price ?? 0);
            $course->price_type = $course->price_type === 'paid' ? 'paid' : 'free';

            if ($course->price_type === 'free') {
                $course->price = 0;
            }
        });
    }

    public function isFree(): bool
    {
        return $this->price_type === 'free' || integer_price($this->price) <= 0;
    }

    /**
     * Scope a query to only include active courses.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured courses.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the teacher that owns the course.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the category that owns the course.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the registrations for the course.
     */
    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(CourseRating::class);
    }

    public function scopeWithRatingStats($query)
    {
        if (! Schema::hasTable('course_ratings')) {
            return $query;
        }

        return $query->withAvg('ratings', 'rating')->withCount('ratings');
    }

    public function ratingAverage(): float
    {
        $avg = $this->ratings_avg_rating ?? null;

        if ($avg === null && Schema::hasTable('course_ratings')) {
            $avg = $this->ratings()->avg('rating');
        }

        return round((float) ($avg ?? 0), 1);
    }

    public function ratingCount(): int
    {
        if (isset($this->ratings_count)) {
            return (int) $this->ratings_count;
        }

        if (! Schema::hasTable('course_ratings')) {
            return 0;
        }

        return (int) $this->ratings()->count();
    }

    /**
     * @return list<'full'|'half'|'empty'>
     */
    public function ratingStarStates(): array
    {
        $average = $this->ratingAverage();
        $states = [];

        for ($star = 1; $star <= 5; $star++) {
            if ($average >= $star) {
                $states[] = 'full';
            } elseif ($average >= $star - 0.5) {
                $states[] = 'half';
            } else {
                $states[] = 'empty';
            }
        }

        return $states;
    }

    public const DELIVERY_MODES = [
        'presentiel' => 'Présentiel',
        'en_ligne' => 'En ligne',
        'hybride' => 'Présentiel & en ligne',
    ];

    public function deliveryMode(): string
    {
        $mode = (string) ($this->delivery_mode ?? 'hybride');

        return array_key_exists($mode, self::DELIVERY_MODES) ? $mode : 'hybride';
    }

    public function deliveryModeLabel(): string
    {
        return self::DELIVERY_MODES[$this->deliveryMode()];
    }

    public function deliveryModeIcon(): string
    {
        return match ($this->deliveryMode()) {
            'presentiel' => 'fa-map-marker',
            'en_ligne' => 'fa-laptop',
            default => 'fa-globe',
        };
    }
}
