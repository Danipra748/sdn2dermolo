@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Cari Artikel - Berita')
@section('meta_description', 'Pencarian artikel berita SD N 2 Dermolo.')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    <style>
        .search-page { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .search-title { font-family: 'Fraunces', serif; }
        .search-card { background: white; border: 1px solid #e2e8f0; border-radius: 1.5rem; }
        .search-input {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: .75rem 1.25rem;
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="search-page pt-28 pb-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="search-card p-6 mb-8">
                <h1 class="search-title text-3xl md:text-4xl text-slate-900">Pencarian Artikel</h1>
                <form action="{{ route('news.search') }}" method="GET" class="mt-4 flex flex-col md:flex-row gap-3">
                    <input type="text" name="q" value="{{ $query }}"
                        placeholder="Ketik kata kunci..."
                        class="search-input">
                    <button class="px-6 py-3 rounded-full bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                        Cari
                    </button>
                </form>
                @if ($query)
                    <p class="text-sm text-slate-500 mt-3">Menampilkan hasil untuk: <span class="font-semibold">{{ $query }}</span></p>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($articles as $article)
                    <a href="{{ route('news.show', $article) }}" class="search-card overflow-hidden">
                        <div class="h-40 bg-slate-200">
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span>{{ $article->category?->name ?? 'Umum' }}</span>
                                <span>•</span>
                                <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                            </div>
                            <h3 class="mt-2 font-semibold text-slate-900">{{ $article->title }}</h3>
                            <p class="text-sm text-slate-500 mt-2">{{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}</p>
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
