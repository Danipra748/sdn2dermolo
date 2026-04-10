<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminPrestasiController extends Controller
{
    public function index()
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $prestasi = Prestasi::latest()->get();

        return view('admin.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        return view('admin.prestasi.form', [
            'prestasi' => new Prestasi(),
            'action' => route('admin.prestasi-sekolah.store'),
            'method' => 'POST',
            'title' => 'Tambah Prestasi Sekolah',
        ]);
    }

    public function store(Request $request)
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $data = $this->validatePrestasi($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('prestasi', 'public');
        }

        Prestasi::create($data);

        return redirect()->route('admin.prestasi-sekolah.index')
            ->with('status', 'Data prestasi berhasil ditambahkan.');
    }

    public function edit(string $prestasiSekolah)
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $prestasi = Prestasi::findOrFail($prestasiSekolah);

        return view('admin.prestasi.form', [
            'prestasi' => $prestasi,
            'action' => route('admin.prestasi-sekolah.update', $prestasi),
            'method' => 'PUT',
            'title' => 'Edit Prestasi Sekolah',
        ]);
    }

    public function update(Request $request, string $prestasiSekolah)
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $prestasi = Prestasi::findOrFail($prestasiSekolah);
        $data = $this->validatePrestasi($request);

        if ($request->hasFile('foto')) {
            if ($prestasi->foto) {
                Storage::disk('public')->delete($prestasi->foto);
            }

            $data['foto'] = $request->file('foto')->store('prestasi', 'public');
        }

        $prestasi->update($data);

        return redirect()->route('admin.prestasi-sekolah.index')
            ->with('status', 'Data prestasi berhasil diperbarui.');
    }

    public function destroy(string $prestasiSekolah)
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $prestasi = Prestasi::findOrFail($prestasiSekolah);

        if ($prestasi->foto) {
            Storage::disk('public')->delete($prestasi->foto);
        }

        $prestasi->delete();

        return redirect()->route('admin.prestasi-sekolah.index')
            ->with('status', 'Data prestasi berhasil dihapus.');
    }

    public function editRingkasan()
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $saved = SiteSetting::getValue('prestasi_ringkasan');
        $items = [];

        if ($saved) {
            $decoded = json_decode($saved, true);
            $items = is_array($decoded) ? $decoded : [];
        }

        return view('admin.prestasi.ringkasan', [
            'ringkasanText' => implode("\n", $items),
        ]);
    }

    public function updateRingkasan(Request $request)
    {
        if (! $this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel prestasi/site_settings belum tersedia. Jalankan: php artisan migrate');
        }

        $validated = $request->validate([
            'ringkasan' => ['nullable', 'string'],
        ]);

        $lines = collect(preg_split('/\r\n|\r|\n/', $validated['ringkasan'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        SiteSetting::setValue('prestasi_ringkasan', $lines);

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

    private function hasRequiredTables(): bool
    {
        return Schema::hasTable('prestasis') && Schema::hasTable('site_settings');
    }
}
