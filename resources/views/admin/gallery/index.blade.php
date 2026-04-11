@extends('admin.layout')

@section('title', 'Galeri Sekolah')
@section('heading', 'Galeri Sekolah')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Dokumentasi Galeri</h2>
                <p class="text-sm text-slate-500">Tambah, edit, dan hapus foto galeri kegiatan sekolah.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.gallery.create') }}"
                   class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                    Tambah Foto Galeri
                </a>
            </div>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="py-2">No</th>
                        <th class="py-2">Foto</th>
                        <th class="py-2">Judul</th>
                        <th class="py-2">Deskripsi</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @forelse ($galleries as $gallery)
                        <tr class="border-t border-slate-200/60">
                            <td class="py-3">{{ $loop->iteration }}</td>
                            <td class="py-3">
                                @if ($gallery->foto)
                                    <img src="{{ asset('storage/' . $gallery->foto) }}" alt="{{ $gallery->judul }}"
                                         class="h-12 w-12 rounded-xl object-cover border border-slate-200">
                                @else
                                    <div class="h-12 w-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-xs">
                                        No Img
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 font-semibold">{{ $gallery->judul }}</td>
                            <td class="py-3">{{ \Illuminate\Support\Str::limit($gallery->deskripsi, 60) }}</td>
                            <td class="py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.gallery.edit', $gallery) }}"
                                       class="btn-edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST"
                                          data-confirm="Hapus foto galeri ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-slate-200/60">
                            <td colspan="5" class="py-6 text-center text-slate-500">
                                Data galeri belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
