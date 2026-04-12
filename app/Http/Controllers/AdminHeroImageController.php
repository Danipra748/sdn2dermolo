<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHeroImageController extends Controller
{
    /**
     * Show hero image management page
     */
    public function index()
    {
        $heroImage = SiteSetting::getHeroImage();
        return view('admin.hero-image.index', compact('heroImage'));
    }

    /**
     * Update hero image
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $path = SiteSetting::uploadHeroImage($request->file('hero_image'));

        if ($path) {
            return back()->with('success', 'Gambar hero section berhasil diunggah.');
        }

        return back()->with('error', 'Gagal mengunggah gambar. Silakan coba lagi.');
    }

    /**
     * Delete hero image
     */
    public function destroy()
    {
        $deleted = SiteSetting::deleteHeroImage();

        if ($deleted) {
            return back()->with('success', 'Gambar hero section berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus gambar. Silakan coba lagi.');
    }
}
