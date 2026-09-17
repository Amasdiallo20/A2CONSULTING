<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
