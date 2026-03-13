@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', $article->meta_title ?: $article->title)
@section('meta_description', $article->meta_description ?: ($article->summary ?? Str::limit(strip_tags($article->content), 160)))

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    <style>
        .article-page { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .article-title { font-family: 'Fraunces', serif; }
        .article-content h2 {
            font-size: 1.6rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: .8rem;
            color: #0f172a;
        }
        .article-content h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-top: 1.5rem;
            margin-bottom: .6rem;
            color: #0f172a;
        }
        .article-content p {
            color: #475569;
            line-height: 1.8;
            margin-bottom: 1rem;
        }
        .article-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="article-page pt-28 pb-16">
        <div class="max-w-4xl mx-auto px-4">
            <div class="article-card p-8">
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                    <span class="px-3 py-1 rounded-full bg-sky-100 text-sky-700 font-semibold">
                        {{ $article->category?->name ?? 'Umum' }}
                    </span>
                    <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                    <span>•</span>
                    <span>{{ number_format($article->view_count) }} views</span>
                </div>

                <h1 class="article-title text-3xl md:text-5xl text-slate-900 mt-4">{{ $article->title }}</h1>
                @if ($article->subtitle)
                    <p class="text-slate-500 text-lg mt-3">{{ $article->subtitle }}</p>
                @endif

                @if ($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                        class="w-full h-80 object-cover rounded-2xl mt-6">
                @endif

                <div class="article-content mt-6">
                    {!! $article->content !!}
                </div>

            </div>

            <div class="mt-10">
                <h2 class="article-title text-2xl text-slate-900 mb-4">Artikel Lainnya</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    @forelse ($related as $item)
                        <a href="{{ route('news.show', $item) }}" class="article-card overflow-hidden">
                            <div class="h-36 bg-slate-200">
                                @if ($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-slate-500">{{ optional($item->published_at)->format('d M Y') }}</p>
                                <h3 class="mt-2 font-semibold text-slate-900">{{ $item->title }}</h3>
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
