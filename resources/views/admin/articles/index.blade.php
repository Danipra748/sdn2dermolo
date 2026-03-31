@extends('admin.layout')

@section('title', 'Manajemen Artikel')
@section('heading', 'Artikel & News')

@section('content')
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Daftar Artikel</h2>
            <p class="text-sm text-slate-500">Kelola draft, publikasi, dan konten berita.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}"
            class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm hover:opacity-90 transition text-center">
            + Artikel Baru
        </a>
    </div>

    <div class="glass rounded-3xl p-6 mb-6">
        <form method="GET" class="grid md:grid-cols-3 gap-4">
            <input type="text" name="q" value="{{ request('q') }}"
                placeholder="Cari judul, ringkasan, subtitle..."
                class="w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">
            <select name="status" class="w-full rounded-2xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-slate-300">
                <option value="">Semua Status</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
            </select>
            <button class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-sm text-slate-700 hover:bg-slate-50 transition">
                Terapkan Filter
            </button>
        </form>
    </div>

    <div class="glass rounded-3xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500">
                        <th class="pb-3">Judul</th>
                        <th class="pb-3">Kategori</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Views</th>
                        <th class="pb-3">Update</th>
                        <th class="pb-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                        <tr class="border-t border-slate-100">
                            <td class="py-3">
                                <div class="font-semibold text-slate-900">{{ $article->title }}</div>
                                <div class="text-xs text-slate-500">{{ $article->slug }}</div>
                            </td>
                            <td class="py-3">{{ $article->category?->name ?? 'Tanpa Kategori' }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded-full text-xs {{ $article->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td class="py-3">{{ number_format($article->view_count) }}</td>
                            <td class="py-3">{{ $article->updated_at->format('d M Y') }}</td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('admin.articles.edit', $article) }}"
                                    class="px-3 py-1 rounded-xl bg-slate-900 text-white text-xs">Edit</a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline"
                                    data-confirm="Hapus artikel ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 rounded-xl bg-red-500 text-white text-xs">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-500">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </div>
@endsection

