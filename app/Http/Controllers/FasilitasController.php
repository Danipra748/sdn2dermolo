<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Services\Modules\FasilitasService;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    protected $fasilitasService;

    public function __construct(FasilitasService $fasilitasService)
    {
        $this->fasilitasService = $fasilitasService;
    }

    // =========================================================
    // ADMIN - index
    // =========================================================
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    // =========================================================
    // ADMIN - create
    // =========================================================
    public function create()
    {
        return view('admin.fasilitas.form', [
            'fasilitas' => new Fasilitas(),
            'action' => route('admin.fasilitas.store'),
            'method' => 'POST',
            'title' => 'Tambah Fasilitas',
            'kontenValue' => '',
        ]);
    }

    // =========================================================
    // ADMIN - store
    // =========================================================
    public function store(Request $request)
    {
        $validated = $this->validateFasilitas($request);
        $this->fasilitasService->store($validated, $request);

        return redirect()->route('admin.fasilitas.index')
            ->with('status', 'Data fasilitas berhasil ditambahkan.');
    }

    // =========================================================
    // ADMIN - edit
    // =========================================================
    public function edit(Fasilitas $fasilita)
    {
        return view('admin.fasilitas.form', [
            'fasilitas' => $fasilita,
            'action' => route('admin.fasilitas.update', $fasilita),
            'method' => 'PUT',
            'title' => 'Edit Fasilitas',
            'kontenValue' => $fasilita->konten ?? '',
        ]);
    }

    // =========================================================
    // ADMIN - update
    // =========================================================
    public function update(Request $request, Fasilitas $fasilita)
    {
        $validated = $this->validateFasilitas($request);
        $this->fasilitasService->update($fasilita, $validated, $request);

        return redirect()->route('admin.fasilitas.index')
            ->with('status', 'Data fasilitas berhasil diperbarui.');
    }

    // =========================================================
    // ADMIN - destroy
    // =========================================================
    public function destroy(Fasilitas $fasilita)
    {
        $this->fasilitasService->update($fasilita, ['foto' => null, 'icon_image' => null], request()); // Uses update to clean up files
        $fasilita->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('status', 'Data fasilitas berhasil dihapus.');
    }

    private function validateFasilitas(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_foto' => ['nullable', 'boolean'],
        ]);
    }

    // =========================================================
    // PUBLIK
    // =========================================================
    public function ruangKelas()
    {
        $data = $this->fasilitasService->buildPublicData('Ruang Kelas');
        return view('fasilitas.ruang-kelas', compact('data'));
    }

    public function perpustakaan()
    {
        $data = $this->fasilitasService->buildPublicData('Perpustakaan');
        return view('fasilitas.perpustakaan', compact('data'));
    }

    public function musholla()
    {
        $data = $this->fasilitasService->buildPublicData('Musholla');
        return view('fasilitas.musholla', compact('data'));
    }

    public function lapanganOlahraga()
    {
        $data = $this->fasilitasService->buildPublicData('Lapangan Olahraga');
        return view('fasilitas.lapangan-olahraga', compact('data'));
    }
}
