<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::first();
        if (!$settings) {
            $settings = SiteSetting::create([
                'site_name' => 'CMS News',
                'site_description' => 'Noticias rápidas, claras y optimizadas para SEO',
            ]);
        }
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:255',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg,svg|max:1024', // 1MB Max, support common favicon formats
        ]);

        $settings = SiteSetting::firstOrFail();
        $data = $request->only(['site_name', 'site_description']);

        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path) {
                Storage::disk('public')->delete($settings->favicon_path);
            }
            $data['favicon_path'] = $request->file('favicon')->store('site-logos', 'public');
        }

        $settings->update($data);

        return redirect()->route('admin.settings.edit')->with('status', 'Configuración actualizada correctamente.');
    }
}
