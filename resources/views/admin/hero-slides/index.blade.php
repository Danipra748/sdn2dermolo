@extends('admin.layout')

@section('title', 'Slideshow Beranda')
@section('heading', 'Manajemen Slideshow')

@section('content')
    <x-admin.page-header 
        title="Slideshow Beranda"
        subtitle="Kelola gambar besar yang tampil di halaman depan website."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'>
        <x-slot:actions>
            <x-admin.button href="{{ route('admin.hero-slides.create') }}" variant="primary" size="md">
                <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15"/></svg></x-slot:icon>
                Tambah Slide
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <x-admin.data-table 
        :headers="['Gambar', 'Judul', 'Status', 'Urutan', 'Aksi']"
        searchPlaceholder="Cari judul slide..."
        id="slidesTable">
        
        @forelse($slides as $slide)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    <div class="w-24 h-12 rounded-lg bg-slate-100 overflow-hidden border border-slate-200">
                        <img src="{{ asset('storage/' . $slide->image_path) }}" class="w-full h-full object-cover">
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-900">{{ $slide->title }}</div>
                    <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $slide->subtitle }}</div>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge :variant="$slide->is_active ? 'success' : 'default'">
                        {{ $slide->is_active ? 'Aktif' : 'Nonaktif' }}
                    </x-admin.badge>
                </td>
                <td class="px-6 py-4 font-bold text-slate-500">
                    {{ $slide->display_order }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <x-admin.button variant="secondary" size="sm" href="{{ route('admin.hero-slides.edit', $slide) }}" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        </x-admin.button>
                        <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" data-confirm="Yakin ingin menghapus slide '{{ $slide->title }}'?">
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
                    Belum ada slide yang ditambahkan.
                </td>
            </tr>
        @endforelse
    </x-admin.data-table>
@endsection
