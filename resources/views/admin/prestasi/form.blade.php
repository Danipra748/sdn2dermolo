@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@section('content')
    <div class="glass rounded-3xl p-6 max-w-3xl">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul Prestasi</label>
                <input type="text" name="judul" value="{{ old('judul', $prestasi->judul) }}"
                       class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                @error('judul')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span>
                </label>
                <textarea name="deskripsi" rows="4"
                          placeholder="Ceritakan detail prestasi secara lengkap (tidak wajib diisi)"
                          class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                <p class="text-xs text-slate-500 mt-1">
                    ℹ️ Isi deskripsi untuk memberikan detail lebih lengkap tentang prestasi. Bisa dikosongkan jika hanya ingin menampilkan judul dan foto.
                </p>
                @error('deskripsi')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto Dokumentasi</label>
                <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                @error('foto')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                @if ($prestasi->foto)
                    <img src="{{ asset('storage/' . $prestasi->foto) }}" alt="{{ $prestasi->judul }}"
                         class="mt-3 h-24 w-24 rounded-xl object-cover border border-slate-200">
                @endif
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.prestasi-sekolah.index') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
