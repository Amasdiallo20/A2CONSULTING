<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class CourseRating extends Model
{
    protected $fillable = [
        'course_id',
        'rating',
        'visitor_key',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public static function visitorKey(Request $request): string
    {
        return hash('sha256', 'course-rate|'.$request->ip().'|'.$request->session()->getId());
    }
}
