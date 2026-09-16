<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->ofType('course')->orderBy('order')->orderBy('name')->get();

        $courses = Course::with(['teacher', 'category'])
            ->active()
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->q.'%');
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.courses', compact('courses', 'categories'));
    }

    public function show($id)
    {
        $course = Course::with(['teacher', 'category'])->active()->findOrFail($id);

        $relatedCourses = Course::with('teacher')
            ->active()
            ->where('id', '!=', $course->id)
            ->when($course->category_id, fn ($q) => $q->where('category_id', $course->category_id))
            ->latest()
            ->take(3)
            ->get();

        return view('pages.courses-single', compact('course', 'relatedCourses'));
    }
}
