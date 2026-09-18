<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    use StoresImages;

    public function index(): View
    {
        $partners = Partner::ordered()->paginate(20);

        return view('admin.partners.index', compact('partners'));
    }

    public function create(): View
    {
        return view('admin.partners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $validated['logo'] = $this->storeImage($request, 'logo', 'partners');
        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partenaire ajouté.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $validated['logo'] = $this->storeImage($request, 'logo', 'partners', $partner->logo, true);
        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partenaire mis à jour.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $this->deleteStoredImage($partner->logo);
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partenaire supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => $this->imageValidationRule(),
            'website_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);

        $validated['website_url'] = $validated['website_url'] ?: null;
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
