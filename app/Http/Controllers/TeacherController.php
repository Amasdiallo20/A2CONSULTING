<?php

namespace App\Http\Controllers;

use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::active()->latest()->paginate(12);

        return view('pages.teachers', compact('teachers'));
    }

    public function show($id)
    {
        $teacher = Teacher::with(['courses' => fn ($q) => $q->active()])->active()->findOrFail($id);

        return view('pages.teachers-single', compact('teacher'));
    }
}
