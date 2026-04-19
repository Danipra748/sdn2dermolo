<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\SiteSetting;
use App\Services\Modules\PrestasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminPrestasiController extends Controller
{
    protected $prestasiService;

    public function __construct(PrestasiService $prestasiService)
    {
        $this->prestasiService = $prestasiService;
    }

    public function index()
    {
        if (! Schema::hasTable('prestasis')) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi belum tersedia. Jalankan: php artisan migrate');
        }

        $prestasi = Prestasi::latest()->get();

        return view('admin.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        return view('admin.prestasi.form', [
            'prestasi' => new Prestasi,
            'action' => route('admin.prestasi-sekolah.store'),
            'method' => 'POST',
            'title' => 'Tambah Prestasi Sekolah',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePrestasi($request);
        $this->prestasiService->store($data, $request);

        return redirect()->route('admin.prestasi-sekolah.index')
            ->with('status', 'Data prestasi berhasil ditambahkan.');
    }

    public function edit(Prestasi $prestasi)
    {
        return view('admin.prestasi.form', [
            'prestasi' => $prestasi,
            'action' => route('admin.prestasi-sekolah.update', $prestasi),
            'method' => 'PUT',
            'title' => 'Edit Prestasi Sekolah',
        ]);
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $data = $this->validatePrestasi($request);
        $this->prestasiService->update($prestasi, $data, $request);

        return redirect()->route('admin.prestasi-sekolah.index')
            ->with('status', 'Data prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        $this->prestasiService->delete($prestasi);

        return redirect()->route('admin.prestasi-sekolah.index')
            ->with('status', 'Data prestasi berhasil dihapus.');
    }

    public function editRingkasan()
    {
        $saved = SiteSetting::getValue('prestasi_ringkasan');
        $items = $saved ? (json_decode($saved, true) ?: []) : [];

        return view('admin.prestasi.ringkasan', [
            'ringkasanText' => implode("\n", $items),
        ]);
    }

    public function updateRingkasan(Request $request)
    {
        $validated = $request->validate([
            'ringkasan' => ['nullable', 'string'],
        ]);

        $this->prestasiService->updateSummary($validated['ringkasan'] ?? '');

        return redirect()->route('admin.prestasi-sekolah.index')
            ->with('status', 'Ringkasan prestasi berhasil diperbarui.');
    }

    private function validatePrestasi(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
