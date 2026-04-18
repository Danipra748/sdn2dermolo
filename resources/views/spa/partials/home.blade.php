{{-- ===== HOME CONTENT ===== --}}

{{-- Hero Section with Slideshow --}}
@if(!empty($heroSlides) && count($heroSlides) > 0)
<section id="home" class="hero-fullscreen relative overflow-hidden text-white">
    {{-- Slideshow Background --}}
    <div class="absolute inset-0 z-0 overflow-hidden bg-black">
        @if(count($heroSlides) > 1)
            @foreach($heroSlides as $index => $slide)
                <div class="hero-slide absolute inset-0 transition-opacity duration-[2000ms] ease-in-out"
                     style="opacity: {{ $index === 0 ? 1 : 0 }};"
                     data-slide-index="{{ $index }}"
                     data-slide-title="{!! $slide->title ?? 'SD N 2 Dermolo' !!}"
                     data-slide-subtitle="{!! $slide->subtitle ?? 'Unggul & Berkarakter' !!}"
                     data-slide-description="{!! $slide->description ?? '' !!}">
                    <img src="{{ asset('storage/' . $slide->image_path) }}"
                         alt="{{ $slide->title ?? 'Slide' }}"
                         class="hero-slide-media"
                         loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                         draggable="false">
                    <div class="absolute inset-0 bg-black"
                         style="opacity: 0.5;"></div>
                </div>
            @endforeach
        @else
            @php $slide = $heroSlides->first(); @endphp
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $slide->image_path) }}"
                     alt="{{ $slide->title ?? 'Slide' }}"
                     class="hero-slide-media"
                     loading="eager"
                     draggable="false">
                <div class="absolute inset-0 bg-black"
                     style="opacity: 0.5;"></div>
            </div>
        @endif
    </div>

    @if(count($heroSlides) > 1)
    <div class="absolute bottom-8 left-0 right-0 z-20 flex items-center justify-center gap-3" id="slideshow-dots-container">
        @foreach($heroSlides as $index => $slide)
            <button type="button"
                    class="slideshow-dot h-3 w-3 cursor-pointer rounded-full border-2 border-white/50 transition-all duration-300"
                    style="background-color: {{ $index === 0 ? '#fbbf24' : 'rgba(255, 255, 255, 0.3)' }}; {{ $index === 0 ? 'transform: scale(1.2); border-color: #fbbf24;' : '' }}"
                    data-dot-index="{{ $index }}"
                    aria-label="Go to slide {{ $index + 1 }}">
            </button>
        @endforeach
    </div>
    @endif

    {{-- Hero Content Overlay (Centered) --}}
    <div class="hero-content">
        <div id="hero-slide-content" class="mx-auto max-w-[1200px] px-6 text-center">
            {{-- Badge Selamat Datang --}}
            <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-black/30 px-6 py-2.5 text-sm font-medium tracking-wide text-white backdrop-blur-md">
                <x-heroicon-o-star class="h-4 w-4 text-amber-400" />
                Selamat Datang di SD N 2 Dermolo
            </div>

            {{-- Judul Utama --}}
            <h1 id="hero-title" class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-white">
                <span id="hero-title-text">{!! $heroSlides->first()->title ?? 'SD N 2 Dermolo' !!}</span>
            </h1>

            {{-- Sub-judul --}}
            <div id="hero-subtitle" class="reveal reveal-delay-1 mt-4 text-center">
                <span id="hero-subtitle-text" class="inline-block bg-gradient-to-r from-amber-400 to-yellow-200 bg-clip-text text-transparent text-[clamp(1.25rem,3vw,2rem)] font-semibold">
                    {!! $heroSlides->first()->subtitle ?? 'Unggul & Berkarakter' !!}
                </span>
            </div>

            {{-- Deskripsi --}}
            <p id="hero-description" class="reveal reveal-delay-2 mx-auto mt-6 max-w-[700px] text-center text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/90">
                {!! $heroSlides->first()->description ?? 'Membangun siswa yang cerdas, berkarakter, dan berprestasi melalui kurikulum merdeka dan lingkungan belajar yang inspiratif.' !!}
            </p>

            {{-- Tombol Aksi --}}
            <div class="reveal reveal-delay-3 mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="#tentang" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-[2.2rem] py-[0.9rem] text-base font-bold shadow-[0_8px_30px_rgba(245,158,11,0.4)] transition-all duration-300 hover:-translate-y-[3px] hover:scale-[1.03] hover:shadow-[0_16px_40px_rgba(245,158,11,0.5)]">
                    <x-heroicon-o-book-open class="h-5 w-5" /> Tentang Kami
                </a>
                <a href="#kontak" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-[2.2rem] py-[0.9rem] text-base font-semibold transition-all duration-300 hover:-translate-y-[3px] hover:bg-white/20 hover:backdrop-blur">
                    <x-heroicon-o-phone class="h-5 w-5" /> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

@else
{{-- Fallback: Static Hero Section Without Slideshow --}}
<section id="home" class="hero-fullscreen relative overflow-hidden text-white"
    style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">

    {{-- Hero Content Overlay (Centered) --}}
    <div class="hero-content">
        <div id="hero-slide-content" class="mx-auto max-w-[1200px] px-6 text-center">
            {{-- Badge Selamat Datang --}}
            <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-black/30 px-6 py-2.5 text-sm font-medium tracking-wide text-white backdrop-blur-md">
                <x-heroicon-o-star class="h-4 w-4 text-amber-400" />
                Selamat Datang di SD N 2 Dermolo
            </div>

            {{-- Judul Utama --}}
            <h1 id="hero-title" class="reveal reveal-delay-1 mt-6 font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-white">
                SD N 2 Dermolo
            </h1>

            {{-- Sub-judul --}}
            <div id="hero-subtitle" class="reveal reveal-delay-1 mt-4 text-center">
                <span class="inline-block bg-gradient-to-r from-amber-400 to-yellow-200 bg-clip-text text-transparent text-[clamp(1.25rem,3vw,2rem)] font-semibold">
                    Unggul & Berkarakter
                </span>
            </div>

            {{-- Deskripsi --}}
            <p id="hero-description" class="reveal reveal-delay-2 mx-auto mt-6 max-w-[700px] text-center text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/90">
                Membangun siswa yang cerdas, berkarakter, dan berprestasi melalui kurikulum merdeka dan lingkungan belajar yang inspiratif.
            </p>

            {{-- Tombol Aksi --}}
            <div class="reveal reveal-delay-3 mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="#tentang" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-[2.2rem] py-[0.9rem] text-base font-bold shadow-[0_8px_30px_rgba(245,158,11,0.4)] transition-all duration-300 hover:-translate-y-[3px] hover:scale-[1.03] hover:shadow-[0_16px_40px_rgba(245,158,11,0.5)]">
                    <x-heroicon-o-book-open class="h-5 w-5" /> Tentang Kami
                </a>
                <a href="#kontak" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-[2.2rem] py-[0.9rem] text-base font-semibold transition-all duration-300 hover:-translate-y-[3px] hover:bg-white/20 hover:backdrop-blur">
                    <x-heroicon-o-phone class="h-5 w-5" /> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Tentang Kami Section --}}
<section id="tentang" class="section relative bg-white px-6 pb-14 pt-20 md:pb-16 md:pt-24">
    <div class="section-inner mx-auto max-w-[1200px]">
        <div class="tentang-grid grid grid-cols-1 items-stretch gap-12 md:grid-cols-2 md:gap-20">
            <div class="tentang-visual reveal relative flex justify-center md:justify-start">
                @if (!empty($sambutanFoto))
                    <div class="tentang-visual-main w-full max-w-sm aspect-square overflow-hidden rounded-2xl shadow-xl">
                        <img src="{{ asset('storage/' . $sambutanFoto) }}" 
                             alt="Foto Kepala Sekolah" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="tentang-visual-main w-full max-w-sm aspect-square flex items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 to-blue-800 shadow-xl">
                        <div class="flex w-3/4 max-w-xs items-center justify-center">
                            <svg width="180" height="180" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width=".8" xmlns="http://www.w3.org/2000/svg" class="relative z-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="absolute inset-0" style="background: radial-gradient(circle at 30% 70%, rgba(16,185,129,0.3), transparent 50%), radial-gradient(circle at 70% 30%, rgba(245,158,11,0.2), transparent 50%);"></div>
                    </div>
                @endif
            </div>

            <div class="reveal reveal-delay-1 self-center">
                <div class="section-label inline-flex items-center gap-2 rounded-full bg-blue-100 px-4 py-[0.4rem] text-[0.8rem] font-bold uppercase tracking-[0.12em] text-blue-600">
                    <x-heroicon-o-building-library class="h-4 w-4" /> Tentang Kami
                </div>
                <h2 class="section-title mb-5 mt-4 font-display text-[clamp(2rem,4vw,3rem)] font-black leading-[1.15] tracking-[-0.02em] text-slate-900">
                    Sambutan Kepala Sekolah
                </h2>
                @php
                    $fullText = $sambutanText ?? '';
                    $fokusPos = mb_strpos($fullText, 'Fokus utama kami');

                    if ($fokusPos !== false) {
                        $paragraf1 = trim(mb_substr($fullText, 0, $fokusPos));
                        $paragraf2 = trim(mb_substr($fullText, $fokusPos));
                        $paragraf2 = preg_replace('/\n[A-Z][A-Z\s\.,]+,\s*S\.\w+\.?S?\w*\nKepala.*$/s', '', $paragraf2);
                        $paragraf2 = trim($paragraf2);
                    } else {
                        $paragraphs = collect(preg_split('/\r\n|\r|\n/', $fullText))
                            ->map(fn ($line) => trim($line))
                            ->filter()
                            ->values();
                        $paragraf1 = $paragraphs->take($paragraphs->count() - 2)->implode(' ');
                        $paragraf2 = $paragraphs->slice($paragraphs->count() - 2)->take(1)->first() ?? '';
                    }
                @endphp

                <p class="section-desc mb-4 max-w-[560px] text-[1.05rem] leading-[1.7] text-slate-500">
                    {{ $paragraf1 }}
                </p>

                @if($paragraf2)
                <p class="section-desc mb-4 max-w-[560px] text-[1.05rem] leading-[1.7] text-slate-500">
                    {{ $paragraf2 }}
                </p>
                @endif

                @if($kepsek)
                <div class="mt-6 border-t border-slate-200 pt-4">
                    <p class="font-semibold text-slate-900">{{ $kepsek->nama }}</p>
                    <p class="text-sm text-slate-600">{{ $kepsek->jabatan }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Galeri Section --}}
@if($galeri && $galeri->count() > 0)
<section id="galeri" class="section relative bg-white px-6 pb-20 pt-16 md:pb-24 md:pt-20">
    <div class="section-inner mx-auto max-w-[1200px]">
        <div class="text-center reveal">
            <div class="section-label inline-flex items-center justify-center gap-2 rounded-full bg-blue-100 px-4 py-[0.4rem] text-[0.8rem] font-bold uppercase tracking-[0.12em] text-blue-600">
                <x-heroicon-o-camera class="h-4 w-4" /> GALERI
            </div>
            <h2 class="section-title mt-3 font-display text-[clamp(2rem,4vw,3rem)] font-black leading-[1.15] tracking-[-0.02em] text-slate-900">
                Galeri Terbaru
            </h2>
            <p class="section-desc mx-auto mt-4 max-w-[560px] text-[1.05rem] leading-[1.7] text-slate-500">
                Dokumentasi kegiatan dan momen berharga di SD N 2 Dermolo.
            </p>
        </div>

        <div class="galeri-grid mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($galeri as $item)
            <button type="button"
               class="galeri-card group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm reveal transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer"
               data-gallery-card
               data-title="{{ $item->judul ?? '' }}"
               data-desc="{{ $item->deskripsi ?? '' }}"
               data-image="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}">
                @if($item->foto)
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ asset('storage/' . $item->foto) }}"
                             alt="{{ $item->judul }}"
                             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @else
                    <div class="aspect-[4/3] bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                        <x-heroicon-o-camera class="h-16 w-16 text-white opacity-50" />
                    </div>
                @endif

                <div class="p-5">
                    <div class="mb-2 text-[0.72rem] font-bold uppercase tracking-[0.18em] text-blue-600">Galeri</div>
                    <h3 class="mb-2 text-[0.95rem] font-bold leading-snug text-slate-900 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit($item->judul, 50) }}
                    </h3>
                    @if($item->deskripsi)
                    <p class="text-[0.8rem] leading-5 text-slate-600 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}
                    </p>
                    @endif
                    <div class="mt-3 pt-2 border-t border-slate-100 text-[0.72rem] font-semibold uppercase tracking-[0.1em] text-blue-600">
                        Klik untuk detail
                    </div>
                </div>
            </button>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('gallery.index') }}"
               class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700">
                <x-heroicon-o-arrow-right class="h-5 w-5" />
                Lihat Semua Galeri
            </a>
        </div>
    </div>
</section>

{{-- Gallery Modal for Homepage --}}
<div id="gallery-modal" class="fixed inset-0 hidden items-center justify-center p-6 z-[60]" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-900/60" data-gallery-close></div>
    <div class="relative bg-white rounded-[1.5rem] overflow-hidden max-w-[900px] w-full grid grid-cols-1 md:grid-cols-[1.2fr_1fr] shadow-[0_30px_60px_rgba(15,23,42,0.2)] z-10" role="dialog" aria-modal="true" aria-labelledby="gallery-modal-title">
        <button type="button" class="absolute top-[0.75rem] right-[0.75rem] w-[38px] h-[38px] rounded-full bg-white border border-slate-200 inline-flex items-center justify-center shadow-[0_8px_18px_rgba(15,23,42,0.12)] cursor-pointer z-20" data-gallery-close aria-label="Tutup">
            <x-heroicon-o-x-mark class="w-5 h-5 text-slate-700" />
        </button>
        <div class="bg-slate-200 min-h-[300px]">
            <img id="gallery-modal-image" alt="" class="w-full h-full object-cover" />
        </div>
        <div class="p-6">
            <h3 id="gallery-modal-title" class="font-black text-[1.35rem] text-slate-900"></h3>
            <p id="gallery-modal-desc" class="mt-[0.75rem] text-slate-500 leading-[1.7]"></p>
        </div>
    </div>
</div>

@endif

{{-- Berita Section --}}
@if($berita && $berita->count() > 0)
<section id="berita" class="section relative bg-slate-50 px-6 py-20 md:py-24">
    <div class="section-inner mx-auto max-w-[1200px]">
        <div class="text-center reveal">
            <div class="section-label inline-flex items-center justify-center gap-2 rounded-full bg-blue-100 px-4 py-[0.4rem] text-[0.8rem] font-bold uppercase tracking-[0.12em] text-blue-600">
                <x-heroicon-o-document-text class="h-4 w-4" /> BERITA & ARTIKEL
            </div>
            <h2 class="section-title mt-3 font-display text-[clamp(2rem,4vw,3rem)] font-black leading-[1.15] tracking-[-0.02em] text-slate-900">
                Berita Terbaru
            </h2>
            <p class="section-desc mx-auto mt-4 max-w-[560px] text-[1.05rem] leading-[1.7] text-slate-500">
                Informasi kegiatan dan cerita terbaru dari SD N 2 Dermolo.
            </p>
        </div>

        <div class="berita-grid mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($berita as $item)
            <a href="{{ route('news.show', $item->slug ?? $item->id) }}"
               class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm reveal transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                @if($item->featured_image)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ asset('storage/' . $item->featured_image) }}"
                             alt="{{ $item->title }}"
                             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @else
                    <div class="aspect-video bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                        <x-heroicon-o-document-text class="h-16 w-16 text-white opacity-50" />
                    </div>
                @endif

                <div class="p-6">
                    @if($item->category)
                    <span class="mb-3 inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600">
                        {{ $item->category->name }}
                    </span>
                    @endif

                    <h3 class="font-bold text-slate-900 transition group-hover:text-blue-600 line-clamp-2">
                        {{ $item->title }}
                    </h3>

                    @if($item->summary || $item->content)
                    <p class="mt-2 text-sm text-slate-600 line-clamp-2">
                        {{ $item->summary ?? \Illuminate\Support\Str::limit(strip_tags($item->content), 90) }}
                    </p>
                    @endif

                    @if($item->published_at)
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                        <x-heroicon-o-calendar class="h-4 w-4" />
                        {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('news.index') }}"
               class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700">
                <x-heroicon-o-arrow-right class="h-5 w-5" />
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
@endif
