# Hero Section Fix - SD N 2 Dermolo

## Tanggal: 12 April 2026

## Perubahan yang Dilakukan:

### 1. Struktur Hero Section
- **TETAP**: Menggunakan struktur slider yang sudah ada (bukan Swiper.js, tapi custom slideshow)
- **TETAP**: Loop `@foreach` hanya membungkus `.hero-slide` individual
- **TETAP**: Dark overlay dengan opacity 0.35-0.5 untuk kontras dengan teks putih

### 2. Perbaikan Badge (Sentence Case)
**SEBELUM:**
```
SELAMAT DATANG DI SD N 2 DermoLO
```

**SESUDAH:**
```
Selamat Datang di SD N 2 Dermolo
```

- Menggunakan format Sentence Case (huruf besar hanya di awal kata)
- Background tetap transparan gelap (`bg-white/10` dengan `backdrop-blur`)

### 3. Penataan Judul & Deskripsi
**PERUBAHAN STRUKTUR:**
- Judul Utama (`#hero-title-text`): Terpisah dari subtitle
- Sub-judul (`#hero-subtitle-text`): Element terpisah dengan container sendiri
- Deskripsi (`#hero-description`): J距離 lebih proporsional (mt-6)

**STRUKTUR BARU:**
```html
<h1 id="hero-title">
    <span id="hero-title-text">SD N 2 Dermolo</span>
</h1>

<div id="hero-subtitle">
    <span id="hero-subtitle-text">Unggul & Berkarakter Generasi Unggul</span>
</div>

<p id="hero-description">Deskripsi...</p>
```

**JARAK ANTAR ELEMEN:**
- Badge ke Judul: `mt-6` (24px)
- Judul ke Sub-judul: `mt-4` (16px)
- Sub-judul ke Deskripsi: `mt-6` (24px)
- Deskripsi ke Tombol: `mt-10` (40px)

**WARNA TEKS:**
- Judul: `text-white` (putih bersih)
- Sub-judul: Gradient amber-to-yellow (tetap)
- Deskripsi: `text-white/90` (putih dengan opacity 90% untuk kontras optimal)

### 4. Jarak Section Galeri
**PERUBAHAN:**
```html
<!-- SEBELUM -->
<section id="galeri" class="... py-20 md:py-24">

<!-- SESUDAH -->
<section id="galeri" class="... pb-20 pt-16 md:pb-24 md:pt-20">
```

- Padding bottom tetap besar (20/24) untuk jarak dengan section Berita
- Padding top sedikit dikurangi (16/20) agar tidak terlalu renggang dari section Tentang Kami

### 5. Update JavaScript (spa.js)
**FUNGSI `updateHeroText`:**
- Diperbarui untuk menggunakan element IDs yang spesifik (`hero-title-text`, `hero-subtitle-text`)
- Tidak lagi menggunakan `innerHTML` dengan split `<br>`
- Langsung update `textContent` untuk keamanan dan performa lebih baik

## File yang Diubah:
1. `resources/views/spa/partials/home.blade.php` - Struktur HTML Hero Section
2. `public/js/spa.js` - Fungsi updateHeroText untuk dynamic content

## Testing Checklist:
- [ ] Hero slideshow berjalan normal (autoplay 5 detik)
- [ ] Teks berubah sesuai slide yang aktif
- [ ] Badge tampil dengan sentence case yang rapi
- [ ] Judul, sub-judul, dan deskripsi tidak menumpuk
- [ ] Teks putih kontras dengan background gambar
- [ ] Jarak antara section Galeri dan Berita cukup longgar
- [ ] Dot navigation berfungsi dengan baik
- [ ] Pause on hover berjalan normal

## Catatan Penting:
- TIDAK mengubah class CSS global yang sudah benar
- TIDAK menambahkan emoji apapun
- Struktur HTML tetap menggunakan custom slideshow (bukan Swiper.js)
- JavaScript sudah dioptimalkan untuk struktur HTML baru
