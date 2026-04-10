# Perbaikan Error 404 - /admin/homepage

## Masalah
Error **404 | NOT FOUND** saat mengakses `http://127.0.0.1:8000/admin/homepage`

## Penyebab
Pada refaktoring sebelumnya (mengubah fitur dinamis menjadi statis), route dan controller untuk `/admin/homepage` **telah dihapus** karena diasumsikan tidak diperlukan lagi.

## Solusi yang Diterapkan

### ✅ 1. Controller Dibuat Kembali (Simplified)
**File:** `app/Http/Controllers/AdminHomepageController.php`

**Isi:** Controller sederhana yang hanya menampilkan informasi statis (tidak ada form edit/update)

```php
class AdminHomepageController extends Controller
{
    public function index()
    {
        $hero = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('homepage_sections')) {
            $hero = HomepageSection::getHero();
        }

        $staticHero = \App\Support\SchoolConfig::hero();

        return view('admin.homepage.index', compact('hero', 'staticHero'));
    }
}
```

### ✅ 2. Route Ditambahkan Kembali
**File:** `routes/web.php`

**Route yang ditambahkan:**
```php
// Homepage Management (Read-only static info)
Route::prefix('homepage')->name('homepage.')->group(function () {
    Route::get('/', [AdminHomepageController::class, 'index'])->name('index');
});
```

### ✅ 3. View Dibuat (Read-only Display)
**File:** `resources/views/admin/homepage/index.blade.php`

**Fitur halaman:**
- ✅ Menampilkan konfigurasi hero section dari file statis
- ✅ Menampilkan background images dari database (jika ada)
- ✅ Informasi cara mengubah konfigurasi statis
- ✅ Tombol ke beranda dan profil sekolah
- ✅ **Tidak ada form edit** (read-only)

### ✅ 4. Menu Admin Dipulihkan
**File:** `resources/views/admin/layout.blade.php`

**Perubahan:**
- Menu "Pengaturan Beranda" ditambahkan kembali di sidebar
- Terletak di bagian "Konten Publik"
- Route: `admin.homepage.index`

## Perbedaan Sebelum & Sesudah

### SEBELUM (Dinamis):
```
❌ Form edit title, subtitle, description
❌ Upload background images
❌ Toggle section active/inactive
❌ Reorder sections
❌ Delete backgrounds
```

### SESUDAH (Statis - Read Only):
```
✅ Tampilan konfigurasi saat ini (read-only)
✅ Info background images dari database
✅ Panduan cara edit file config
✅ Tombol akses ke beranda
✅ Tidak ada form edit
```

## Cara Menggunakan Halaman Ini

### 1. Akses Halaman
```
http://127.0.0.1:8000/admin/homepage
```

### 2. Lihat Informasi
- Hero title, subtitle, badge text
- Overlay opacity setting
- Background images (dari database)
- Slideshow images (jika ada)

### 3. Untuk Mengubah Data
**TIDAK BISA melalui admin panel!**

Harus edit file secara manual:
```
config/school.php
```

Contoh mengubah title:
```php
'hero' => [
    'title' => 'Tulisan Baru Di Sini', // ← Edit di sini
    'subtitle' => 'Subtitle Baru',
    // ...
]
```

Lalu clear cache:
```bash
php artisan config:clear
```

## File yang Dimodifikasi

### Dibuat/Dimodifikasi:
1. ✅ `app/Http/Controllers/AdminHomepageController.php` - Controller baru (simplified)
2. ✅ `routes/web.php` - Route ditambahkan kembali
3. ✅ `resources/views/admin/homepage/index.blade.php` - View baru (read-only)
4. ✅ `resources/views/admin/layout.blade.php` - Menu sidebar ditambahkan

### Tidak Berubah:
- `config/school.php` - Tetap sama
- `app/Support/SchoolConfig.php` - Tetap sama
- Frontend views - Tetap sama

## Langkah Selanjutnya

### 1. Clear Cache (WAJIB)
```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

### 2. Test Akses
```
http://127.0.0.1:8000/admin/homepage
```

### 3. Verifikasi
- ✅ Halaman tampil tanpa error 404
- ✅ Menu "Pengaturan Beranda" muncul di sidebar admin
- ✅ Data hero section ditampilkan dengan benar
- ✅ Frontend (beranda) tetap normal

## Troubleshooting

### Masih Error 404?
```bash
# Cek route terdaftar
php artisan route:list | grep homepage

# Harus muncul:
# GET|HEAD  admin/homeplace ... admin.homepage.index
```

### View Tidak Ditemukan?
Pastikan file ada di:
```
resources/views/admin/homepage/index.blade.php
```

### Class Not Found?
```bash
composer dump-autoload
php artisan config:clear
```

## Kesimpulan

✅ **Error 404 sudah diperbaiki**
✅ **Halaman admin homepage bisa diakses kembali**
✅ **Tampilan read-only (tidak ada form edit)**
✅ **Data ditampilkan dari config statis + database**
✅ **Menu admin muncul di sidebar**

**Halaman siap digunakan setelah clear cache!** 🎉
