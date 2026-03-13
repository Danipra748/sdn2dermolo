@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Kategori ' . $category->name . ' - Berita')
@section('meta_description', $category->description ?: 'Artikel dalam kategori ' . $category->name)

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    <style>
        .category-page { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .category-title { font-family: 'Fraunces', serif; }
        .category-card { background: white; border: 1px solid #e2e8f0; border-radius: 1.5rem; }
    </style>
@endpush

@section('content')
    <div class="category-page pt-28 pb-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="category-card p-6 mb-8">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Kategori Berita</p>
                <h1 class="category-title text-3xl md:text-4xl text-slate-900 mt-3">{{ $category->name }}</h1>
                @if ($category->description)
                    <p class="text-slate-600 mt-2">{{ $category->description }}</p>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($articles as $article)
                    <a href="{{ route('news.show', $article) }}" class="category-card overflow-hidden">
                        <div class="h-40 bg-slate-200">
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-xs text-slate-500">{{ optional($article->published_at)->format('d M Y') }}</p>
                            <h3 class="mt-2 font-semibold text-slate-900">{{ $article->title }}</h3>
                            <p class="text-sm text-slate-500 mt-2">{{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-slate-500">Belum ada artikel pada kategori ini.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection
