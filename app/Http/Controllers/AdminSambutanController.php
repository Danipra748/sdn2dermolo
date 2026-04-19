<?php

namespace App\Http\Controllers;

use App\Services\Modules\SiteSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminSambutanController extends Controller
{
    protected $siteSettingService;

    public function __construct(SiteSettingService $siteSettingService)
    {
        $this->siteSettingService = $siteSettingService;
    }

    public function edit()
    {
        return redirect()->route('admin.hidden-settings');
    }

    public function update(Request $request)
    {
        if (! Schema::hasTable('site_settings')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $validated = $request->validate([
            'sambutan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_foto' => ['nullable', 'boolean'],
            'crop_x' => ['nullable', 'numeric'],
            'crop_y' => ['nullable', 'numeric'],
            'crop_w' => ['nullable', 'numeric'],
            'crop_h' => ['nullable', 'numeric'],
        ]);

        $this->siteSettingService->updateSambutanAndFoto($validated, $request);

        return redirect()->to(route('admin.hidden-settings').'#sambutan-settings')
            ->with('status', 'Sambutan kepala sekolah berhasil diperbarui.');
    }
}
