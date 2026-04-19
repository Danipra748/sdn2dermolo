@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Berita & Artikel - SD N 2 Dermolo')
@section('meta_description', 'Berita terbaru dan artikel kegiatan SD N 2 Dermolo.')

@section('content')
    <div
        class="news-page font-body bg-slate-50 pt-28 pb-16"
        data-news-filter-root
        data-initial-category="{{ $selectedCategory?->slug ?? 'all' }}"
    >
        <div class="max-w-[1200px] mx-auto px-6">
            <section class="news-hero bg-white border border-slate-200 rounded-[1.25rem] p-10 shadow-[0_10px_40px_rgba(0,0,0,0.08)]">
                <div class="section-label inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-[0.4rem] text-[0.8rem] font-bold uppercase tracking-[0.12em] text-blue-600">BERITA SEKOLAH</div>
                <h1 class="section-title font-display text-[clamp(2rem,4vw,3rem)] font-black leading-[1.15] tracking-[-0.02em] text-slate-900 mt-2">Berita & Artikel SD N 2 Dermolo</h1>
                <p class="section-desc text-[1.05rem] leading-[1.7] text-slate-500 max-w-[560px] mt-3">
                    Update kegiatan, prestasi, dan cerita inspiratif dari lingkungan sekolah.
                </p>
                <div class="mt-6">
                    <div class="flex flex-wrap gap-2.5" data-news-category-buttons>
                        @php
                            $defaultFilterClasses = 'inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-blue-500/20';
                            $activeFilterClasses = 'border-slate-900 bg-slate-900 text-white shadow-sm';
                            $inactiveFilterClasses = 'border-slate-200 bg-white text-slate-600 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600';
                        @endphp
                        <button
                            type="button"
                            data-news-category-button
                            data-news-category="all"
                            aria-pressed="{{ $selectedCategory ? 'false' : 'true' }}"
                            class="{{ $defaultFilterClasses }} {{ $selectedCategory ? $inactiveFilterClasses : $activeFilterClasses }}"
                        >
                            Semua
                        </button>
                        @foreach ($categories as $category)
                            <button
                                type="button"
                                data-news-category-button
                                data-news-category="{{ $category->slug }}"
                                aria-pressed="{{ ($selectedCategory?->id) === $category->id ? 'true' : 'false' }}"
                                class="{{ $defaultFilterClasses }} {{ ($selectedCategory?->id) === $category->id ? $activeFilterClasses : $inactiveFilterClasses }}"
                            >
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                    <p class="mt-3 text-sm text-slate-500" data-news-active-label aria-live="polite">
                        Menampilkan: <span class="font-semibold text-slate-700" data-news-active-label-text>{{ $selectedCategory?->name ?? 'Semua kategori' }}</span>
                    </p>
                </div>
                <form action="{{ route('news.index') }}" method="GET" class="mt-6 news-filter grid grid-cols-1 md:grid-cols-[1.6fr_1fr_auto] gap-3 items-end">
                    <div class="news-field flex flex-col">
                        <label class="news-label text-[0.75rem] font-bold tracking-[0.08em] uppercase text-slate-500 mb-1 inline-block">Cari</label>
                        <input type="text" name="q" placeholder="Cari artikel..."
                            value="{{ $queryText ?? '' }}"
                            class="news-input bg-white border border-slate-200 rounded-full px-5 py-3 w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div class="news-field flex flex-col">
                        <label class="news-label text-[0.75rem] font-bold tracking-[0.08em] uppercase text-slate-500 mb-1 inline-block">Jenis</label>
                        <select name="type" class="news-input bg-white border border-slate-200 rounded-full px-5 py-3 w-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 cursor-pointer">
                            <option value="">Semua</option>
                            <option value="berita" @selected($selectedType === 'berita')>Berita</option>
                            <option value="artikel" @selected($selectedType === 'artikel')>Artikel</option>
                        </select>
                    </div>
                    <input type="hidden" name="category" value="{{ $selectedCategory?->slug ?? '' }}" data-news-category-input>
                    <button class="px-6 py-3 rounded-full bg-slate-900 text-white text-sm font-semibold hover:opacity-90 transition whitespace-nowrap">
                        Terapkan
                    </button>
                </form>
            </section>

            @php
                $latestTitle = $selectedType === 'berita' ? 'Berita Terbaru' : ($selectedType === 'artikel' ? 'Artikel Terbaru' : 'Berita Terbaru');
                $allTitle = $selectedType === 'berita' ? 'Semua Berita' : ($selectedType === 'artikel' ? 'Semua Artikel' : 'Semua Artikel');
            @endphp

            <section class="section py-20 px-6" data-news-filter-section>
                <div class="text-center mb-4">
                    <div class="section-label inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-[0.4rem] text-[0.8rem] font-bold uppercase tracking-[0.12em] text-blue-600 justify-center">TERBARU</div>
                    <h2 class="section-title font-display text-[clamp(2rem,4vw,3rem)] font-black leading-[1.15] tracking-[-0.02em] text-slate-900 mt-2">{{ $latestTitle }}</h2>
                    <p class="section-desc text-[1.05rem] leading-[1.7] text-slate-500 max-w-[560px] mx-auto mt-4">Ringkasan berita terbaru dari sekolah.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    @forelse ($latest as $item)
                        <a
                            href="{{ route('news.show', $item) }}"
                            class="news-card block bg-white rounded-[1.25rem] overflow-hidden border border-slate-200 transition-all duration-[400ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-2 hover:shadow-[0_25px_60px_rgba(0,0,0,0.12)] hover:border-transparent"
                            data-news-card
                            data-news-category="{{ $item->category?->slug ?? 'uncategorized' }}"
                        >
                            <div class="h-40 bg-slate-200 overflow-hidden">
                                @if ($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="news-chip bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $item->category?->name ?? 'Umum' }}
                                    </span>
                                    <span>{{ optional($item->published_at)->format('d M Y') }}</span>
                                </div>
                                <h3 class="mt-3 font-semibold text-slate-900 line-clamp-2">{{ $item->title }}</h3>
                                <p class="text-sm text-slate-500 mt-2 line-clamp-3">{{ $item->summary ?? Str::limit(strip_tags($item->content), 90) }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-3 text-slate-500 text-center">Belum ada berita terbaru.</div>
                    @endforelse
                    <div class="col-span-full hidden items-center justify-center rounded-[1.25rem] border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-slate-500" data-news-empty-state>
                        Belum ada berita terbaru pada kategori ini.
                    </div>
                </div>
            </section>

            <section class="section pt-0 px-6" data-news-filter-section>
                <div class="text-center mb-4">
                    <div class="section-label inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-[0.4rem] text-[0.8rem] font-bold uppercase tracking-[0.12em] text-blue-600 justify-center">SEMUA ARTIKEL</div>
                    <h2 class="section-title font-display text-[clamp(2rem,4vw,3rem)] font-black leading-[1.15] tracking-[-0.02em] text-slate-900 mt-2">{{ $allTitle }}</h2>
                    <p class="section-desc text-[1.05rem] leading-[1.7] text-slate-500 max-w-[560px] mx-auto mt-4">Total {{ $articles->total() }} artikel dipublikasikan.</p>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    @forelse ($articles as $article)
                        <a
                            href="{{ route('news.show', $article) }}"
                            class="news-card block bg-white rounded-[1.25rem] overflow-hidden border border-slate-200 transition-all duration-[400ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-2 hover:shadow-[0_25px_60px_rgba(0,0,0,0.12)] hover:border-transparent"
                            data-news-card
                            data-news-category="{{ $article->category?->slug ?? 'uncategorized' }}"
                        >
                            <div class="grid md:grid-cols-5 gap-4">
                                <div class="md:col-span-2 h-40 bg-slate-200 overflow-hidden">
                                    @if ($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                    @endif
                                </div>
                                <div class="md:col-span-3 p-4">
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <span class="news-chip bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $article->category?->name ?? 'Umum' }}
                                        </span>
                                        <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="mt-3 font-semibold text-slate-900 line-clamp-2">{{ $article->title }}</h3>
                                    <p class="text-sm text-slate-500 mt-2 line-clamp-3">{{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-slate-500 text-center">Belum ada artikel dipublikasikan.</div>
                    @endforelse
                    <div class="col-span-full hidden items-center justify-center rounded-[1.25rem] border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-slate-500" data-news-empty-state>
                        Belum ada artikel pada kategori ini di halaman ini.
                    </div>
                </div>

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            </section>
        </div>
    </div>
@endsection
