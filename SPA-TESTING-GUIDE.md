# Quick Test Guide - SPA Router Fix

## 🚀 Cara Test

### 1. Start Development Server
```bash
php artisan serve
```

### 2. Buka Browser
- URL: `http://localhost:8000`
- Buka **Developer Console** (F12) untuk melihat logs

### 3. Test Navigation
Klik menu berikut secara berurutan dan perhatikan:

#### ✅ Loading Bar Muncul
- Saat klik link, harus muncul **bar tipis** di atas halaman
- Warna: Gradient hijau → biru → ungu
- Animasi smooth dari kiri ke kanan

#### ✅ Konten Update
Setelah klik menu, konten harus berubah **OTOMATIS** tanpa refresh:

| Menu yang Diklik | URL | Konten yang Harus Muncul |
|------------------|-----|--------------------------|
| Beranda | `/` | Hero slideshow, sambutan, galeri, berita |
| Identitas Sekolah | `/tentang-kami` | Stats, profil sekolah, visi-misi, sejarah |
| Sarana & Prasarana | `/fasilitas` | Grid foto fasilitas sekolah |
| Ekstrakurikuler | `/program` | Grid program (pramuka, seni ukir, drumband) |
| Data Guru | `/guru-pendidik` | Foto dan data kepala sekolah & guru |
| Prestasi | `/prestasi` | Grid prestasi siswa |
| Galeri | `/galeri` | Grid foto kegiatan |
| Berita | `/news` | Grid berita dengan filter kategori |

#### ✅ Test Browser Back Button
1. Klik "Beranda" → "Data Guru" → "Prestasi"
2. Tekan **Back Button** di browser
3. Harus kembali ke "Data Guru" dengan konten yang benar
4. Tekan **Back Button** lagi
5. Harus kembali ke "Beranda"

#### ✅ Test Drag & Drop (Admin Area)
1. Login ke admin panel
2. Pindah-pindah halaman (Identitas → Galeri → Guru)
3. Di halaman upload, **drag & drop file** harus tetap berfungsi

### 4. Console Logs yang Harus Muncul

Saat navigasi, di console harus muncul:

```
[SPA] Fetching content from: /spa/data-guru?_t=1234567890 (no-cache)
[SPA] Content fetched successfully for: /spa/data-guru
[SPA] Drop zones reinitialized
[SPA] Admin forms reinitialized
[SPA] Image previews reinitialized
[SPA] Components reinitialized successfully
[SPA] Page navigation complete: /spa/data-guru
```

### 5. Common Issues & Solutions

#### ❌ Issue: Konten Blank
**Solusi:**
- Hard refresh: `Ctrl + Shift + R` (Windows) atau `Cmd + Shift + R` (Mac)
- Clear browser cache
- Cek console untuk error

#### ❌ Issue: Loading Bar Tidak Muncul
**Solusi:**
- Pastikan file `spa.js` sudah ter-load
- Cek di Network tab browser DevTools
- Refresh halaman dengan `Ctrl + F5`

#### ❌ Issue: Drag & Drop Tidak Berfungsi
**Solusi:**
- Pastikan `drop-zone.js` loaded sebelum `spa.js`
- Cek console untuk message `[SPA] Drop zones reinitialized`
- Refresh halaman admin

#### ❌ Issue: Back Button Error
**Solusi:**
- Cek console untuk error history state
- Pastikan URL berubah saat navigasi
- Reload halaman dan coba lagi

### 6. Performance Check

- ✅ Navigasi harus **instant** (< 500ms)
- ✅ Loading bar muncul **smooth**
- ✅ Tidak ada **flicker** atau **flash**
- ✅ Scripts **tidak error** di console
- ✅ Scroll position kembali ke **top** saat ganti halaman

### 7. Mobile Test

Test juga di mobile browser:
- Chrome Mobile
- Safari iOS
- Samsung Internet

Pastikan:
- ✅ Menu mobile berfungsi
- ✅ Loading bar terlihat
- ✅ Swipe back button bekerja
- ✅ Konten responsive

---

## 🎯 Success Criteria

Website dikatakan **BERHASIL** jika:
1. ✅ Semua menu bisa diklik dan konten muncul
2. ✅ Loading bar muncul setiap kali navigasi
3. ✅ Back/Forward button browser berfungsi
4. ✅ Tidak ada error di console
5. ✅ Drag & drop tetap bekerja setelah navigasi
6. ✅ Tidak perlu refresh manual sama sekali

---

**Good Luck! 🚀**
