<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use StoresImages;

    public function edit()
    {
        $setting = SiteSetting::current();

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = SiteSetting::current();
        $imageFields = $this->imageFields();

        $rules = [
            'site_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'opening_hours' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_button_text' => 'nullable|string|max:255',
            'hero_button_url' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:255',
            'about_text' => 'nullable|string',
            'orange_money_number' => 'nullable|string|max:50',
            'mtn_money_number' => 'nullable|string|max:50',
            'moov_money_number' => 'nullable|string|max:50',
        ];

        foreach ($imageFields as $field) {
            $rules[$field] = $this->imageValidationRule();
        }

        $validated = $request->validate($rules);

        foreach ($imageFields as $field) {
            $validated[$field] = $this->storeImage($request, $field, 'settings', $setting->{$field}, true);
        }

        $setting->fill($validated);
        $setting->save();
        $setting->refresh();

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Paramètres enregistrés. Les changements sont visibles sur le site.');
    }

    /**
     * @return list<string>
     */
    private function imageFields(): array
    {
        $fields = ['hero_image', 'about_image', 'logo_image', 'favicon_image', 'about_bg_image'];

        foreach (array_keys(SiteSetting::PAGE_BANNERS) as $key) {
            $fields[] = 'banner_'.$key;
        }

        return $fields;
    }
}
