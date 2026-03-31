@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Kategori ' . $category->name . ' - Berita')
@section('meta_description', $category->description ?: 'Artikel dalam kategori ' . $category->name)

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
@endpush

@section('content')
    <div class="category-page font-['Plus_Jakarta_Sans'] bg-slate-50 pt-28 pb-16">
        <div class="max-w-6xl mx-auto px-4">
            <div class="category-card bg-white border border-slate-200 rounded-[1.5rem] p-6 mb-8">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Kategori Berita</p>
                <h1 class="category-title font-[Fraunces] text-3xl md:text-4xl font-black text-slate-900 mt-3">{{ $category->name }}</h1>
                @if ($category->description)
                    <p class="text-slate-600 mt-2">{{ $category->description }}</p>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($articles as $article)
                    <a href="{{ route('news.show', $article) }}" class="category-card bg-white rounded-[1.25rem] overflow-hidden border border-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg block">
                        <div class="h-40 bg-slate-200 overflow-hidden">
                            @if ($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-xs text-slate-500">{{ optional($article->published_at)->format('d M Y') }}</p>
                            <h3 class="mt-2 font-semibold text-slate-900 line-clamp-2">{{ $article->title }}</h3>
                            <p class="text-sm text-slate-500 mt-2 line-clamp-3">{{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}</p>
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
