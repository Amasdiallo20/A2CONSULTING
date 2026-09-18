<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\SoftwareProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SoftwareProductController extends Controller
{
    use StoresImages;

    public function index(): View
    {
        $products = SoftwareProduct::ordered()->paginate(15);

        return view('admin.software.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.software.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $validated['image'] = $this->storeImage($request, 'image', 'software');
        $validated['screenshots'] = $this->mergeScreenshots($request, []);
        SoftwareProduct::create($validated);

        return redirect()->route('admin.software.index')
            ->with('success', 'Logiciel ajouté.');
    }

    public function edit(SoftwareProduct $software): View
    {
        return view('admin.software.edit', compact('software'));
    }

    public function update(Request $request, SoftwareProduct $software): RedirectResponse
    {
        $validated = $this->validatedData($request, $software);
        $validated['image'] = $this->storeImage($request, 'image', 'software', $software->image, true);
        $validated['screenshots'] = $this->mergeScreenshots($request, $software->screenshotList());
        $software->update($validated);

        return redirect()->route('admin.software.index')
            ->with('success', 'Logiciel mis à jour.');
    }

    public function destroy(SoftwareProduct $software): RedirectResponse
    {
        $this->deleteStoredImage($software->image);
        foreach ($software->screenshotList() as $path) {
            $this->deleteStoredImage($path);
        }
        $software->delete();

        return redirect()->route('admin.software.index')
            ->with('success', 'Logiciel supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?SoftwareProduct $software = null): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('software_products', 'slug')->ignore($software?->id),
            ],
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'modules_text' => 'nullable|string',
            'youtube_url' => 'nullable|string|max:500',
            'demo_url' => 'nullable|string|max:500',
            'demo_login' => 'nullable|string|max:120',
            'demo_password' => 'nullable|string|max:120',
            'image' => $this->imageValidationRule(),
            'screenshots' => 'nullable|array|max:12',
            'screenshots.*' => $this->imageValidationRule(),
            'remove_screenshots' => 'nullable|array',
            'remove_screenshots.*' => 'string|max:255',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);

        $youtubeUrl = trim((string) ($validated['youtube_url'] ?? ''));
        if ($youtubeUrl !== '' && ! SoftwareProduct::isValidVideoUrl($youtubeUrl)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'youtube_url' => 'Collez un lien YouTube ou une vidéo publique Facebook.',
            ]);
        }

        $demoUrl = trim((string) ($validated['demo_url'] ?? ''));
        if ($demoUrl !== '') {
            $normalizedDemo = preg_match('#^https?://#i', $demoUrl) ? $demoUrl : 'https://'.$demoUrl;
            if (! filter_var($normalizedDemo, FILTER_VALIDATE_URL)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'demo_url' => 'Indiquez une adresse de démo valide (https://...).',
                ]);
            }
            $demoUrl = $normalizedDemo;
        }

        $slug = SoftwareProduct::slugFromName($validated['name'], $validated['slug'] ?? null);
        if (SoftwareProduct::query()
            ->where('slug', $slug)
            ->when($software, fn ($q) => $q->where('id', '!=', $software->id))
            ->exists()) {
            $slug .= '-'.($software?->id ?? now()->format('His'));
        }

        $modules = collect(preg_split('/\r\n|\r|\n/', (string) ($validated['modules_text'] ?? '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        return [
            'name' => $validated['name'],
            'slug' => $slug,
            'tagline' => $validated['tagline'] ?: null,
            'description' => $validated['description'] ?: null,
            'content' => $validated['content'] ?: null,
            'youtube_url' => $youtubeUrl !== '' ? $youtubeUrl : null,
            'demo_url' => $demoUrl !== '' ? $demoUrl : null,
            'demo_login' => trim((string) ($validated['demo_login'] ?? '')) ?: null,
            'demo_password' => trim((string) ($validated['demo_password'] ?? '')) ?: null,
            'modules' => $modules,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active'),
        ];
    }

    /**
     * @param  list<string>  $current
     * @return list<string>
     */
    private function mergeScreenshots(Request $request, array $current): array
    {
        $remove = array_map('strval', (array) $request->input('remove_screenshots', []));
        $kept = [];

        foreach ($current as $path) {
            if (in_array($path, $remove, true)) {
                $this->deleteStoredImage($path);
                continue;
            }
            $kept[] = $path;
        }

        foreach ((array) $request->file('screenshots', []) as $file) {
            if (! $file instanceof \Illuminate\Http\UploadedFile || ! $file->isValid()) {
                continue;
            }
            $kept[] = 'uploads/'.$file->store('software/screenshots', 'uploads');
        }

        return array_slice(array_values(array_unique($kept)), 0, 12);
    }
}
