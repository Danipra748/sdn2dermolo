<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminKontakController extends Controller
{
    public function edit()
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $location = SiteSetting::getSchoolLocation();

        $kontak = [
            'address' => SiteSetting::getValue('school_address', ''),
            'phone' => SiteSetting::getValue('school_phone', ''),
            'email' => SiteSetting::getValue('school_email', ''),
            'maps_url' => SiteSetting::getValue('school_maps_url', ''),
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'zoom' => $location['zoom'],
        ];

        return view('admin.kontak.form', compact('kontak'));
    }

    public function update(Request $request)
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $validated = $request->validate([
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'maps_url' => ['nullable', 'url', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'zoom' => ['nullable', 'integer', 'between:1,19'],
        ]);

        SiteSetting::setValue('school_address', $validated['address'] ?? '');
        SiteSetting::setValue('school_phone', $validated['phone'] ?? '');
        SiteSetting::setValue('school_email', $validated['email'] ?? '');
        SiteSetting::setValue('school_maps_url', $validated['maps_url'] ?? '');

        // Update coordinates if provided
        if (isset($validated['latitude']) && isset($validated['longitude'])) {
            SiteSetting::updateSchoolLocation(
                (float) $validated['latitude'],
                (float) $validated['longitude'],
                (int) ($validated['zoom'] ?? 15)
            );
        }

        return redirect()->route('admin.kontak.edit')
            ->with('status', 'Kontak sekolah berhasil diperbarui.');
    }

    private function hasRequiredTables(): bool
    {
        return Schema::hasTable('site_settings');
    }
}
