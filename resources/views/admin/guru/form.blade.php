@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@section('content')
    <div class="modern-card p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-800">{{ $title }}</h2>
                <p class="text-sm text-slate-500 mt-1">Lengkapi data guru dengan benar.</p>
            </div>
            <a href="{{ route('admin.guru.index') }}" class="text-sm text-slate-500 hover:text-cyan font-medium">← Kembali</a>
        </div>

        <form action="{{ $action }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="section-card">
                <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800">Identitas Guru</h3>
                    <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">Data pokok</span>
                </div>
                
                <div class="space-y-5">
                    {{-- Baris 1: Nama Lengkap (Full Width) --}}
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $guru->nama) }}"
                            class="form-input" required />
                        @error('nama') <p class="text-xs text-coral mt-2">{{ $message }}</p> @enderror
                    </div>

                    {{-- Baris 2: NIP dan Jabatan (Berjajar) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}"
                                class="form-input" />
                            @error('nip') <p class="text-xs text-coral mt-2">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}"
                                class="form-input" />
                            @error('jabatan') <p class="text-xs text-coral mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Baris 3: Kategori dan Pendidikan (Berjajar) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-input">
                                <option value="">-</option>
                                <option value="L" @selected(old('gender', $guru->gender) === 'L')>Laki-laki</option>
                                <option value="P" @selected(old('gender', $guru->gender) === 'P')>Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Pendidikan (Ijazah)</label>
                            <input type="text" name="ijazah" value="{{ old('ijazah', $guru->ijazah) }}"
                                class="form-input" />
                            @error('ijazah') <p class="text-xs text-coral mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Baris 4: Email dan Urutan Tampil (Berjajar) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Tempat/Tgl Lahir</label>
                            <input type="text" name="tempat_tgl_lahir" value="{{ old('tempat_tgl_lahir', $guru->tempat_tgl_lahir) }}"
                                class="form-input" placeholder="Contoh: Jakarta, 1990-01-01" />
                        </div>
                        <div>
                            <label class="form-label">No Urut</label>
                            <input type="number" name="no" value="{{ old('no', $guru->no) }}"
                                class="form-input" />
                            @error('no') <p class="text-xs text-coral mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Foto & Checkbox Kepala Sekolah --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-4 border-t border-slate-200">
                        <div>
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
                                class="drop-zone-enabled"
                                id="foto-guru" />
                            @error('photo') <p class="text-xs text-coral mt-2">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex flex-col justify-center">
                            @if ($guru->photo)
                                <div class="mb-3">
                                    <p class="text-xs text-slate-500 mb-2">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $guru->photo) }}" alt="{{ $guru->nama }}"
                                         class="h-20 w-20 rounded-lg object-cover object-center border-2 border-slate-200">
                                </div>
                            @endif
                            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" name="remove_photo" value="1"
                                       class="w-4 h-4 rounded border-slate-300 text-cyan focus:ring-cyan/20">
                                Hapus foto saat ini
                            </label>
                            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer mt-3">
                                <input type="checkbox" name="is_kepala_sekolah" value="1"
                                       class="w-4 h-4 rounded border-slate-300 text-cyan focus:ring-cyan/20"
                                       @checked(old('is_kepala_sekolah', $guru->jabatan === 'Kepala Sekolah'))>
                                Kepala Sekolah
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="flex items-center justify-between mb-6 pb-3 border-b border-slate-200">
                    <h3 class="text-base font-semibold text-slate-800">Data Kepegawaian</h3>
                    <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">Informasi status kerja</span>
                </div>
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Karpeg</label>
                        <input type="text" name="karpeg" value="{{ old('karpeg', $guru->karpeg) }}"
                            class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">NUPTK</label>
                        <input type="text" name="nuptk" value="{{ old('nuptk', $guru->nuptk) }}"
                            class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">Gr/Kls/MP</label>
                        <input type="text" name="gr_kls_mp" value="{{ old('gr_kls_mp', $guru->gr_kls_mp) }}"
                            class="form-input" />
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <button type="submit" class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.guru.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
