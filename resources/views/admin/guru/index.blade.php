@extends('admin.layout')

@section('title', 'Data Guru')
@section('heading', 'Data Guru')

@section('content')
    @if (session('status'))
        <div class="mb-6 alert-success flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="modern-card p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-800">Manajemen Guru</h2>
                <p class="text-sm text-slate-500 mt-1">Tambah, ubah, dan hapus data guru.</p>
            </div>
            <a href="{{ route('admin.guru.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Guru
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="py-3">No</th>
                        <th class="py-3">Foto</th>
                        <th class="py-3">Nama</th>
                        <th class="py-3">Jabatan</th>
                        <th class="py-3">NIP</th>
                        <th class="py-3">Gol</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guru as $item)
                        <tr>
                            <td class="py-3">{{ $item->no }}</td>
                            <td class="py-3">
                                @if ($item->photo)
                                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->nama }}"
                                         class="h-12 w-12 rounded-full object-cover object-center border-2 border-slate-200">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-slate-100 border-2 border-slate-200 flex items-center justify-center text-slate-400 text-sm font-semibold">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 font-semibold text-slate-800">{{ $item->nama }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-cyan/10 text-cyan-dark text-xs font-medium">
                                    {{ $item->jabatan }}
                                </span>
                            </td>
                            <td class="py-3 text-slate-600">{{ $item->nip }}</td>
                            <td class="py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-medium">
                                    {{ $item->gol }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.guru.edit', $item) }}" class="btn-edit">Edit</a>
                                    <form action="{{ route('admin.guru.destroy', $item) }}" method="POST" data-confirm="Hapus data guru ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <p>Data guru belum tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

