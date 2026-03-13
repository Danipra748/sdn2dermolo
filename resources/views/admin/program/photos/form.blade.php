@extends('admin.layout')

@section('title', $photo->exists ? 'Edit Dokumentasi' : 'Tambah Dokumentasi')
@section('heading', $photo->exists ? 'Edit Dokumentasi' : 'Tambah Dokumentasi')

@section('content')
    <div class="glass rounded-3xl p-6 max-w-3xl">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto Dokumentasi</label>
                <input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                @error('photo')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                @if ($photo->photo)
                    <img src="{{ asset('storage/' . $photo->photo) }}" alt="Dokumentasi"
                         class="mt-3 h-24 w-24 rounded-xl object-cover border border-slate-200">
                    <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="remove_photo" value="1"
                               class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                        Hapus foto saat ini
                    </label>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="caption" rows="3"
                          class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('caption', $photo->caption) }}</textarea>
                @error('caption')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.program-sekolah.photos.index', $programSekolah) }}"
                   class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
