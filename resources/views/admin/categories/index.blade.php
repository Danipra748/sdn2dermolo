@extends('admin.layout')

@section('title', 'Kategori Berita')
@section('heading', 'Manajemen Kategori')

@section('content')
    <x-admin.page-header 
        title="Kategori Artikel"
        subtitle="Kelola kategori untuk mengelompokkan berita, artikel, dan pengumuman."
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path d="M6 9h.008v.008H6V9z"/></svg>'>
        <x-slot:actions>
            <x-admin.button href="{{ route('admin.articles.index') }}" variant="secondary" size="md">
                &larr; Kembali ke Artikel
            </x-admin.button>
        </x-slot:actions>
    </x-admin.page-header>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-800 text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Form Create/Edit --}}
        <div class="lg:col-span-1">
            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="glass-card p-6 space-y-4">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif
                <h3 class="text-lg font-bold">{{ isset($category) ? 'Edit Kategori' : 'Buat Kategori Baru' }}</h3>
                <x-admin.form-group label="Nama Kategori" name="name" required>
                    <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" class="w-full form-input" required>
                </x-admin.form-group>

                <x-admin.form-group label="Slug (URL)" name="slug" help="Gunakan huruf kecil, angka, dan tanda hubung (-). Biarkan kosong untuk generate otomatis.">
                    <input type="text" name="slug" value="{{ old('slug', $category->slug ?? '') }}" class="w-full form-input">
                </x-admin.form-group>

                <div class="flex items-center gap-3 pt-2">
                    <x-admin.button type="submit" variant="primary" size="md" class="w-full">{{ isset($category) ? 'Simpan Perubahan' : 'Buat Kategori' }}</x-admin.button>
                    @if(isset($category))
                        <x-admin.button href="{{ route('admin.categories.index') }}" variant="outline" size="md" class="w-full">Batal</x-admin.button>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="lg:col-span-2">
            <x-admin.data-table
                :headers="['Nama Kategori', 'Jumlah Artikel', 'Aksi']"
                searchPlaceholder="Cari kategori...">
                @forelse($categories as $cat)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $cat->name }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $cat->slug }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-500">{{ $cat->articles_count }} Artikel</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-admin.button variant="secondary" size="sm" href="{{ route('admin.categories.edit', $cat) }}" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                </x-admin.button>
                                
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" data-confirm="Yakin ingin menghapus kategori '{{ $cat->name }}'? Ini mungkin mempengaruhi artikel terkait.">
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
                        <td colspan="3" class="px-6 py-20 text-center text-slate-400 italic">
                            Belum ada kategori yang dibuat.
                        </td>
                    </tr>
                @endforelse
            </x-admin.data-table>
        </div>
    </div>
@endsection
