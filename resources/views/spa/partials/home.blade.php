{{-- ===== HOME CONTENT ===== --}}

{{-- Hero Section --}}
<section id="home" class="hero-fullscreen relative overflow-hidden text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    @php
        $heroExtra = $hero->extra_data ?? null;
        if (is_string($heroExtra)) {
            $decodedExtra = json_decode($heroExtra, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $heroExtra = $decodedExtra;
            }
        }

        $images = [];
        $rawImages = data_get($heroExtra, 'slideshow_images', []);
        if (is_string($rawImages)) {
            $decodedImages = json_decode($rawImages, true);
            $rawImages = (json_last_error() === JSON_ERROR_NONE) ? $decodedImages : [$rawImages];
        }
        if (is_array($rawImages)) {
            $images = $rawImages;
        }

        if (! empty($hero->background_image)) {
            array_unshift($images, $hero->background_image);
        }

        $images = array_map(function ($img) {
            if (is_string($img)) {
                return $img;
            }
            if (is_array($img)) {
                return $img['path'] ?? $img['url'] ?? $img['image'] ?? null;
            }
            if (is_object($img)) {
                return $img->path ?? $img->url ?? $img->image ?? null;
            }

            return null;
        }, $images);

        $images = array_values(array_unique(array_filter($images, function ($img) {
            return is_string($img) && trim($img) !== '';
        })));

        $heroBadgeText = data_get($heroExtra, 'badge_text');
        $heroTitle = data_get($hero, 'title', 'Sekolah yang');
        $heroSubtitle = data_get($hero, 'subtitle', 'Membentuk');
        $heroDescription = data_get($hero, 'description');
        $heroOverlayOpacity = data_get($hero, 'background_overlay_opacity', 0.35);
        
        // Extract per-slide texts
        $slideTexts = data_get($heroExtra, 'slide_texts', []);
        if (is_string($slideTexts)) {
            $decodedSlideTexts = json_decode($slideTexts, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $slideTexts = $decodedSlideTexts;
            } else {
                $slideTexts = [];
            }
        }
        if (!is_array($slideTexts)) {
            $slideTexts = [];
        }
    @endphp

    @if($hero && count($images) > 0)
        <div class="absolute inset-0 z-0 overflow-hidden bg-black">
            @if(count($images) > 1)
                @foreach($images as $index => $image)
                    @php
                        $slideTitle = $slideTexts[$index]['title'] ?? ($index === 0 ? $heroTitle : '');
                        $slideSubtitle = $slideTexts[$index]['subtitle'] ?? ($index === 0 ? $heroSubtitle : '');
                    @endphp
                    <div class="hero-slide absolute inset-0 transition-opacity duration-[2000ms] ease-in-out"
                         style="opacity: {{ $index === 0 ? 1 : 0 }};"
                         data-slide-index="{{ $index }}"
                         data-slide-title="{{ e($slideTitle) }}"
                         data-slide-subtitle="{{ e($slideSubtitle) }}">
                        <img src="{{ asset('storage/' . $image) }}"
                             alt=""
                             class="hero-slide-media"
                             loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                             draggable="false">
                        <div class="absolute inset-0 bg-slate-900"
                             style="opacity: {{ $heroOverlayOpacity }};"></div>
                    </div>
                @endforeach
            @else
                <div class="absolute inset-0">
                    <img src="{{ asset('storage/' . $images[0]) }}"
                         alt=""
                         class="hero-slide-media"
                         loading="eager"
                         draggable="false">
                    <div class="absolute inset-0 bg-slate-900"
                         style="opacity: {{ $heroOverlayOpacity }};"></div>
                </div>
            @endif
        </div>

        @if(count($images) > 1)
        <div class="absolute bottom-8 left-0 right-0 z-20 flex items-center justify-center gap-3" id="slideshow-dots-container">
            @foreach($images as $index => $image)
                <button type="button"
                        class="slideshow-dot h-3 w-3 cursor-pointer rounded-full border-2 border-white/50 transition-all duration-300"
                        style="background-color: {{ $index === 0 ? '#fbbf24' : 'rgba(255, 255, 255, 0.3)' }}; {{ $index === 0 ? 'transform: scale(1.2); border-color: #fbbf24;' : '' }}"
                        data-dot-index="{{ $index }}"
                        aria-label="Go to slide {{ $index + 1 }}">
                </button>
            @endforeach
        </div>
        @endif
    @endif

    <div class="hero-content relative z-10 mx-auto max-w-[1200px] px-6 py-16 text-center">
        @if($hero && is_scalar($heroBadgeText) && trim((string) $heroBadgeText) !== '')
            <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
                <x-heroicon-o-star class="h-4 w-4" /> {{ $heroBadgeText }}
            </div>
        @else
            <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-semibold tracking-[0.04em] text-white backdrop-blur">
                <x-heroicon-o-star class="h-4 w-4" /> SELAMAT DATANG DI SD N 2 DermoLO
            </div>
        @endif

        <h1 id="hero-title" class="reveal reveal-delay-1 mt-6 text-center font-display text-[clamp(2rem,5vw,3.5rem)] font-black leading-[1.15] tracking-[-0.02em] text-white">
            {{ $heroTitle }}<br>
            <span id="hero-subtitle" class="bg-gradient-to-r from-amber-400 to-yellow-200 bg-clip-text text-transparent">{{ $heroSubtitle }} Generasi Unggul</span>
        </h1>

        @if($heroDescription)
            <p class="reveal reveal-delay-2 mx-auto mt-4 max-w-[700px] text-center text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
                {{ $heroDescription }}
            </p>
        @else
            <p class="reveal reveal-delay-2 mx-auto mt-4 max-w-[700px] text-center text-[clamp(0.95rem,1.8vw,1.15rem)] leading-[1.7] text-white/85">
                Membangun siswa yang cerdas, berkarakter, dan berprestasi melalui
                kurikulum merdeka dan lingkungan belajar yang inspiratif.
            </p>
        @endif

        <div class="reveal reveal-delay-3 mt-6 flex flex-wrap items-center justify-center gap-4">
            <a href="#tentang" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-[2.2rem] py-[0.9rem] text-base font-bold shadow-[0_8px_30px_rgba(245,158,11,0.4)] transition-all duration-300 hover:-translate-y-[3px] hover:scale-[1.03] hover:shadow-[0_16px_40px_rgba(245,158,11,0.5)]">
                <x-heroicon-o-book-open class="h-5 w-5" /> Tentang Kami
            </a>
            <a href="#kontak" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-[2.2rem] py-[0.9rem] text-base font-semibold transition-all duration-300 hover:-translate-y-[3px] hover:bg-white/20 hover:backdrop-blur">
                <x-heroicon-o-phone class="h-5 w-5" /> Hubungi Kami
            </a>
        </div>
    </div>
</section>

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
                    Profil Singkat SD N 2 Dermolo
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

{{-- Kontak Section --}}
<section id="kontak" class="section px-6 pb-14 pt-16" style="background: #f8fafc;">
    <div class="section-inner mx-auto max-w-[1200px]">
        <div class="text-center reveal">
            <div class="section-label inline-flex items-center justify-center gap-2 rounded-full bg-blue-100 px-4 py-[0.4rem] text-[0.8rem] font-bold uppercase tracking-[0.12em] text-blue-600">
                <x-heroicon-o-phone class="h-4 w-4" /> KONTAK
            </div>
            <h2 class="section-title mt-3 font-display text-[clamp(2rem,4vw,3rem)] font-black leading-[1.15] tracking-[-0.02em] text-slate-900">Hubungi Kami</h2>
            <p class="section-desc mx-auto mt-4 max-w-[560px] text-[1.05rem] leading-[1.7] text-slate-500">
                Lokasi sekolah, informasi alamat, dan kanal komunikasi utama SD N 2 Dermolo.
            </p>
        </div>

        <div class="kontak-grid mt-12 grid grid-cols-[repeat(auto-fit,minmax(260px,1fr))] gap-6">
            <div class="kontak-card kontak-card-blue reveal relative overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white p-6 text-left shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] before:absolute before:inset-0 before:bg-gradient-to-br before:from-blue-600/6 before:to-blue-500/6 before:opacity-0 before:transition-opacity before:duration-[350ms] hover:before:opacity-100">
                <div class="kontak-icon mb-4 flex h-11 w-11 items-center justify-center rounded-[0.85rem] border border-slate-900/8 text-xl" style="background: rgba(26,86,219,0.1);">
                    <x-heroicon-o-map-pin class="h-5 w-5 text-blue-600" />
                </div>
                <div class="kontak-meta mb-2 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-slate-400">Alamat Sekolah</div>
                <div class="kontak-body rounded-[0.9rem] border border-slate-200 bg-slate-50 p-4">
                    <h3 class="mb-1 text-[1.05rem] font-black text-slate-900">Alamat</h3>
                    <p>{!! $alamatLines->implode('<br>') !!}</p>
                </div>
            </div>
            <div class="kontak-card kontak-card-green reveal reveal-delay-1 relative overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white p-6 text-left shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] before:absolute before:inset-0 before:bg-gradient-to-br before:from-emerald-600/4 before:to-emerald-400/4 before:opacity-0 before:transition-opacity before:duration-[350ms] hover:before:opacity-100">
                <div class="kontak-icon mb-4 flex h-11 w-11 items-center justify-center rounded-[0.85rem] border border-slate-900/8 text-xl" style="background: rgba(16,185,129,0.1);">
                    <x-heroicon-o-phone class="h-5 w-5 text-emerald-600" />
                </div>
                <div class="kontak-meta mb-2 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-slate-400">Kontak Cepat</div>
                <div class="kontak-body rounded-[0.9rem] border border-slate-200 bg-slate-50 p-4">
                    @if($kontak['phone'])
                    <p class="mb-2 text-slate-700">
                        <span class="mr-1">Tel:</span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $kontak['phone']) }}" class="hover:text-blue-600">{{ $kontak['phone'] }}</a>
                    </p>
                    @endif
                    @if($kontak['email'])
                    <p class="text-slate-700">
                        <span class="mr-1">Email:</span>
                        <a href="mailto:{{ $kontak['email'] }}" class="hover:text-blue-600">{{ $kontak['email'] }}</a>
                    </p>
                    @endif
                </div>
            </div>
            <div class="kontak-card kontak-card-purple reveal reveal-delay-2 relative overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white p-6 text-left shadow-[0_10px_30px_rgba(15,23,42,0.06)] transition-all duration-[350ms] hover:-translate-y-[6px] hover:border-transparent hover:shadow-[0_18px_40px_rgba(15,23,42,0.12)] before:absolute before:inset-0 before:bg-gradient-to-br before:from-violet-600/4 before:to-violet-400/4 before:opacity-0 before:transition-opacity before:duration-[350ms] hover:before:opacity-100">
                <div class="kontak-icon mb-4 flex h-11 w-11 items-center justify-center rounded-[0.85rem] border border-slate-900/8 text-xl" style="background: rgba(124,58,237,0.1);">
                    <x-heroicon-o-clock class="h-5 w-5 text-violet-600" />
                </div>
                <div class="kontak-meta mb-2 text-[0.75rem] font-bold uppercase tracking-[0.12em] text-slate-400">Informasi</div>
                <div class="kontak-body rounded-[0.9rem] border border-slate-200 bg-slate-50 p-4">
                    <p class="mb-2 text-slate-700">07:00 - 14:00 WIB</p>
                    <p class="text-slate-700">Senin - Jumat</p>
                </div>
            </div>
        </div>

        <div class="kontak-extra reveal mt-10 grid grid-cols-1 gap-6 md:grid-cols-[1.2fr_0.8fr]">
            @include('partials.school-map-embed')
            <div class="rounded-[1.25rem] border border-slate-200 bg-white p-6 shadow-[0_1px_3px_rgba(0,0,0,0.08),0_1px_2px_rgba(0,0,0,0.06)]">
                <h3 class="text-xl font-black text-slate-900">Formulir Saran</h3>
                <p class="mt-2 text-[0.92rem] leading-[1.6] text-slate-500">
                    Kami menghargai masukan Anda. Silakan isi formulir di bawah ini untuk memberikan saran atau pertanyaan.
                </p>
                <form action="{{ route('contact-messages.store') }}" method="POST" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <label for="nama" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="name" 
                            required
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        />
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            placeholder="contoh@email.com"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        />
                    </div>
                    <div>
                        <label for="pesan" class="mb-1.5 block text-sm font-semibold text-slate-700">Pesan/Saran</label>
                        <textarea 
                            id="pesan" 
                            name="message" 
                            rows="5" 
                            required
                            placeholder="Tulis saran atau pertanyaan Anda di sini..."
                            class="w-full resize-none rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 transition-all duration-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        ></textarea>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full rounded-lg bg-blue-600 px-6 py-3 text-base font-bold text-white shadow-lg shadow-blue-600/30 transition-all duration-200 hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-600/40 hover:-translate-y-0.5 active:translate-y-0 active:shadow-md"
                    >
                        Kirim Saran
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
