{{-- Berita SPA Partial --}}
@php use Illuminate\Support\Str; @endphp

<section class="relative overflow-hidden text-white" style="padding-top: 80px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    <div class="mx-auto max-w-[1200px] px-6 py-12 md:py-16 text-center">
        <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg> BERITA & ARTIKEL
        </div>

        <h1 class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-center text-white">
            Berita Terbaru
        </h1>

        <p class="reveal reveal-delay-2 mt-4 text-center max-w-[700px] mx-auto text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
            Informasi kegiatan dan cerita terbaru dari SD N 2 Dermolo.
        </p>
    </div>
</section>

<section class="py-16 px-4 bg-slate-50" data-news-filter-root data-initial-category="all">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex flex-wrap gap-2.5" data-news-category-buttons>
            <button
                type="button"
                data-news-category-button
                data-news-category="all"
                aria-pressed="true"
                class="inline-flex items-center rounded-full border border-slate-900 bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500/20"
            >
                Semua
            </button>
            @foreach ($categories as $category)
                <button
                    type="button"
                    data-news-category-button
                    data-news-category="{{ $category->slug }}"
                    aria-pressed="false"
                    class="inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
        <p class="mb-6 text-sm text-slate-500" data-news-active-label aria-live="polite">
            Menampilkan: <span class="font-semibold text-slate-700" data-news-active-label-text>Semua kategori</span>
        </p>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" data-news-filter-section>
            @forelse ($news as $item)
                <a
                    href="{{ route('news.show', $item->slug ?? $item->id) }}"
                    class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm reveal transition-all duration-[400ms] ease-[cubic-bezier(0.34,1.56,0.64,1)] hover:-translate-y-[6px] hover:border-slate-300 hover:shadow-[0_20px_40px_rgba(15,23,42,0.12)]"
                    style="transition-delay: {{ $loop->index * 0.08 }}s;"
                    data-news-card
                    data-news-category="{{ $item->category?->slug ?? 'uncategorized' }}"
                >
                    @if ($item->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}"
                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                    <div class="p-5">
                        @if ($item->category_id)
                            <span class="mb-3 inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600">
                                {{ $item->category?->name ?? 'Umum' }}
                            </span>
                        @endif
                        <h3 class="font-bold text-slate-900 transition group-hover:text-blue-600 line-clamp-2">{{ $item->title }}</h3>
                        @if ($item->summary || $item->content)
                            <p class="mt-2 text-sm text-slate-600 line-clamp-2">{{ $item->summary ?? Str::limit(strip_tags($item->content), 90) }}</p>
                        @endif
                        @if ($item->published_at)
                            <div class="mt-3 text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="rounded-2xl border border-slate-200 bg-white p-12 shadow-xl">
                        <svg class="w-20 h-20 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <p class="text-lg font-semibold text-slate-500">Belum ada berita</p>
                        <p class="mt-2 text-sm text-slate-400 mb-8">Berita akan ditampilkan di sini setelah ditambahkan</p>

                        <a href="{{ route('home') }}" data-spa="/spa/home" data-spa-title="Beranda - SD N 2 Dermolo" class="group inline-flex items-center gap-3 px-8 py-4 rounded-full text-blue-600 font-bold hover:bg-blue-50 transition shadow-lg text-base">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endforelse
            <div class="col-span-full hidden items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-slate-500 flex-col gap-6 shadow-sm" data-news-empty-state>
                <div>Belum ada berita pada kategori ini.</div>
                <a href="{{ route('home') }}" data-spa="/spa/home" data-spa-title="Beranda - SD N 2 Dermolo" class="group inline-flex items-center gap-3 px-6 py-3 rounded-full text-blue-600 font-bold border border-blue-100 hover:bg-blue-50 transition text-sm">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>
            </div>
            </div>
            </section>