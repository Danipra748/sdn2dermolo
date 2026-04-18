@extends('admin.layout')

@section('title', 'Prestasi Sekolah')
@section('heading', 'Manajemen Prestasi')

@section('content')
    <x-admin.page-header 
        title="Daftar Prestasi Sekolah"
        subtitle="Kelola data pencapaian dan prestasi yang diraih oleh siswa dan sekolah."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12.75L11.25 15 15 9.75M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>'>
        <x-slot:actions>
            <x-admin.button href="{{ route('admin.prestasi-sekolah.create') }}" variant="primary" size="md">
                <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15"/></svg></x-slot:icon>
                Tambah Prestasi
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <x-admin.data-table 
        :headers="['Foto', 'Judul Prestasi', 'Tipe', 'Tingkat', 'Aksi']"
        searchPlaceholder="Cari prestasi..."
        id="prestasiTable">
        
        @forelse($prestasi as $item)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    <div class="w-16 h-10 rounded-lg bg-slate-100 overflow-hidden border border-slate-200">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            </div>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-900">{{ $item->title }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">{{ $item->participant }}</div>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge variant="info">{{ $item->type }}</x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge>{{ $item->level }}</x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <x-admin.button variant="secondary" size="sm" href="{{ route('admin.prestasi-sekolah.edit', $item) }}" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </x-admin.button>
                        <form action="{{ route('admin.prestasi-sekolah.destroy', $item) }}" method="POST" data-confirm="Yakin ingin menghapus prestasi ini?">
                            @csrf
                            @method('DELETE')
                            <x-admin.button type="submit" variant="destructive" size="sm" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 00-7.5 0"/></svg>
                            </x-admin.button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic">
                    Belum ada data prestasi yang ditambahkan.
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
