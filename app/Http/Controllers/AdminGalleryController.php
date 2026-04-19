<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\Modules\GalleryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminGalleryController extends Controller
{
    protected $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    public function index()
    {
        if (! Schema::hasTable('galleries')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia. Jalankan: php artisan migrate');
        }

        $galleries = Gallery::latest()->paginate(12);

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.form', [
            'gallery' => new Gallery,
            'action' => route('admin.gallery.store'),
            'method' => 'POST',
            'title' => 'Tambah Foto Galeri',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateGallery($request);

        try {
            $this->galleryService->store($data, $request);

            return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan foto.')->withInput();
        }
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.form', [
            'gallery' => $gallery,
            'action' => route('admin.gallery.update', $gallery),
            'method' => 'PUT',
            'title' => 'Edit Foto Galeri',
        ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validateGallery($request);

        try {
            $this->galleryService->update($gallery, $data, $request);

            return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui foto.')->withInput();
        }
    }

    public function destroy(Gallery $gallery)
    {
        $this->galleryService->delete($gallery);

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Foto galeri berhasil dihapus.');
    }

    private function validateGallery(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
