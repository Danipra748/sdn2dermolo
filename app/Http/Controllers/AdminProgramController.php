<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Services\Modules\ProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminProgramController extends Controller
{
    protected $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function index()
    {
        if (! Schema::hasTable('programs')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel program belum tersedia. Jalankan: php artisan migrate');
        }

        $programs = Program::orderBy('id')->paginate(10);

        return view('admin.program.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program.info', [
            'program' => new Program,
            'action' => route('admin.program-sekolah.store'),
            'method' => 'POST',
            'title' => 'Tambah Program Sekolah',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateProgram($request);
        $this->programService->store($data, $request);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Data program sekolah berhasil ditambahkan.');
    }

    public function edit(string $programSekolah)
    {
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
        $program = Program::findOrFail($programSekolah);
        $data = $this->validateProgram($request, $program->id);

        $this->programService->update($program, $data, $request);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Data program sekolah berhasil diperbarui.');
    }

    public function destroy(string $programSekolah)
    {
        $program = Program::findOrFail($programSekolah);
        $this->programService->delete($program);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Data program sekolah berhasil dihapus.');
    }

    private function validateProgram(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = ['required', 'in:pramuka,seni-ukir,drumband', 'unique:programs,slug'];
        if ($ignoreId) {
            $slugRule[] = $ignoreId;
        }

        return $request->validate([
            'slug' => $slugRule,
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
        $program = Program::findOrFail($programSekolah);

        return view('admin.program.highlights', [
            'program' => $program,
            'action' => route('admin.program-sekolah.highlights.update', $program),
        ]);
    }

    public function updateHighlights(Request $request, string $programSekolah)
    {
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

    public function updateCardBackground(Request $request, string $programSekolah)
    {
        $program = Program::findOrFail($programSekolah);

        $data = $request->validate([
            'card_bg_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_card_bg_image' => ['nullable', 'boolean'],
        ]);

        $this->programService->update($program, $data, $request);

        return redirect()->route('admin.program-sekolah.index')
            ->with('status', 'Background kartu program berhasil diperbarui.');
    }

    public function deleteFoto(Request $request, string $programSekolah)
    {
        $program = Program::findOrFail($programSekolah);
        $this->programService->update($program, ['remove_foto' => true], $request);

        return redirect()->route('admin.program-sekolah.edit', $program)
            ->with('success', 'Foto program berhasil dihapus.');
    }

    public function deleteCardBg(Request $request, string $programSekolah)
    {
        $program = Program::findOrFail($programSekolah);
        $this->programService->update($program, ['remove_card_bg_image' => true], $request);

        return redirect()->route('admin.program-sekolah.edit', $program)
            ->with('success', 'Background kartu berhasil dihapus.');
    }

    public function deleteLogo(Request $request, string $programSekolah)
    {
        $program = Program::findOrFail($programSekolah);
        $this->programService->update($program, ['remove_logo' => true], $request);

        return redirect()->route('admin.program-sekolah.edit', $program)
            ->with('success', 'Logo berhasil dihapus.');
    }
}
