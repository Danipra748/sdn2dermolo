<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramPhoto;
use App\Services\Modules\ProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminProgramPhotoController extends Controller
{
    protected $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

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

        $this->programService->storePhoto($programSekolah, $data, $request);

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

        $this->programService->updatePhoto($photo, $data, $request);

        return redirect()->route('admin.program-sekolah.photos.index', $programSekolah)
            ->with('status', 'Dokumentasi program berhasil diperbarui.');
    }

    public function destroy(Program $programSekolah, ProgramPhoto $photo)
    {
        if ($photo->program_id !== $programSekolah->id) {
            abort(404);
        }

        $this->programService->deletePhoto($photo);

        return redirect()->route('admin.program-sekolah.photos.index', $programSekolah)
            ->with('status', 'Dokumentasi program berhasil dihapus.');
    }
}
