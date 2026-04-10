@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Cari Artikel - Berita')
@section('meta_description', 'Pencarian artikel berita SD N 2 Dermolo.')

@section('content')
    <div class="search-page font-body bg-slate-50 pt-28 pb-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="search-card bg-white border border-slate-200 rounded-[1.5rem] p-6 mb-8">
                <h1 class="search-title font-display text-3xl md:text-4xl font-black text-slate-900">Pencarian Artikel</h1>
                <form action="{{ route('news.search') }}" method="GET" class="mt-4 flex flex-col md:flex-row gap-3">
                    <input type="text" name="q" value="{{ $query }}"
                        placeholder="Ketik kata kunci..."
                        class="search-input bg-white border border-slate-200 rounded-full px-5 py-3 w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <button class="px-6 py-3 rounded-full bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition whitespace-nowrap">
                        Cari
                    </button>
                </form>
                @if ($query)
                    <p class="text-sm text-slate-500 mt-3">Menampilkan hasil untuk: <span class="font-semibold">{{ $query }}</span></p>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($articles as $article)
                    <a href="{{ route('news.show', $article) }}" class="search-card bg-white rounded-[1.25rem] overflow-hidden border border-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg block">
                        <div class="h-40 bg-slate-200 overflow-hidden">
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-semibold">{{ $article->category?->name ?? 'Umum' }}</span>
                                <span>•</span>
                                <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                            </div>
                            <h3 class="mt-2 font-semibold text-slate-900 line-clamp-2">{{ $article->title }}</h3>
                            <p class="text-sm text-slate-500 mt-2 line-clamp-3">{{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-slate-500">Tidak ada artikel ditemukan.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection
