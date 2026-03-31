@extends('admin.layout')

@section('title', 'Edit Ringkasan Prestasi')
@section('heading', 'Edit Ringkasan Prestasi')

@section('content')
    <div class="glass rounded-3xl p-6 max-w-3xl">
        <form action="{{ route('admin.prestasi-sekolah.ringkasan.update') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Hero Background Image</label>
                <input type="file" name="hero_bg_image" accept=".jpg,.jpeg,.png,.webp"
                       class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                @if (!empty($heroBgImage))
                    <img src="{{ asset('storage/' . $heroBgImage) }}" alt="Hero Prestasi"
                         class="mt-3 h-28 w-full object-cover rounded-xl border border-slate-200">
                    <label class="mt-2 inline-flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="remove_hero_bg_image" value="1"
                               class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                        Hapus background saat ini
                    </label>
                @endif
                @error('hero_bg_image')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ringkasan Prestasi</label>
                <p class="text-xs text-slate-500 mb-2">Isi satu ringkasan per baris.</p>
                <textarea name="ringkasan" rows="8"
                          class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('ringkasan', $ringkasanText) }}</textarea>
                @error('ringkasan')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
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
