<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'position',
        'bio',
        'description',
        'image',
        'email',
        'phone',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'courses_count',
        'students_count',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'courses_count' => 'integer',
        'students_count' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active teachers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured teachers.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the courses for the teacher.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
