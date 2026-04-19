<?php

namespace App\Http\Controllers;

use App\Models\PpdbBanner;
use App\Models\PpdbSetting;
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
     * Show the form for creating a new banner.
     */
    public function createBanner()
    {
        return view('admin.ppdb.form-banner', [
            'banner' => null,
            'isEdit' => false,
            'title' => 'Tambah Banner PPDB',
        ]);
    }

    /**
     * Show the form for editing an existing banner.
     */
    public function editBanner(PpdbBanner $banner)
    {
        return view('admin.ppdb.form-banner', [
            'banner' => $banner,
            'isEdit' => true,
            'title' => 'Edit Banner PPDB',
        ]);
    }

    /**
     * Update PPDB schedule and link.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_link' => 'required|url',
        ], [
            'start_date.required' => 'Tanggal mulai pendaftaran wajib diisi.',
            'end_date.required' => 'Tanggal selesai pendaftaran wajib diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'registration_link.required' => 'Link Pendaftaran wajib diisi.',
            'registration_link.url' => 'Format Link tidak valid (harus dimulai http:// atau https://).',
        ]);

        try {
            $this->ppdbService->updateSettings($validated);

            return redirect()->route('admin.ppdb.index')->with('success', 'Pengaturan PPDB berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pengaturan.')->withInput();
        }
    }

    /**
     * Store a new banner.
     */
    public function storeBanner(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
        ], [
            'image.required' => 'Gambar banner wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $this->ppdbService->storeBanner($request);

            return redirect()->route('admin.ppdb.index')->with('success', 'Banner PPDB berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan banner.')->withInput();
        }
    }

    /**
     * Update an existing banner.
     */
    public function updateBanner(Request $request, PpdbBanner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer',
        ]);

        try {
            $this->ppdbService->updateBanner($request, $banner);

            return redirect()->route('admin.ppdb.index')->with('success', 'Banner PPDB berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui banner.')->withInput();
        }
    }

    /**
     * Toggle banner visibility.
     */
    public function toggleBanner(PpdbBanner $banner)
    {
        $banner->update(['is_active' => ! $banner->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $banner->is_active,
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
