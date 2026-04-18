<?php

namespace App\Http\Controllers;

use App\Models\PpdbSetting;
use App\Models\PpdbBanner;
use App\Services\Modules\PpdbService;
use Illuminate\Http\Request;

class AdminPpdbController extends Controller
{
    protected $ppdbService;

    public function __construct(PpdbService $ppdbService)
    {
        $this->ppdbService = $ppdbService;
    }

    /**
     * Display PPDB management page.
     */
    public function index()
    {
        $settings = PpdbSetting::getInstance();
        $status = $this->ppdbService->getStatus();
        $banners = PpdbBanner::orderBy('order')->get();

        return view('admin.ppdb.index', compact('settings', 'status', 'banners'));
    }

    /**
     * Update PPDB schedule and link.
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

        $this->ppdbService->updateSettings($validated);

        return redirect()->back()->with('success', 'Pengaturan PPDB berhasil diperbarui.');
    }

    /**
     * Store a new banner.
     */
    public function storeBanner(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer',
        ]);

        $this->ppdbService->storeBanner($request);

        return redirect()->back()->with('success', 'Banner PPDB berhasil ditambahkan.');
    }

    /**
     * Update an existing banner.
     */
    public function updateBanner(Request $request, PpdbBanner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer',
        ]);

        $this->ppdbService->updateBanner($request, $banner);

        return redirect()->back()->with('success', 'Banner PPDB berhasil diperbarui.');
    }

    /**
     * Toggle banner visibility.
     */
    public function toggleBanner(PpdbBanner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $banner->is_active
        ]);
    }

    /**
     * Delete a banner.
     */
    public function destroyBanner(PpdbBanner $banner)
    {
        $this->ppdbService->deleteBanner($banner);

        return redirect()->back()->with('success', 'Banner PPDB berhasil dihapus.');
    }
}
