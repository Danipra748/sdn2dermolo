<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminSettingsController extends Controller
{
    /**
     * Redirect old logo page to hidden settings page.
     */
    public function logoSettings()
    {
        return redirect()->route('admin.hidden-settings');
    }

    /**
     * Show hidden settings page for logo upload and principal greeting.
     */
    public function hiddenSettings()
    {
        // Di sini lokasi penyimpanan path logonya.
        $logoStoragePath = $this->resolveCurrentLogoStoragePath();
        $logoPublicPath = $this->resolveCurrentLogoPublicPath();
        $logoExists = $logoStoragePath !== null;

        $sambutanText = '';
        $sambutanFoto = null;
        $fotoKepsek = null;

        if (Schema::hasTable('site_settings')) {
            // Di sini variabel sambutan kepala sekolah diproses.
            $sambutanText = SiteSetting::getValue('kepsek_sambutan_text', '');
            $sambutanFoto = SiteSetting::getValue('kepsek_sambutan_foto');
            $fotoKepsek = SiteSetting::getFotoKepsek();
        }

        return view('admin.settings_hidden', compact(
            'logoExists',
            'logoPublicPath',
            'logoStoragePath',
            'sambutanText',
            'sambutanFoto',
            'fotoKepsek'
        ));
    }

    /**
     * Upload school logo.
     */
    public function uploadLogo(Request $request)
    {
        \Log::info('Logo upload started');

        $request->validate([
            'logo' => ['required', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:5120'],
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            \Log::info('Processing logo upload', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'extension' => $file->getClientOriginalExtension(),
            ]);

            $directory = storage_path('app/public/logos');
            if (! file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            foreach ($this->resolveAllLogoStoragePaths() as $existingLogoPath) {
                if (file_exists($existingLogoPath)) {
                    unlink($existingLogoPath);
                    \Log::info('Old logo deleted', ['path' => $existingLogoPath]);
                }
            }

            $extension = $file->getClientOriginalExtension();
            $filename = 'sd-negeri-2-dermolo.' . $extension;

            // Di sini lokasi penyimpanan path logonya.
            $path = $file->storeAs('logos', $filename, 'public');

            \Log::info('Logo stored successfully', ['path' => $path]);
        }

        return redirect()->to(route('admin.hidden-settings') . '#logo-settings')
            ->with('success', 'Logo sekolah berhasil diupload!');
    }

    private function resolveCurrentLogoStoragePath(): ?string
    {
        return $this->resolveAllLogoStoragePaths()[0] ?? null;
    }

    private function resolveCurrentLogoPublicPath(): ?string
    {
        $logoStoragePath = $this->resolveCurrentLogoStoragePath();

        if (! $logoStoragePath) {
            return null;
        }

        return 'storage/logos/' . basename($logoStoragePath);
    }

    private function resolveAllLogoStoragePaths(): array
    {
        $paths = glob(storage_path('app/public/logos/sd-negeri-2-dermolo.*')) ?: [];
        sort($paths);

        return $paths;
    }

    /**
     * Upload kepala sekolah foto resmi untuk halaman tentang kami.
     */
    public function uploadFotoKepsek(Request $request)
    {
        $request->validate([
            'foto_kepsek' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
        ]);

        if ($request->hasFile('foto_kepsek')) {
            $path = SiteSetting::uploadFotoKepsek($request->file('foto_kepsek'));

            if ($path) {
                return redirect()->route('admin.hidden-settings')
                    ->with('success', 'Foto kepala sekolah berhasil diupload!');
            }
        }

        return redirect()->route('admin.hidden-settings')
            ->with('error', 'Gagal mengupload foto kepala sekolah.');
    }

    /**
     * Delete kepala sekolah foto.
     */
    public function deleteFotoKepsek()
    {
        $deleted = SiteSetting::deleteFotoKepsek();

        if ($deleted) {
            return redirect()->route('admin.hidden-settings')
                ->with('success', 'Foto kepala sekolah berhasil dihapus!');
        }

        return redirect()->route('admin.hidden-settings')
            ->with('error', 'Gagal menghapus foto kepala sekolah.');
    }
}
