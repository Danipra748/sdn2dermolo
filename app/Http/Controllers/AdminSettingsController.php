<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminSettingsController extends Controller
{
    /**
     * Show hidden settings page for principal greeting.
     */
    public function hiddenSettings()
    {
        $sambutanText = '';
        $fotoKepsek = null;

        if (Schema::hasTable('site_settings')) {
            $sambutanText = SiteSetting::getValue('kepsek_sambutan_text', '');
            $fotoKepsek = SiteSetting::getValue('foto_kepsek');
        }

        return view('admin.settings_hidden', compact(
            'sambutanText',
            'fotoKepsek'
        ));
    }

    /**
     * Upload school logo.
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
        ], [
            'logo.required' => 'Logo harus diupload.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Format gambar harus PNG, JPG, JPEG, WebP, atau SVG.',
            'logo.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        try {
            $path = $request->file('logo')->store('public/logos');
            $filename = basename($path);

            if (Schema::hasTable('site_settings')) {
                SiteSetting::setValue('school_logo', $filename);
            }

            return back()->with('success', 'Logo sekolah berhasil diupload.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupload logo: '.$e->getMessage());
        }
    }

    /**
     * Upload principal's photo (foto Kepala Sekolah).
     */
    public function uploadFotoKepsek(Request $request)
    {
        $request->validate([
            'foto_kepsek' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'foto_kepsek.required' => 'Foto kepala sekolah harus diupload.',
            'foto_kepsek.image' => 'File harus berupa gambar.',
            'foto_kepsek.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
            'foto_kepsek.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        try {
            $path = $request->file('foto_kepsek')->store('public/foto-kepsek');
            $filename = basename($path);

            if (Schema::hasTable('site_settings')) {
                SiteSetting::setValue('foto_kepsek', $filename);
            }

            return back()->with('success', 'Foto kepala sekolah berhasil diupload.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupload foto: '.$e->getMessage());
        }
    }

    /**
     * Delete principal's photo.
     */
    public function deleteFotoKepsek(Request $request)
    {
        if (! Schema::hasTable('site_settings')) {
            return back()->with('error', 'Tabel site_settings tidak tersedia.');
        }

        $filename = SiteSetting::getValue('foto_kepsek');

        if ($filename) {
            $filePath = 'public/foto-kepsek/'.$filename;
            if (file_exists(storage_path('app/'.$filePath))) {
                unlink(storage_path('app/'.$filePath));
            }

            SiteSetting::setValue('foto_kepsek', null);

            return back()->with('success', 'Foto kepala sekolah berhasil dihapus.');
        }

        return back()->with('error', 'Tidak ada foto yang dapat dihapus.');
    }
}
