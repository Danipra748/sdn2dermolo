@extends('admin.layout')

@section('title', 'Data Guru')
@section('heading', 'Data Guru')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="glass rounded-3xl p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Manajemen Guru</h2>
                <p class="text-sm text-slate-500">Tambah, ubah, dan hapus data guru.</p>
            </div>
            <a href="{{ route('admin.guru.create') }}" class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
                Tambah Guru
            </a>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-left text-slate-500">
                    <tr>
                        <th class="py-2">No</th>
                        <th class="py-2">Nama</th>
                        <th class="py-2">Jabatan</th>
                        <th class="py-2">NIP</th>
                        <th class="py-2">Gol</th>
                        <th class="py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @forelse ($guru as $item)
                        <tr class="border-t border-slate-200/60">
                            <td class="py-3">{{ $item->no }}</td>
                            <td class="py-3 font-semibold">{{ $item->nama }}</td>
                            <td class="py-3">{{ $item->jabatan }}</td>
                            <td class="py-3">{{ $item->nip }}</td>
                            <td class="py-3">{{ $item->gol }}</td>
                            <td class="py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.guru.edit', $item) }}" class="px-3 py-1 rounded-xl bg-slate-900 text-white text-xs">Edit</a>
                                    <form action="{{ route('admin.guru.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 rounded-xl bg-white border border-slate-200 text-xs">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-slate-200/60">
                            <td colspan="6" class="py-6 text-center text-slate-500">Data guru belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
