<?php

namespace App\Http\Controllers;

use App\Models\Program;
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

        if ($request->boolean('remove_foto') && $program->foto) {
            Storage::disk('public')->delete($program->foto);
            $data['foto'] = null;
        }

        if ($request->hasFile('foto')) {
            if ($program->foto) {
                Storage::disk('public')->delete($program->foto);
            }

            $data['foto'] = $request->file('foto')->store('program', 'public');
        }

        if ($request->boolean('remove_logo') && $program->logo) {
            Storage::disk('public')->delete($program->logo);
            $data['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($program->logo) {
                Storage::disk('public')->delete($program->logo);
            }

            $data['logo'] = $request->file('logo')->store('program/logo', 'public');
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
            'emoji' => ['nullable', 'string', 'max:10'],
            'hero_color' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'remove_foto' => ['nullable', 'boolean'],
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
}
