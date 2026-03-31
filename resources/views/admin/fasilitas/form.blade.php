@extends('admin.layout')

@section('title', $title)
@section('heading', $title)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.1.3/trix.min.css">
@endpush

@section('content')
    <div class="glass rounded-3xl p-6 max-w-3xl">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Icon (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $fasilitas->icon) }}"
                           placeholder="Contoh: 🏫"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('icon')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    <label class="block text-sm font-medium text-slate-700 mb-1 mt-4">Icon (Gambar)</label>
                    <input type="file" name="icon_image" accept=".jpg,.jpeg,.png,.webp,.svg"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('icon_image')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @if ($fasilitas->icon_image)
                        <img src="{{ asset('storage/' . $fasilitas->icon_image) }}" alt="Icon {{ $fasilitas->nama }}"
                             class="mt-3 h-16 w-16 rounded-xl object-contain border border-slate-200 bg-white">
                        <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-600">
                            <input type="checkbox" name="remove_icon_image" value="1"
                                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                            Hapus icon gambar
                        </label>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Fasilitas</label>
                    <input type="text" name="nama" value="{{ old('nama', $fasilitas->nama) }}"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">
                    @error('nama')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.fasilitas.index') }}"
                   class="px-4 py-2 rounded-2xl border border-slate-300 text-sm text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
@endpush
