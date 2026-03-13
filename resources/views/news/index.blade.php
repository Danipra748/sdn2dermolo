@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Berita & Artikel - SD N 2 Dermolo')
@section('meta_description', 'Berita terbaru dan artikel kegiatan SD N 2 Dermolo.')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:   #1a56db;
            --primary-light: #3b82f6;
            --accent:    #f59e0b;
            --accent-2:  #10b981;
            --dark:      #0f172a;
            --dark-2:    #1e293b;
            --surface:   #f8fafc;
            --text:      #334155;
            --text-muted:#64748b;
            --border:    #e2e8f0;
            --radius:    1.25rem;
            --shadow:    0 10px 40px rgba(0,0,0,.08);
        }
        .news-page { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); }
        .news-title { font-family: 'Fraunces', serif; }
        .section { padding: 5rem 1.5rem; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--primary);
            background: rgba(26,86,219,.08);
            padding: .4rem 1rem;
            border-radius: 999px;
            margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Fraunces', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            color: var(--dark);
            line-height: 1.15;
            letter-spacing: -.02em;
        }
        .section-desc {
            color: var(--text-muted);
            font-size: 1.05rem;
            line-height: 1.7;
            max-width: 560px;
        }
        .news-hero {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2.5rem;
            box-shadow: var(--shadow);
        }
        .news-input {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: .75rem 1.25rem;
            width: 100%;
        }
        .news-card {
            background: #fff;
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all .4s cubic-bezier(.34,1.56,.64,1);
            display: block;
        }
        .news-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px rgba(0,0,0,.12);
            border-color: transparent;
        }
        .news-chip { background: rgba(26,86,219,.08); color: #1a56db; }
    </style>
@endpush

@section('content')
    <div class="news-page pt-28 pb-16">
        <div class="section-inner">
            <section class="news-hero">
                <div class="section-label">BERITA SEKOLAH</div>
                <h1 class="section-title">Berita & Artikel SD N 2 Dermolo</h1>
                <p class="section-desc" style="margin-top:.75rem;">
                    Update kegiatan, prestasi, dan cerita inspiratif dari lingkungan sekolah.
                </p>
                <form action="{{ route('news.search') }}" method="GET" class="mt-6 flex flex-col md:flex-row gap-3">
                    <input type="text" name="q" placeholder="Cari artikel..."
                        class="news-input">
                    <button class="px-6 py-3 rounded-full bg-slate-900 text-white text-sm font-semibold hover:opacity-90">
                        Cari
                    </button>
                </form>
            </section>

            <section class="section">
                <div class="text-center" style="margin-bottom: 1rem;">
                    <div class="section-label" style="justify-content:center;">TERBARU</div>
                    <h2 class="section-title">Berita Terbaru</h2>
                    <p class="section-desc" style="margin: 1rem auto 0;">Ringkasan berita terbaru dari sekolah.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    @forelse ($latest as $item)
                        <a href="{{ route('news.show', $item) }}" class="news-card">
                            <div class="h-40 bg-slate-200">
                                @if ($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="news-chip px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $item->category?->name ?? 'Umum' }}
                                    </span>
                                    <span>{{ optional($item->published_at)->format('d M Y') }}</span>
                                </div>
                                <h3 class="mt-3 font-semibold text-slate-900">{{ $item->title }}</h3>
                                <p class="text-sm text-slate-500 mt-2">{{ $item->summary ?? Str::limit(strip_tags($item->content), 90) }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-3 text-slate-500 text-center">Belum ada berita terbaru.</div>
                    @endforelse
                </div>
            </section>

            <section class="section" style="padding-top:0;">
                <div class="text-center" style="margin-bottom: 1rem;">
                    <div class="section-label" style="justify-content:center;">KATEGORI</div>
                    <h2 class="section-title">Kategori Berita</h2>
                    <p class="section-desc" style="margin: 1rem auto 0;">Pilih kategori untuk menjelajahi artikel.</p>
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach ($categories as $category)
                        <a href="{{ route('news.category', $category) }}"
                            class="px-4 py-2 rounded-full bg-white border border-slate-200 text-sm text-slate-700 hover:border-slate-400 transition">
                            {{ $category->name }} ({{ $category->articles_count }})
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="section" style="padding-top:0;">
                <div class="text-center" style="margin-bottom: 1rem;">
                    <div class="section-label" style="justify-content:center;">SEMUA ARTIKEL</div>
                    <h2 class="section-title">Semua Artikel</h2>
                    <p class="section-desc" style="margin: 1rem auto 0;">Total {{ $articles->total() }} artikel dipublikasikan.</p>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    @forelse ($articles as $article)
                        <a href="{{ route('news.show', $article) }}" class="news-card">
                            <div class="grid md:grid-cols-5 gap-4">
                                <div class="md:col-span-2 h-40 bg-slate-200">
                                    @if ($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="md:col-span-3 p-4">
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <span class="news-chip px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $article->category?->name ?? 'Umum' }}
                                        </span>
                                        <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="mt-3 font-semibold text-slate-900">{{ $article->title }}</h3>
                                    <p class="text-sm text-slate-500 mt-2">{{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-slate-500 text-center">Belum ada artikel dipublikasikan.</div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            </section>
        </div>
    </div>
@endsection
