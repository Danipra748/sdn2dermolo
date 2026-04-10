<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminSambutanController extends Controller
{
    public function edit()
    {
        return redirect()->route('admin.hidden-settings');
    }

    public function update(Request $request)
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $validated = $request->validate([
            'sambutan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_foto' => ['nullable', 'boolean'],
        ]);

        $existingFoto = SiteSetting::getValue('kepsek_sambutan_foto');

        if (! empty($validated['remove_foto']) && $existingFoto) {
            Storage::disk('public')->delete($existingFoto);
            SiteSetting::setValue('kepsek_sambutan_foto', '');
            $existingFoto = null;
        }

        if ($request->hasFile('foto')) {
            if ($existingFoto) {
                Storage::disk('public')->delete($existingFoto);
            }

            $path = $request->file('foto')->store('sambutan', 'public');
            SiteSetting::setValue('kepsek_sambutan_foto', $path);
        }

        // Di sini variabel sambutan kepala sekolah diproses.
        SiteSetting::setValue('kepsek_sambutan_text', $validated['sambutan'] ?? '');

        return redirect()->to(route('admin.hidden-settings') . '#sambutan-settings')
            ->with('status', 'Sambutan kepala sekolah berhasil diperbarui.');
    }

    private function hasRequiredTables(): bool
    {
        return Schema::hasTable('site_settings');
    }
}
