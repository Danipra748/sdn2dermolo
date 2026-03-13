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

        <div class="mt-5 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="py-2">No</th>
                        <th class="py-2">Icon</th>
                        <th class="py-2">Nama</th>
                        <th class="py-2">Deskripsi</th>
                        <th class="py-2">Warna</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @forelse ($fasilitas as $item)
                        <tr class="border-t border-slate-200/60">
                            <td class="py-3">{{ $loop->iteration }}</td>
                            <td class="py-3">
                                @if ($item->icon_image)
                                    <img src="{{ asset('storage/' . $item->icon_image) }}" alt="{{ $item->nama }}"
                                         class="h-10 w-10 rounded-xl object-cover border border-slate-200">
                                @else
                                    <span class="text-lg">{{ $item->icon ?: '🏫' }}</span>
                                @endif
                            </td>
                            <td class="py-3 font-semibold">{{ $item->nama }}</td>
                            <td class="py-3">{{ $item->deskripsi }}</td>
                            <td class="py-3 capitalize">{{ $item->warna }}</td>
                            <td class="py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.fasilitas.edit', $item) }}"
                                       class="px-3 py-1 rounded-xl bg-slate-900 text-white text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.fasilitas.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus data fasilitas ini?')">
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
                            <td colspan="6" class="py-6 text-center text-slate-500">
                                Data fasilitas belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

