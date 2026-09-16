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

        $validated = $request->validate([
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
            'hero_image' => $this->imageValidationRule(),
            'hero_button_text' => 'nullable|string|max:255',
            'hero_button_url' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:255',
            'about_text' => 'nullable|string',
            'about_image' => $this->imageValidationRule(),
            'orange_money_number' => 'nullable|string|max:50',
            'mtn_money_number' => 'nullable|string|max:50',
            'moov_money_number' => 'nullable|string|max:50',
        ]);

        $validated['hero_image'] = $this->storeImage($request, 'hero_image', 'settings', $setting->hero_image, true);
        $validated['about_image'] = $this->storeImage($request, 'about_image', 'settings', $setting->about_image, true);

        $setting->update($validated);

        return back()->with('success', 'Paramètres du site enregistrés.');
    }
}
