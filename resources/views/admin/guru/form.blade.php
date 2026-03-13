@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@section('content')
    <div class="glass rounded-3xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">{{ $title }}</h2>
                <p class="text-sm text-slate-500">Lengkapi data guru dengan benar.</p>
            </div>
            <a href="{{ route('admin.guru.index') }}" class="text-sm text-slate-500 hover:text-slate-900">Kembali</a>
        </div>

        <form action="{{ $action }}" method="POST" class="mt-6 grid md:grid-cols-2 gap-4">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div>
                <label class="text-xs text-slate-500">No</label>
                <input type="number" name="no" value="{{ old('no', $guru->no) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
                @error('no') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-slate-500">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" required />
                @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-slate-500">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
                @error('jabatan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-slate-500">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
                @error('nip') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs text-slate-500">Karpeg</label>
                <input type="text" name="karpeg" value="{{ old('karpeg', $guru->karpeg) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">NUPTK</label>
                <input type="text" name="nuptk" value="{{ old('nuptk', $guru->nuptk) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Jenis Kelamin</label>
                <select name="gender" class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm">
                    <option value="">-</option>
                    <option value="L" @selected(old('gender', $guru->gender) === 'L')>L</option>
                    <option value="P" @selected(old('gender', $guru->gender) === 'P')>P</option>
                </select>
            </div>

            <div>
                <label class="text-xs text-slate-500">Tempat/Tgl Lahir</label>
                <input type="text" name="tempat_tgl_lahir" value="{{ old('tempat_tgl_lahir', $guru->tempat_tgl_lahir) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Ijazah</label>
                <input type="text" name="ijazah" value="{{ old('ijazah', $guru->ijazah) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Mulai Bekerja (Permulaan)</label>
                <input type="text" name="mulai_bekerja_permulaan" value="{{ old('mulai_bekerja_permulaan', $guru->mulai_bekerja_permulaan) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Mulai Bekerja (Di Sini)</label>
                <input type="text" name="mulai_bekerja_di_sini" value="{{ old('mulai_bekerja_di_sini', $guru->mulai_bekerja_di_sini) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Masa Kerja (Tahun)</label>
                <input type="text" name="masa_kerja_th" value="{{ old('masa_kerja_th', $guru->masa_kerja_th) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Masa Kerja (Bulan)</label>
                <input type="text" name="masa_kerja_bl" value="{{ old('masa_kerja_bl', $guru->masa_kerja_bl) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Golongan</label>
                <input type="text" name="gol" value="{{ old('gol', $guru->gol) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">TMT</label>
                <input type="text" name="tmt" value="{{ old('tmt', $guru->tmt) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Gaji Pokok</label>
                <input type="text" name="gaji_pokok" value="{{ old('gaji_pokok', $guru->gaji_pokok) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Gr/Kls/MP</label>
                <input type="text" name="gr_kls_mp" value="{{ old('gr_kls_mp', $guru->gr_kls_mp) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Absen S</label>
                <input type="text" name="absen_s" value="{{ old('absen_s', $guru->absen_s) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Absen I</label>
                <input type="text" name="absen_i" value="{{ old('absen_i', $guru->absen_i) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Absen A</label>
                <input type="text" name="absen_a" value="{{ old('absen_a', $guru->absen_a) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">SK Akhir (Tanggal)</label>
                <input type="text" name="sk_akhir_tanggal" value="{{ old('sk_akhir_tanggal', $guru->sk_akhir_tanggal) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Sertifikasi (No Peserta)</label>
                <input type="text" name="sertifikasi_nmr_psrt" value="{{ old('sertifikasi_nmr_psrt', $guru->sertifikasi_nmr_psrt) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Sertifikasi (Tahun)</label>
                <input type="text" name="sertifikasi_tahun" value="{{ old('sertifikasi_tahun', $guru->sertifikasi_tahun) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">Sertifikasi (NRG)</label>
                <input type="text" name="sertifikasi_nrg" value="{{ old('sertifikasi_nrg', $guru->sertifikasi_nrg) }}"
                    class="mt-2 w-full rounded-2xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div class="md:col-span-2 flex gap-3 mt-2">
                <button type="submit" class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.guru.index') }}" class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
