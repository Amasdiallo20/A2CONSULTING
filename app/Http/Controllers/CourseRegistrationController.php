<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;

class CourseRegistrationController extends Controller
{
    /**
     * Store a new course registration.
     */
    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $validated['course_id'] = $course->id;
        $validated['status'] = 'pending';

        CourseRegistration::create($validated);

        return redirect()->route('courses.show', $course->id)
            ->with('success', 'Votre inscription a été enregistrée avec succès ! Nous vous contacterons bientôt.');
    }
}
