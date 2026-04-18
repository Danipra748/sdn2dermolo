<?php

namespace App\Http\Controllers;

use App\Models\PpdbBanner;
use App\Models\PpdbSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPpdbController extends Controller
{
    /**
     * Display PPDB settings and banners.
     */
    public function index()
    {
        $settings = PpdbSetting::getInstance();
        $banners = PpdbBanner::orderBy('order')->get();

        return view('admin.ppdb.index', compact('settings', 'banners'));
    }

    /**
     * Update PPDB settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'form_url' => 'required|url',
        ], [
            'start_date.required' => 'Tanggal mulai pendaftaran wajib diisi.',
            'end_date.required' => 'Tanggal selesai pendaftaran wajib diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'form_url.required' => 'Link Google Form wajib diisi.',
            'form_url.url' => 'Format Link Google Form tidak valid (harus diawali http:// atau https://).',
        ]);

        $settings = PpdbSetting::getInstance();
        $settings->update($validated);

        return redirect()->back()->with('success', 'Pengaturan PPDB berhasil diperbarui.');
    }

    /**
     * Store a new banner.
     */
    public function storeBanner(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ppdb/banners', 'public');
            
            PpdbBanner::create([
                'title' => $validated['title'],
                'image_path' => $path,
                'order' => $validated['order'] ?? 0,
                'is_active' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Banner PPDB berhasil ditambahkan.');
    }

    /**
     * Update an existing banner.
     */
    public function updateBanner(Request $request, PpdbBanner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer',
        ]);

        $data = [
            'title' => $validated['title'],
            'order' => $validated['order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            // Store new image
            $data['image_path'] = $request->file('image')->store('ppdb/banners', 'public');
        }

        $banner->update($data);

        return redirect()->back()->with('success', 'Banner PPDB berhasil diperbarui.');
    }

    /**
     * Toggle banner visibility.
     */
    public function toggleBanner(PpdbBanner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        return response()->json(['success' => true, 'is_active' => $banner->is_active]);
    }

    /**
     * Delete a banner.
     */
    public function destroyBanner(PpdbBanner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        
        $banner->delete();

        return redirect()->back()->with('success', 'Banner PPDB berhasil dihapus.');
    }
}
