@extends('admin.layout')

@section('title', 'Galeri Foto')
@section('heading', 'Manajemen Galeri Foto')

@section('content')
    <x-admin.page-header 
        title="Galeri Foto Sekolah"
        subtitle="Kelola koleksi foto untuk mendokumentasikan kegiatan dan momen penting."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5z"/><path d="M8.25 8.25h.008v.008H8.25V8.25z"/></svg>'>
        <x-slot:actions>
            <x-admin.button href="{{ route('admin.gallery.create') }}" variant="primary" size="md">
                <x-slot:icon><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15"/></svg></x-slot:icon>
                Upload Foto Baru
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galleries as $gallery)
            <div class="glass-card group overflow-hidden animate-in fade-in zoom-in-95">
                <div class="aspect-video bg-slate-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $gallery->foto) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-sm text-slate-900 line-clamp-1">{{ $gallery->title }}</h4>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $gallery->description }}</p>
                </div>
                <div class="p-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <x-admin.button variant="secondary" size="sm" href="{{ route('admin.gallery.edit', $gallery) }}">Edit</x-admin.button>
                    <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" data-confirm="Yakin ingin menghapus foto '{{ $gallery->title }}'?">
                        @csrf
                        @method('DELETE')
                        <x-admin.button type="submit" variant="destructive" size="sm">Hapus</x-admin.button>
                    </form>
                </div>
            </div>
        @empty
            <div class="sm:col-span-2 md:col-span-3 lg:col-span-4 py-20 text-center text-slate-400 italic">
                Belum ada foto yang diupload ke galeri.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $galleries->links() }}
    </div>
@endsection
