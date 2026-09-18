<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseRating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->ofType('course')->orderBy('order')->orderBy('name')->get();

        $courses = Course::with(['teacher', 'category'])
            ->withRatingStats()
            ->active()
            ->when($request->filled('category'), function ($query) use ($request) {
                $category = $request->string('category')->toString();
                $query->where(function ($inner) use ($category) {
                    $inner->where('category_id', $category)
                        ->orWhereHas('category', fn ($q) => $q->where('slug', $category)->where('type', 'course'));
                });
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->q.'%');
            })
            ->when($request->filled('mode'), function ($query) use ($request) {
                $mode = $request->string('mode')->toString();
                if (array_key_exists($mode, Course::DELIVERY_MODES)) {
                    $query->where('delivery_mode', $mode);
                }
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.courses', compact('courses', 'categories'));
    }

    public function show($id)
    {
        $course = Course::with(['teacher', 'category'])->withRatingStats()->active()->findOrFail($id);

        $relatedCourses = Course::with('teacher')
            ->withRatingStats()
            ->active()
            ->where('id', '!=', $course->id)
            ->when($course->category_id, fn ($q) => $q->where('category_id', $course->category_id))
            ->latest()
            ->take(3)
            ->get();

        $visitorRating = null;
        if (Schema::hasTable('course_ratings')) {
            $visitorRating = CourseRating::query()
                ->where('course_id', $course->id)
                ->where('visitor_key', CourseRating::visitorKey(request()))
                ->value('rating');
        }

        return view('pages.courses-single', compact('course', 'relatedCourses', 'visitorRating'));
    }

    public function rate(Request $request, $id): RedirectResponse
    {
        $course = Course::active()->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'rating.required' => 'Choisissez une note entre 1 et 5 étoiles.',
            'rating.min' => 'La note minimale est de 1 étoile.',
            'rating.max' => 'La note maximale est de 5 étoiles.',
        ]);

        CourseRating::updateOrCreate(
            [
                'course_id' => $course->id,
                'visitor_key' => CourseRating::visitorKey($request),
            ],
            ['rating' => (int) $validated['rating']]
        );

        return redirect()->route('courses.show', $course->id)
            ->with('rating_success', 'Merci, votre note a bien été enregistrée.');
    }
}
