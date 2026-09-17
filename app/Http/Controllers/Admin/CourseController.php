<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    use StoresImages;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['teacher', 'category'])
            ->latest()
            ->paginate(15);
        
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::active()->get();
        $categories = Category::active()->ofType('course')->get();
        
        return view('admin.courses.create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:free,paid',
            'duration' => 'nullable|string',
            'teacher_id' => 'nullable|exists:teachers,id',
            'category_id' => 'nullable|exists:categories,id',
            'lessons_count' => 'nullable|integer|min:0',
            'quizzes_count' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $this->applyPriceType($validated);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['image'] = $this->storeImage($request, 'image', 'courses');

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Cours créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['teacher', 'category', 'registrations']);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $teachers = Teacher::active()->get();
        $categories = Category::active()->ofType('course')->get();
        
        return view('admin.courses.edit', compact('course', 'teachers', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:free,paid',
            'duration' => 'nullable|string',
            'teacher_id' => 'nullable|exists:teachers,id',
            'category_id' => 'nullable|exists:categories,id',
            'lessons_count' => 'nullable|integer|min:0',
            'quizzes_count' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = $course->title === $validated['title']
            ? $course->slug
            : Str::slug($validated['title']);
        $this->applyPriceType($validated);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['image'] = $this->storeImage($request, 'image', 'courses', $course->image, true);

        $course->fill($validated);
        $course->save();
        $course->refresh();

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Formation enregistrée. Le nouveau tarif est visible sur le site.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Cours supprimé avec succès.');
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function applyPriceType(array &$validated): void
    {
        if (($validated['price_type'] ?? 'free') === 'free') {
            $validated['price'] = 0;

            return;
        }

        $validated['price_type'] = 'paid';
        $validated['price'] = integer_price($validated['price'] ?? 0);

        if ($validated['price'] <= 0) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'price' => 'Indiquez un prix supérieur à 0 pour une formation payante.',
            ]);
        }
    }
}
