<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminProgramPhotoController extends Controller
{
    public function index(Program $programSekolah)
    {
        if (!Schema::hasTable('program_photos')) {
            return redirect()->route('admin.program-sekolah.index')
                ->with('status', 'Tabel dokumentasi program belum tersedia. Jalankan: php artisan migrate');
        }

        $photos = $programSekolah->photos()->get();

        return view('admin.program.photos.index', compact('programSekolah', 'photos'));
    }

    public function create(Program $programSekolah)
    {
        return view('admin.program.photos.form', [
            'programSekolah' => $programSekolah,
            'photo' => new ProgramPhoto(),
            'action' => route('admin.program-sekolah.photos.store', $programSekolah),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request, Program $programSekolah)
    {
        $data = $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $data['photo'] = $request->file('photo')->store('program/photos', 'public');
        $data['program_id'] = $programSekolah->id;

        ProgramPhoto::create($data);

        return redirect()->route('admin.program-sekolah.photos.index', $programSekolah)
            ->with('status', 'Dokumentasi program berhasil ditambahkan.');
    }

    public function edit(Program $programSekolah, ProgramPhoto $photo)
    {
        if ($photo->program_id !== $programSekolah->id) {
            abort(404);
        }

        return view('admin.program.photos.form', [
            'programSekolah' => $programSekolah,
            'photo' => $photo,
            'action' => route('admin.program-sekolah.photos.update', [$programSekolah, $photo]),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Program $programSekolah, ProgramPhoto $photo)
    {
        if ($photo->program_id !== $programSekolah->id) {
            abort(404);
        }

        $data = $request->validate([
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'caption' => ['nullable', 'string', 'max:255'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_photo') && $photo->photo) {
            Storage::disk('public')->delete($photo->photo);
            $photo->photo = null;
        }

        if ($request->hasFile('photo')) {
            if ($photo->photo) {
                Storage::disk('public')->delete($photo->photo);
            }
            $photo->photo = $request->file('photo')->store('program/photos', 'public');
        }

        $photo->caption = $data['caption'] ?? null;
        $photo->save();

        return redirect()->route('admin.program-sekolah.photos.index', $programSekolah)
            ->with('status', 'Dokumentasi program berhasil diperbarui.');
    }

    public function destroy(Program $programSekolah, ProgramPhoto $photo)
    {
        if ($photo->program_id !== $programSekolah->id) {
            abort(404);
        }

        if ($photo->photo) {
            Storage::disk('public')->delete($photo->photo);
        }

        $photo->delete();

        return redirect()->route('admin.program-sekolah.photos.index', $programSekolah)
            ->with('status', 'Dokumentasi program berhasil dihapus.');
    }
}
