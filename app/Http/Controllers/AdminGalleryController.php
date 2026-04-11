<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function index()
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia. Jalankan: php artisan migrate');
        }

        $galleries = Gallery::latest()->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia. Jalankan: php artisan migrate');
        }

        return view('admin.gallery.form', [
            'gallery' => new Gallery(),
            'action' => route('admin.gallery.store'),
            'method' => 'POST',
            'title' => 'Tambah Foto Galeri',
        ]);
    }

    public function store(Request $request)
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia. Jalankan: php artisan migrate');
        }

        $data = $this->validateGallery($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('gallery', 'public');
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia. Jalankan: php artisan migrate');
        }

        $gallery = Gallery::findOrFail($id);

        return view('admin.gallery.form', [
            'gallery' => $gallery,
            'action' => route('admin.gallery.update', $gallery),
            'method' => 'PUT',
            'title' => 'Edit Foto Galeri',
        ]);
    }

    public function update(Request $request, string $id)
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia. Jalankan: php artisan migrate');
        }

        $gallery = Gallery::findOrFail($id);
        $data = $this->validateGallery($request);

        if ($request->hasFile('foto')) {
            if ($gallery->foto) {
                Storage::disk('public')->delete($gallery->foto);
            }

            $data['foto'] = $request->file('foto')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia. Jalankan: php artisan migrate');
        }

        $gallery = Gallery::findOrFail($id);

        if ($gallery->foto) {
            Storage::disk('public')->delete($gallery->foto);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Foto galeri berhasil dihapus.');
    }

    private function validateGallery(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function hasRequiredTables(): bool
    {
        return Schema::hasTable('galleries');
    }
}
