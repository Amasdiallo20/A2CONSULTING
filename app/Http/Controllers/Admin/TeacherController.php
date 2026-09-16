<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    use StoresImages;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::latest()->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'courses_count' => 'nullable|integer|min:0',
            'students_count' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Valider les URLs seulement si elles ne sont pas vides
        if (!empty($validated['facebook']) && !filter_var($validated['facebook'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['facebook' => 'L\'URL Facebook n\'est pas valide.'])->withInput();
        }
        if (!empty($validated['twitter']) && !filter_var($validated['twitter'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['twitter' => 'L\'URL Twitter n\'est pas valide.'])->withInput();
        }
        if (!empty($validated['linkedin']) && !filter_var($validated['linkedin'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['linkedin' => 'L\'URL LinkedIn n\'est pas valide.'])->withInput();
        }
        if (!empty($validated['instagram']) && !filter_var($validated['instagram'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['instagram' => 'L\'URL Instagram n\'est pas valide.'])->withInput();
        }

        // Convertir les chaînes vides en null pour les URLs
        $validated['facebook'] = !empty($validated['facebook']) ? $validated['facebook'] : null;
        $validated['twitter'] = !empty($validated['twitter']) ? $validated['twitter'] : null;
        $validated['linkedin'] = !empty($validated['linkedin']) ? $validated['linkedin'] : null;
        $validated['instagram'] = !empty($validated['instagram']) ? $validated['instagram'] : null;

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['courses_count'] = $validated['courses_count'] ?? 0;
        $validated['students_count'] = $validated['students_count'] ?? 0;
        $validated['image'] = $this->storeImage($request, 'image', 'teachers');

        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Formateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        $teacher->load('courses');
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'courses_count' => 'nullable|integer|min:0',
            'students_count' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Valider les URLs seulement si elles ne sont pas vides
        if (!empty($validated['facebook']) && !filter_var($validated['facebook'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['facebook' => 'L\'URL Facebook n\'est pas valide.'])->withInput();
        }
        if (!empty($validated['twitter']) && !filter_var($validated['twitter'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['twitter' => 'L\'URL Twitter n\'est pas valide.'])->withInput();
        }
        if (!empty($validated['linkedin']) && !filter_var($validated['linkedin'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['linkedin' => 'L\'URL LinkedIn n\'est pas valide.'])->withInput();
        }
        if (!empty($validated['instagram']) && !filter_var($validated['instagram'], FILTER_VALIDATE_URL)) {
            return back()->withErrors(['instagram' => 'L\'URL Instagram n\'est pas valide.'])->withInput();
        }

        // Convertir les chaînes vides en null pour les URLs
        $validated['facebook'] = !empty($validated['facebook']) ? $validated['facebook'] : null;
        $validated['twitter'] = !empty($validated['twitter']) ? $validated['twitter'] : null;
        $validated['linkedin'] = !empty($validated['linkedin']) ? $validated['linkedin'] : null;
        $validated['instagram'] = !empty($validated['instagram']) ? $validated['instagram'] : null;

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['courses_count'] = $validated['courses_count'] ?? $teacher->courses_count ?? 0;
        $validated['students_count'] = $validated['students_count'] ?? $teacher->students_count ?? 0;
        $validated['image'] = $this->storeImage($request, 'image', 'teachers', $teacher->image, true);

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Formateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Formateur supprimé avec succès.');
    }
}



