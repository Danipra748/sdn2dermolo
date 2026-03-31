@extends('admin.layout')

@section('title', 'Kategori Artikel')
@section('heading', 'Kategori Artikel')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Kategori</h2>
            <p class="text-sm text-slate-500">Kelola kategori untuk artikel.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition">
            + Kategori Baru
        </a>
    </div>

    <div class="glass rounded-3xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500">
                        <th class="pb-3">Nama</th>
                        <th class="pb-3">Slug</th>
                        <th class="pb-3">Deskripsi</th>
                        <th class="pb-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t border-slate-100">
                            <td class="py-3 font-semibold text-slate-900">{{ $category->name }}</td>
                            <td class="py-3">{{ $category->slug }}</td>
                            <td class="py-3 text-slate-500">{{ $category->description ?: '-' }}</td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="px-3 py-1 rounded-xl bg-slate-900 text-white text-xs">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                                    data-confirm="Hapus kategori ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 rounded-xl bg-red-500 text-white text-xs">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>
@endsection

