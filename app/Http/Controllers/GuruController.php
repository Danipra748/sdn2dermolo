<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::orderBy('no')->get();

        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.form', [
            'guru' => new Guru(),
            'action' => route('admin.guru.store'),
            'method' => 'POST',
            'title' => 'Tambah Guru',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateGuru($request);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }
        Guru::create($data);

        return redirect()->route('admin.guru.index')->with('status', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.form', [
            'guru' => $guru,
            'action' => route('admin.guru.update', $guru),
            'method' => 'PUT',
            'title' => 'Edit Guru',
        ]);
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $this->validateGuru($request);
        if ($request->boolean('remove_photo') && $guru->photo) {
            Storage::disk('public')->delete($guru->photo);
            $data['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            if ($guru->photo) {
                Storage::disk('public')->delete($guru->photo);
            }
            $data['photo'] = $request->file('photo')->store('guru', 'public');
        }
        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('status', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->photo) {
            Storage::disk('public')->delete($guru->photo);
        }
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('status', 'Data guru berhasil dihapus.');
    }

    private function validateGuru(Request $request): array
    {
        return $request->validate([
            'no' => ['nullable', 'integer', 'min:1'],
            'nama' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'nip' => ['nullable', 'string', 'max:255'],
            'karpeg' => ['nullable', 'string', 'max:255'],
            'nuptk' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:5'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'tempat_tgl_lahir' => ['nullable', 'string', 'max:255'],
            'ijazah' => ['nullable', 'string', 'max:255'],
            'mulai_bekerja_permulaan' => ['nullable', 'string', 'max:255'],
            'mulai_bekerja_di_sini' => ['nullable', 'string', 'max:255'],
            'masa_kerja_th' => ['nullable', 'string', 'max:255'],
            'masa_kerja_bl' => ['nullable', 'string', 'max:255'],
            'gol' => ['nullable', 'string', 'max:255'],
            'tmt' => ['nullable', 'string', 'max:255'],
            'gaji_pokok' => ['nullable', 'string', 'max:255'],
            'gr_kls_mp' => ['nullable', 'string', 'max:255'],
            'sk_akhir_tanggal' => ['nullable', 'string', 'max:255'],
            'sertifikasi_nmr_psrt' => ['nullable', 'string', 'max:255'],
            'sertifikasi_tahun' => ['nullable', 'string', 'max:255'],
            'sertifikasi_nrg' => ['nullable', 'string', 'max:255'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);
    }
}
