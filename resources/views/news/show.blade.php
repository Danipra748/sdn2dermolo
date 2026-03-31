@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: ($article->summary ?? Str::limit(strip_tags($article->content), 160)))

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    <style>
        /* Article content typography - required for CMS-generated HTML */
        .article-content h2 { font-size: 1.6rem; font-weight: 700; margin-top: 2rem; margin-bottom: 0.8rem; color: #0f172a; }
        .article-content h3 { font-size: 1.2rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.6rem; color: #0f172a; }
        .article-content p { color: #475569; line-height: 1.8; margin-bottom: 1rem; }
        .article-content ul, .article-content ol { margin-bottom: 1rem; padding-left: 1.5rem; }
        .article-content li { color: #475569; line-height: 1.8; margin-bottom: 0.5rem; }
        .article-content blockquote { border-left: 4px solid #1a56db; padding-left: 1rem; margin: 1.5rem 0; font-style: italic; color: #475569; }
        .article-content img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1rem 0; }
        .article-content a { color: #1a56db; text-decoration: underline; }
    </style>
@endpush

@section('content')
    <div class="article-page font-['Plus_Jakarta_Sans'] bg-slate-50 pt-28 pb-16">
        <div class="max-w-4xl mx-auto px-4">
            <div class="article-card bg-white border border-slate-200 rounded-[1.5rem] p-8">
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                    <span class="px-3 py-1 rounded-full bg-sky-100 text-sky-700 font-semibold">
                        {{ $article->category?->name ?? 'Umum' }}
                    </span>
                    <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                    <span>•</span>
                    <span>{{ number_format($article->view_count) }} views</span>
                </div>

                <h1 class="article-title font-[Fraunces] text-3xl md:text-5xl font-black text-slate-900 mt-4 leading-tight">{{ $article->title }}</h1>
                @if ($article->subtitle)
                    <p class="text-slate-500 text-lg mt-3">{{ $article->subtitle }}</p>
                @endif

                @if ($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                        class="w-full h-80 object-cover rounded-2xl mt-6">
                @endif

                <div class="article-content mt-6 text-slate-700">
                    {!! $article->content !!}
                </div>

            </div>

            <div class="mt-10">
                <h2 class="article-title font-[Fraunces] text-2xl font-bold text-slate-900 mb-4">Artikel Lainnya</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    @forelse ($related as $item)
                        <a href="{{ route('news.show', $item) }}" class="article-card bg-white rounded-[1.25rem] overflow-hidden border border-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg block">
                            <div class="h-36 bg-slate-200 overflow-hidden">
                                @if ($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-slate-500">{{ optional($item->published_at)->format('d M Y') }}</p>
                                <h3 class="mt-2 font-semibold text-slate-900 line-clamp-2">{{ $item->title }}</h3>
                            </div>
                        </a>
                    @empty
                        <p class="text-slate-500">Belum ada artikel lainnya.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
