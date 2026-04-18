@extends('admin.layout')

@section('title', 'Manajemen Guru & Staf')

@section('heading', 'Data Guru & Staf')

@section('content')
    <x-admin.page-header 
        title="Daftar Tenaga Pendidik" 
        subtitle="Kelola profil guru dan staf administrasi sekolah."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'>
        <x-slot:actions>
            <x-admin.button href="{{ route('admin.guru.create') }}" variant="primary" size="md">
                <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15"/></svg></x-slot:icon>
                Tambah Guru
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold animate-in fade-in">
            {{ session('success') }}
        </div>
    @endif

    <x-admin.data-table 
        :headers="['No', 'Foto', 'Nama Lengkap', 'Jabatan', 'Aksi']"
        searchPlaceholder="Cari nama atau jabatan guru..."
        id="guruTable">
        
        @forelse($guru as $item)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-slate-400">{{ $item->no }}</td>
                <td class="px-6 py-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 shadow-sm">
                        @if($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                            </div>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-900">{{ $item->nama }}</div>
                    <div class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest mt-0.5">SD N 2 DERMOLO</div>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge variant="info">{{ $item->jabatan }}</x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <x-admin.button variant="secondary" size="sm" href="{{ route('admin.guru.edit', $item) }}" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </x-admin.button>
                        
                        <form action="{{ route('admin.guru.destroy', $item) }}" method="POST" data-confirm="Yakin ingin menghapus guru {{ $item->nama }}?">
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
                    Belum ada data guru yang ditambahkan.
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
