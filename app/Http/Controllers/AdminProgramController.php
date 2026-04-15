<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminProgramController extends Controller
{
    public function index()
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::orderBy('id')->get();

        return view('admin.program.index', compact('program'));
    }

    public function create()
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        return view('admin.program.info', [
            'program' => new Program(),
            'action' => route('admin.program-sekolah.store'),
            'method' => 'POST',
            'title' => 'Tambah Program Sekolah',
        ]);
    }

    public function store(Request $request)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $data = $this->validateProgram($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('program', 'public');
        }

        if ($request->hasFile('card_bg_image')) {
            $data['card_bg_image'] = $request->file('card_bg_image')->store('program/card', 'public');
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('program/logo', 'public');
        }

        Program::create($data);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Data program sekolah berhasil ditambahkan.');
    }

    public function edit(string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);

        return view('admin.program.info', [
            'program' => $program,
            'action' => route('admin.program-sekolah.update', $program),
            'method' => 'PUT',
            'title' => 'Edit Info Program',
        ]);
    }

    public function update(Request $request, string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);
        $data = $this->validateProgram($request, $program->id);

        // Handle file uploads using base controller methods
        $data = array_merge($data, $this->handleFileUpload($program, 'foto', $request, 'foto', 'program'));
        $data = array_merge($data, $this->handleFileUpload($program, 'card_bg_image', $request, 'card_bg_image', 'program/card'));
        $data = array_merge($data, $this->handleFileUpload($program, 'logo', $request, 'logo', 'program/logo'));

        // Handle explicit deletions (set to null, don't delete row)
        if ($request->boolean('remove_foto')) {
            $data = array_merge($data, $this->handleFileDeletion($program, 'foto'));
        }

        if ($request->boolean('remove_card_bg_image')) {
            $data = array_merge($data, $this->handleFileDeletion($program, 'card_bg_image'));
        }

        if ($request->boolean('remove_logo')) {
            $data = array_merge($data, $this->handleFileDeletion($program, 'logo'));
        }

        $program->update($data);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Data program sekolah berhasil diperbarui.');
    }

    public function destroy(string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);

        if ($program->foto) {
            Storage::disk('public')->delete($program->foto);
        }
        if ($program->card_bg_image) {
            Storage::disk('public')->delete($program->card_bg_image);
        }
        if ($program->logo) {
            Storage::disk('public')->delete($program->logo);
        }

        $program->delete();

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Data program sekolah berhasil dihapus.');
    }

    private function validateProgram(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'slug' => ['required', 'in:pramuka,seni-ukir,drumband', 'unique:programs,slug,' . $ignoreId],
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['nullable', 'string'],
            'emoji' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'card_bg_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'remove_foto' => ['nullable', 'boolean'],
            'remove_card_bg_image' => ['nullable', 'boolean'],
            'remove_logo' => ['nullable', 'boolean'],
        ]);
    }

    public function editHighlights(string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);

        return view('admin.program.highlights', [
            'program' => $program,
            'action' => route('admin.program-sekolah.highlights.update', $program),
        ]);
    }

    public function updateHighlights(Request $request, string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);

        $data = $request->validate([
            'highlight_1' => ['nullable', 'string'],
            'highlight_2' => ['nullable', 'string'],
            'highlight_3' => ['nullable', 'string'],
        ]);

        $program->update($data);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Highlight program berhasil diperbarui.');
    }

    public function updateIcon(Request $request, string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);

        $data = $request->validate([
            'emoji' => ['nullable', 'string', 'max:20'],
        ]);

        $program->update([
            'emoji' => $data['emoji'] ?? null,
        ]);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Icon program berhasil diperbarui.');
    }

    public function updateHeroBackground(Request $request)
    {
        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Background program menggunakan warna standar sekolah.');
    }

    public function updateCardBackground(Request $request, string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);

        $data = $request->validate([
            'card_bg_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_card_bg_image' => ['nullable', 'boolean'],
        ]);

        // Handle deletion (set to null, don't delete row)
        if ($request->boolean('remove_card_bg_image')) {
            $deleteData = $this->handleFileDeletion($program, 'card_bg_image');
            $program->update($deleteData);
        }

        // Handle upload
        if ($request->hasFile('card_bg_image')) {
            $uploadData = $this->handleFileUpload($program, 'card_bg_image', $request, 'card_bg_image', 'program/card');
            $program->update($uploadData);
        }

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Background kartu program berhasil diperbarui.');
    }

    /**
     * Delete program foto (set to null, don't delete row).
     */
    public function deleteFoto(Request $request, string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);
        $deleteData = $this->handleFileDeletion($program, 'foto');
        $program->update($deleteData);

        return redirect()->route('admin.program-sekolah.edit', $program)
            ->with('success', 'Foto program berhasil dihapus. Anda bisa mengupload foto baru.');
    }

    /**
     * Delete program card background (set to null, don't delete row).
     */
    public function deleteCardBg(Request $request, string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);
        $deleteData = $this->handleFileDeletion($program, 'card_bg_image');
        $program->update($deleteData);

        return redirect()->route('admin.program-sekolah.edit', $program)
            ->with('success', 'Background kartu berhasil dihapus. Anda bisa mengupload background baru.');
    }

    /**
     * Delete program logo (set to null, don't delete row).
     */
    public function deleteLogo(Request $request, string $programSekolah)
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $program = Program::findOrFail($programSekolah);
        $deleteData = $this->handleFileDeletion($program, 'logo');
        $program->update($deleteData);

        return redirect()->route('admin.program-sekolah.edit', $program)
            ->with('success', 'Logo berhasil dihapus. Anda bisa mengupload logo baru.');
    }
}
