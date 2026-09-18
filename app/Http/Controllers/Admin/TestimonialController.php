<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    use StoresImages;

    public function index(): View
    {
        $testimonials = Testimonial::ordered()->paginate(20);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $validated['photo'] = $this->storeImage($request, 'photo', 'testimonials');
        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Témoignage ajouté.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $validated['photo'] = $this->storeImage($request, 'photo', 'testimonials', $testimonial->photo, true);
        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Témoignage mis à jour.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $this->deleteStoredImage($testimonial->photo);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Témoignage supprimé.');
    }

    /**
     * @return array{client_name: string, role: ?string, company: ?string, quote: string, photo?: mixed, rating: int, sort_order: int, is_active: bool}
     */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'quote' => 'required|string|max:800',
            'photo' => $this->imageValidationRule(),
            'rating' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);

        $validated['role'] = $validated['role'] ?: null;
        $validated['company'] = $validated['company'] ?: null;
        $validated['rating'] = (int) $validated['rating'];
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
