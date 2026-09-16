<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseRegistration::with('course');

        // Filtre par statut
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filtre par cours
        if ($request->has('course_id') && $request->course_id !== '') {
            $query->where('course_id', $request->course_id);
        }

        $registrations = $query->latest()->paginate(20);

        $courses = \App\Models\Course::active()->get();

        return view('admin.registrations.index', compact('registrations', 'courses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseRegistration $registration)
    {
        $registration->load('course');
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Update the status of a registration.
     */
    public function updateStatus(Request $request, CourseRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $registration->update(['status' => $request->status]);

        return back()->with('success', 'Statut de l\'inscription mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseRegistration $registration)
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }
}
