@extends('admin.layout')

@section('title', 'Data Fasilitas')
@section('heading', 'Data Fasilitas')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Manajemen Fasilitas</h2>
                <p class="text-sm text-slate-500">Tambah, edit, dan kelola seluruh detail isi halaman fasilitas sekolah.</p>
            </div>
            <a href="{{ route('admin.fasilitas.create') }}"
               class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                Tambah Fasilitas
            </a>
        </div>

        <details class="mt-6 rounded-2xl border border-slate-200 bg-white/70 p-4">
            <summary class="cursor-pointer text-sm font-semibold text-slate-700">Pengaturan Tampilan</summary>
            <form action="{{ route('admin.fasilitas.hero-background.update') }}" method="POST"
                  enctype="multipart/form-data" class="mt-4">
                @csrf
                @method('PUT')
                <div class="grid md:grid-cols-2 gap-4 items-center">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Background Halaman Fasilitas</label>
                        <input type="file" name="hero_bg_image" accept=".jpg,.jpeg,.png,.webp"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-slate-300">
                        @error('hero_bg_image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-4">
                        @if (!empty(\App\Models\SiteSetting::getValue('fasilitas_hero_bg_image')))
                            <img src="{{ asset('storage/' . \App\Models\SiteSetting::getValue('fasilitas_hero_bg_image')) }}"
                                 alt="Background Fasilitas" class="h-20 w-full max-w-xs rounded-xl object-cover border border-slate-200">
                            <label class="inline-flex items-center gap-2 text-xs text-slate-600">
                                <input type="checkbox" name="remove_hero_bg_image" value="1"
                                       class="rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                                Hapus background
                            </label>
                        @else
                            <p class="text-xs text-slate-500">Belum ada background.</p>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit"
                            class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                        Simpan Background
                    </button>
                </div>
            </form>
        </details>

        <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200 bg-white/70">
            <table class="w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @forelse ($fasilitas as $item)
                        <tr class="border-t border-slate-200/60">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $item->nama }}</td>
                            <td class="px-4 py-3">{{ $item->deskripsi }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.fasilitas.edit', $item) }}"
                                       class="px-3 py-1 rounded-xl bg-slate-900 text-white text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.fasilitas.destroy', $item) }}" method="POST"
                                          data-confirm="Hapus data fasilitas ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 rounded-xl bg-white border border-slate-200 text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-slate-200/60">
                            <td colspan="4" class="px-4 py-6 text-center text-slate-500">
                                Data fasilitas belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

