# Fix: Undefined Variable $hero Error

## Tanggal: 12 April 2026

## Error yang Terjadi:
```
ErrorException - Internal Server Error
Undefined variable $hero
resources\views\spa\partials\home.blade.php:47
```

## Penyebab Masalah:
Setelah perubahan kode sebelumnya, file `home.blade.php` masih menggunakan variabel `$hero` yang sudah tidak ada di Controller. Controller sekarang menggunakan `$heroSlides` dari tabel `hero_slides`.

## Solusi yang Diterapkan:

### 1. PageController.php
**File**: `app/Http/Controllers/PageController.php`

**PERUBAHAN**:
- Menambahkan import model `HeroSlide`
- Variabel `$heroSlides` sudah dikirim ke view dengan benar

```php
use App\Models\HeroSlide;

// Di method index():
$heroSlides = Schema::hasTable('hero_slides')
    ? \App\Models\HeroSlide::getActiveOrdered()
    : collect();

return view('home', compact(
    'heroSlides',
    'kepsek',
    'sambutanText',
    // ... dll
));
```

### 2. home.blade.php (spa/partials/home.blade.php)
**File**: `resources/views/spa/partials/home.blade.php`

**PERUBAHAN BESAR**:
- Menghapus semua referensi ke `$hero`
- Menghapus `$heroExtra`, `$heroTitle`, `$heroSubtitle`, dll yang berasal dari `$hero`
- Mengganti dengan loop `@foreach($heroSlides as $slide)`
- Menggunakan data dari model `HeroSlide` langsung

**STRUKTUR HERO SECTION BARU**:

```blade
@if(!empty($heroSlides) && count($heroSlides) > 0)
<section id="home" class="hero-fullscreen relative overflow-hidden text-white">
    {{-- Slideshow Background --}}
    <div class="absolute inset-0 z-0 overflow-hidden bg-black">
        @if(count($heroSlides) > 1)
            @foreach($heroSlides as $index => $slide)
                <div class="hero-slide absolute inset-0 transition-opacity duration-[2000ms] ease-in-out"
                     style="opacity: {{ $index === 0 ? 1 : 0 }};"
                     data-slide-index="{{ $index }}"
                     data-slide-title="{{ e($slide->title ?? 'SD N 2 Dermolo') }}"
                     data-slide-subtitle="{{ e($slide->subtitle ?? 'Unggul & Berkarakter') }}"
                     data-slide-description="{{ e($slide->description ?? '') }}">
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
            {{-- Single slide fallback --}}
        @endif
    </div>

    {{-- Hero Content Overlay --}}
    <div class="hero-content absolute inset-0 z-10 flex items-center justify-center">
        <div id="hero-slide-content" class="mx-auto max-w-[1200px] px-6 text-center">
            {{-- Badge - Sentence Case --}}
            <div class="reveal inline-flex items-center gap-2 rounded-full border border-white/20 bg-black/30 px-6 py-2.5 text-sm font-medium tracking-wide text-white backdrop-blur-md">
                <x-heroicon-o-star class="h-4 w-4 text-amber-400" />
                Selamat Datang di SD N 2 Dermolo
            </div>

            {{-- Judul Utama --}}
            <h1 id="hero-title" class="reveal reveal-delay-1 mt-6 ...">
                <span id="hero-title-text">{{ $heroSlides->first()->title ?? 'SD N 2 Dermolo' }}</span>
            </h1>

            {{-- Sub-judul (terpisah) --}}
            <div id="hero-subtitle" class="reveal reveal-delay-1 mt-4 text-center">
                <span id="hero-subtitle-text" class="...">
                    {{ $heroSlides->first()->subtitle ?? 'Unggul & Berkarakter' }}
                </span>
            </div>

            {{-- Deskripsi --}}
            <p id="hero-description" class="reveal reveal-delay-2 mx-auto mt-6 ...">
                {{ $heroSlides->first()->description ?? '...' }}
            </p>

            {{-- Tombol Aksi --}}
            <div class="reveal reveal-delay-3 mt-8 ...">
                ...
            </div>
        </div>
    </div>
</section>

@else
{{-- Fallback: Static Hero Section Without Slideshow --}}
<section id="home" class="hero-fullscreen relative overflow-hidden text-white"
    style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #0ea5e9 100%);">
    ...
</section>
@endif
```

### 3. JavaScript (spa.js)
**File**: `public/js/spa.js`

**PERUBAHAN**:
Function `updateHeroText()` sudah diperbaiki untuk menggunakan element IDs yang spesifik:
- `hero-title-text` (bukan innerHTML dengan `<br>`)
- `hero-subtitle-text`
- `hero-description`

### 4. Jarak Section Galeri
**SUDAH BENAR**:
```blade
<section id="galeri" class="section relative bg-white px-6 pb-20 pt-16 md:pb-24 md:pt-20">
```
- Padding bottom: `pb-20` (mobile) / `pb-24` (desktop)
- Memberikan jarak yang cukup dengan section Berita di bawahnya

## Database Structure:
Tabel `hero_slides` sudah ada dan berisi data:
- Query berjalan: `select * from hero_slides where is_active = 1 order by display_order asc`
- Kolom yang digunakan:
  - `image_path` (path ke gambar di storage)
  - `title` (judul slide)
  - `subtitle` (sub-judul)
  - `description` (deskripsi)
  - `is_active` (boolean)
  - `display_order` (integer)

## Fitur yang Tetap Aman:

### Foto Kepala Sekolah:
```blade
@if (!empty($sambutanFoto))
    <img src="{{ asset('storage/' . $sambutanFoto) }}" ...>
@endif
```

### Sambutan Text:
```blade
@php
    $fullText = $sambutanText ?? '';
    $fokusPos = mb_strpos($fullText, 'Fokus utama kami');
    // Parsing paragraphs...
@endphp
```

Kedua fitur ini tetap berfungsi karena variabel `$sambutanFoto` dan `$sambutanText` masih dikirim dari Controller dengan benar.

## File yang Diubah:
1. `app/Http/Controllers/PageController.php` - Added import HeroSlide
2. `resources/views/spa/partials/home.blade.php` - Complete rewrite of Hero Section
3. `public/js/spa.js` - Updated updateHeroText() function (sebelumnya)

## Testing Checklist:
- [x] Tidak ada error "Undefined variable $hero"
- [x] Hero slideshow berjalan dengan data dari tabel hero_slides
- [x] Badge tampil dengan sentence case: "Selamat Datang di SD N 2 Dermolo"
- [x] Judul, sub-judul, dan deskripsi tidak menumpuk
- [x] Teks putih kontras dengan background gambar (overlay hitam 0.5)
- [x] Jarak antara section Galeri dan Berita cukup longgar (pb-20/24)
- [x] Dot navigation berfungsi
- [x] Autoplay slideshow berjalan (5 detik interval)
- [x] Fitur foto kepala sekolah tetap aman
- [x] Sambutan text tetap tampil
- [x] Tidak ada emoji dalam kode

## Catatan Penting:
- TIDAK ada emoji yang ditambahkan
- Semua class CSS global tetap unchanged
- Struktur slideshow menggunakan custom JS (bukan Swiper.js)
- JavaScript sudah dioptimalkan untuk struktur HTML baru
- Data hero slides diambil dari database (model HeroSlide)
- Fallback tersedia jika tidak ada hero slides
