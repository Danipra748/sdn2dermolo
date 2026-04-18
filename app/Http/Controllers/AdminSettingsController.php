<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Services\Modules\SiteSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class AdminSettingsController extends Controller
{
    protected $siteSettingService;

    public function __construct(SiteSettingService $siteSettingService)
    {
        $this->siteSettingService = $siteSettingService;
    }

    /**
     * Redirect old logo page to school profile page.
     */
    public function logoSettings()
    {
        return redirect()->route('admin.school-profile.edit')
            ->with('info', 'Pengaturan logo sekolah sekarang berada di halaman Profil Sekolah.');
    }

    /**
     * Show hidden settings page for principal greeting.
     */
    public function hiddenSettings()
    {
        $sambutanText = '';
        $sambutanFoto = null;
        $fotoKepsek = null;

        if (Schema::hasTable('site_settings')) {
            $sambutanText = SiteSetting::getValue('kepsek_sambutan_text', '');
            $sambutanFoto = SiteSetting::getValue('kepsek_sambutan_foto');
            $fotoKepsek = SiteSetting::getFotoKepsek();
        }

        return view('admin.settings_hidden', compact(
            'sambutanText',
            'sambutanFoto',
            'fotoKepsek'
        ));
    }

    /**
     * Upload kepala sekolah foto resmi untuk halaman tentang kami.
     */
    public function uploadFotoKepsek(Request $request)
    {
        $request->validate([
            'foto_kepsek' => ['required', 'image', 'mimes:jpeg,jpg,png,webp|max:3072'],
        ]);

        try {
            $path = $this->siteSettingService->uploadFotoKepsek($request);

            if ($path) {
                return redirect()->route('admin.hidden-settings')
                    ->with('success', 'Foto kepala sekolah berhasil diupload!');
            }

            return redirect()->route('admin.hidden-settings')
                ->with('error', 'Gagal mengupload foto kepala sekolah.');
        } catch (\Exception $e) {
            Log::error('Upload foto kepsek error: ' . $e->getMessage());
            return redirect()->route('admin.hidden-settings')
                ->with('error', 'Terjadi error saat upload.');
        }
    }

    /**
     * Delete kepala sekolah foto.
     */
    public function deleteFotoKepsek()
    {
        try {
            $deleted = $this->siteSettingService->deleteFotoKepsek();

            if ($deleted) {
                return redirect()->route('admin.hidden-settings')
                    ->with('success', 'Foto kepala sekolah berhasil dihapus!');
            }

            return redirect()->route('admin.hidden-settings')
                ->with('error', 'Gagal menghapus foto kepala sekolah.');
        } catch (\Exception $e) {
            Log::error('Delete foto kepsek error: ' . $e->getMessage());
            return redirect()->route('admin.hidden-settings')
                ->with('error', 'Terjadi error saat menghapus.');
        }
    }
}
