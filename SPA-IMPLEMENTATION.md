# Implementasi Single Page Application (SPA)

## 📋 Ringkasan Implementasi

Website SDN 2 Dermolo telah diubah dari Multi-Page menjadi **Single Page Application (SPA)** dengan dynamic content loading menggunakan AJAX.

---

## 🎯 Fitur yang Diterapkan

### ✅ **1. Arsitektur Single Page**
- Halaman tidak melakukan full refresh saat navigasi
- Konten dimuat secara dinamis via AJAX
- URL tetap di satu domain (menggunakan HTML5 History API)
- Transisi halus dengan fade animation

### ✅ **2. Beranda yang Dibersihkan**
Beranda (Home) **HANYA** menampilkan:
- ✅ Hero Section (Slider)
- ✅ Info Cards (Kurikulum, Guru, Prestasi)
- ✅ Sambutan Kepala Sekolah
- ✅ Visi & Misi
- ✅ Berita Terbaru (ringkas)
- ✅ Kontak & Google Maps

**DIHAPUS dari Beranda:**
- ❌ Section Sarana Prasarana
- ❌ Section Data Guru
- ❌ Section Prestasi detail

### ✅ **3. Navigasi Navbar dengan Dynamic Content**
Menu navbar sekarang memanggil konten via AJAX:

| Menu | Route SPA | Konten yang Dimuat |
|------|-----------|-------------------|
| **Beranda** | `/spa/home` | Hero + Sambutan + Berita + Kontak |
| **Sarana Prasarana** | `/spa/sarana-prasarana` | Daftar fasilitas sekolah |
| **Data Guru** | `/spa/data-guru` | Profil guru & tenaga pendidik |
| **Prestasi** | `/spa/prestasi` | Daftar prestasi siswa |
| **Tentang Kami** | `/spa/about` | Identitas sekolah lengkap |
| **Berita** | `/spa/berita` | Daftar berita & artikel |
| **Program** | `/spa/program` | Ekstrakurikuler |

### ✅ **4. Sinkronisasi Data**
- Semua data tetap diambil dari **database yang sama**
- Perubahan di Admin Panel **langsung tercermin** di frontend
- Tidak ada duplikasi data
- API endpoints menggunakan model dan controller yang sama

---

## 📁 File yang Dibuat/Dimodifikasi

### **File Baru:**

1. **`app/Http/Controllers/SpaController.php`**
   - Controller untuk SPA content loading
   - 7 method untuk setiap section
   - Return JSON response dengan HTML partial

2. **`public/js/spa.js`**
   - JavaScript utama untuk SPA functionality
   - AJAX navigation handler
   - Smooth transitions
   - Slideshow re-initialization
   - Scroll reveal animation

3. **`resources/views/spa/partials/home.blade.php`**
   - Partial view untuk home content (cleaned)
   - Tanpa Sarana Prasarana, Data Guru, Prestasi

### **File yang Dimodifikasi:**

1. **`routes/web.php`**
   - Ditambahkan 7 SPA routes
   - Prefix: `/spa/`

2. **`resources/views/layouts/app.blade.php`**
   - Ditambahkan SPA JavaScript
   - Navbar links updated dengan `data-spa` attributes

---

## 🔧 Cara Kerja SPA

### **Flow Navigasi:**

```
User klik menu di navbar
        ↓
JavaScript intercept click event
        ↓
AJAX request ke /spa/[section]
        ↓
Controller ambil data dari database
        ↓
Render partial view → return HTML
        ↓
JavaScript update content area
        ↓
Smooth fade transition
        ↓
User melihat konten baru (NO REFRESH)
```

### **Data Sync:**

```
Admin Panel → Simpan ke Database
                      ↓
              SPA Controller
                      ↓
              Ambil Data Fresh
                      ↓
              Return ke Frontend
                      ↓
              User melihat data terbaru
```

---

## 🚀 Cara Menggunakan

### **Untuk User:**
1. Buka website seperti biasa
2. Klik menu di navbar
3. Konten akan berubah **tanpa refresh halaman**
4. URL tetap sama, hanya konten yang berubah
5. Gunakan tombol Back/Forward browser untuk navigasi

### **Untuk Admin:**
1. Tetap login ke admin panel seperti biasa
2. Update data (guru, prestasi, fasilitas, dll)
3. Simpan perubahan
4. Data **langsung update** di frontend tanpa perlu clear cache
5. User akan melihat data terbaru saat klik menu

---

## 📝 Catatan Teknis

### **SPA Routes:**

```php
Route::prefix('spa')->name('spa.')->group(function () {
    Route::get('/home', [SpaController::class, 'getHomeContent']);
    Route::get('/sarana-prasarana', [SpaController::class, 'getSaranaPrasaranaContent']);
    Route::get('/data-guru', [SpaController::class, 'getDataGuruContent']);
    Route::get('/prestasi', [SpaController::class, 'getPrestasiContent']);
    Route::get('/about', [SpaController::class, 'getAboutContent']);
    Route::get('/berita', [SpaController::class, 'getBeritaContent']);
    Route::get('/program', [SpaController::class, 'getProgramContent']);
});
```

### **JSON Response Format:**

```json
{
    "success": true,
    "html": "<div>...content HTML...</div>",
    "title": "Page Title - SD N 2 Dermolo",
    "url": "/page-url"
}
```

### **JavaScript Features:**

1. **AJAX Navigation**
   - Fetch API untuk load content
   - JSON response handling
   - Error handling dengan fallback

2. **Smooth Transitions**
   - Fade out (300ms)
   - Content swap
   - Fade in (300ms)

3. **History API**
   - `pushState` untuk update URL
   - `popstate` handler untuk back/forward

4. **Component Re-initialization**
   - Scroll reveal observer
   - Slideshow interval
   - Event listeners

---

## ⚠️ Yang Perlu Diperhatikan

### **Partial Views yang Perlu Dibuat:**

File `resources/views/spa/partials/` perlu dilengkapi dengan:
- ✅ `home.blade.php` (sudah ada)
- ⏳ `sarana-prasarana.blade.php`
- ⏳ `data-guru.blade.php`
- ⏳ `prestasi.blade.php`
- ⏳ `about.blade.php`
- ⏳ `berita.blade.php`
- ⏳ `program.blade.php`

**Cara membuat:**
1. Copy content dari view yang sudah ada (misal: `fasilitas/index.blade.php`)
2. Hapus `@extends('layouts.app')` dan `@section` wrappers
3. Simpan sebagai partial di `spa/partials/`

### **Backward Compatibility:**

- Routes lama **tetap berfungsi** untuk SEO dan direct access
- SPA hanya untuk navigasi dari navbar
- User bisa langsung akses `/prestasi` dan tetap melihat konten
- Admin panel tidak terpengaruh

---

## 🔍 Debugging

### **Check SPA Status:**

Buka Browser Console (F12) dan lihat:
- `🚀 SPA initialized` - SPA berhasil load
- `✅ Content loaded: [title]` - Content berhasil dimuat
- `❌ Error loading content` - Ada error di AJAX request

### **Check API Response:**

Test route langsung di browser:
```
http://localhost:8000/spa/home
http://localhost:8000/spa/sarana-prasarana
```

Response harus JSON dengan format:
```json
{
    "success": true,
    "html": "...",
    "title": "...",
    "url": "..."
}
```

### **Check Database:**

Pastikan tabel yang diperlukan ada:
```sql
SHOW TABLES LIKE 'fasilitas';
SHOW TABLES LIKE 'guru';
SHOW TABLES LIKE 'prestasi';
SHOW TABLES LIKE 'articles';
SHOW TABLES LIKE 'program_sekolah';
```

---

## 🎨 Keunggulan SPA Ini

### **User Experience:**
✅ Navigasi instant tanpa loading page  
✅ Transisi halus dan smooth  
✅ Tidak ada white flash saat pindah halaman  
✅ Browser back/forward tetap berfungsi  

### **Developer Experience:**
✅ Mudah maintenance (satu controller per section)  
✅ Data tetap dari database yang sama  
✅ Admin panel tidak perlu diubah  
✅ SEO tetap terjaga (routes lama masih ada)  

### **Performance:**
✅ Load lebih cepat setelah halaman pertama  
✅ Tidak perlu re-download navbar, footer, CSS  
✅ Hanya konten yang berubah yang di-load  
✅ Browser caching tetap berfungsi  

---

## 📚 Next Steps

1. **Buat partial views** yang belum ada (6 file)
2. **Test semua menu** di navbar
3. **Test mobile navigation**
4. **Optimize loading** (lazy load images)
5. **Add loading indicator** yang lebih baik
6. **Test browser compatibility**

---

**Last Updated:** 2026-04-07  
**Version:** 1.0  
**Author:** AI Assistant  
**Status:** Partial Implementation (home.blade.php done, others pending)
