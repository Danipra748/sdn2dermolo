@extends('admin.layout')

@section('title', 'Program Sekolah')
@section('heading', 'Program Sekolah')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Dokumentasi Program</h2>
                <p class="text-sm text-slate-500">Kelola foto dan deskripsi dokumentasi untuk setiap program.</p>
            </div>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="py-2">No</th>
                        <th class="py-2">Foto</th>
                        <th class="py-2">Slug</th>
                        <th class="py-2">Judul</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @forelse ($program as $item)
                        <tr class="border-t border-slate-200/60">
                            <td class="py-3">{{ $loop->iteration }}</td>
                            <td class="py-3">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->title }}"
                                         class="h-12 w-12 rounded-xl object-cover border border-slate-200">
                                @else
                                    <div class="h-12 w-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-xs">
                                        No Img
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">{{ $item->slug }}</td>
                            <td class="py-3 font-semibold">{{ $item->title }}</td>
                            <td class="py-3">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.program-sekolah.photos.index', $item) }}"
                                       class="px-3 py-1 rounded-xl bg-slate-900 text-white text-xs">
                                        Kelola Dokumentasi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-slate-200/60">
                            <td colspan="5" class="py-6 text-center text-slate-500">
                                Data program belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
