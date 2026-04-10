# Instruksi Clear Cache dan Test

## Langkah 1: Clear Cache Laravel

Karena Anda menggunakan Laragon, buka **Terminal** atau **Command Prompt** dan jalankan:

```bash
cd c:\laragon\www\sdnegeri2dermolo

# Clear semua cache
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Atau gunakan satu perintah saja:
php artisan optimize:clear
```

**Jika perintah `php` tidak dikenal**, gunakan path lengkap PHP dari Laragon:

```bash
# Cari dulu PHP version yang ada di Laragon
dir C:\laragon\bin\php\

# Contoh (ganti dengan versi PHP Anda):
"C:\laragon\bin\php\php-8.2.x-Win32-vs16-x64\php.exe" artisan route:clear
"C:\laragon\bin\php\php-8.2.x-Win32-vs16-x64\php.exe" artisan config:clear
"C:\laragon\bin\php\php-8.2.x-Win32-vs16-x64\php.exe" artisan view:clear
"C:\laragon\bin\php\php-8.2.x-Win32-vs16-x64\php.exe" artisan cache:clear
```

## Langkah 2: Test Akses Halaman

### A. Test Halaman Admin Homepage
1. Buka browser
2. Akses: `http://127.0.0.1:8000/admin/homepage`
3. **Harusnya tampil tanpa error 404** ✅
4. Halaman akan menampilkan informasi statis hero section

### B. Test Menu di Admin Dashboard
1. Login ke admin: `http://127.0.0.1:8000/admin`
2. Lihat sidebar kiri
3. **Harusnya ada menu "Pengaturan Beranda"** di bagian "Konten Publik" ✅
4. Klik menu tersebut, harus mengarah ke `/admin/homepage`

### C. Test Frontend (Halaman Publik)
1. Beranda: `http://127.0.0.1:8000/`
2. Tentang Kami: `http://127.0.0.1:8000/tentang-kami`
3. **Kedua halaman harus tetap normal** ✅
4. Bagian kontak harus muncul dengan data dari `config/school.php`

## Langkah 3: Verifikasi Tidak Ada Error

### Cek di Browser Console (F12):
- Tidak ada error JavaScript
- Tidak ada error 404 di Network tab

### Cek di Terminal Laravel:
- Tidak ada error PHP saat akses halaman
- Log tidak menampilkan pesan error

## Jika Masih Error 404

### Kemungkinan 1: Route Belum Ter-register
```bash
# Cek apakah route ada
php artisan route:list | grep homepage

# Harus muncul:
# GET|HEAD  admin/homepage ......... admin.homepage.index
```

### Kemungkinan 2: Cache Masih Tersimpan
```bash
# Hapus semua cache sekaligus
rm -rf bootstrap/cache/*.php

# Lalu restart Laravel
php artisan serve
```

### Kemungkinan 3: View File Tidak Ditemukan
Pastikan file ini ada:
- `resources/views/admin/homepage/index.blade.php` ✅
- `resources/views/admin/layout.blade.php` ✅

### Kemungkinan 4: Controller Error
Pastikan file ini ada:
- `app/Http/Controllers/AdminHomepageController.php` ✅

## Troubleshooting Lainnya

### Error: Class 'SchoolConfig' not found
```bash
composer dump-autoload
php artisan config:clear
```

### Halaman Admin Tampil Tapi Data Tidak Ada
- Ini NORMAL karena data sekarang dari file `config/school.php`
- Edit file tersebut untuk mengubah data
- Lalu jalankan: `php artisan config:clear`

### Menu "Pengaturan Beranda" Tidak Muncul di Sidebar
- Clear view cache: `php artisan view:clear`
- Hard refresh browser: `Ctrl + F5`
- Cek file: `resources/views/admin/layout.blade.php` sudah terupdate

## Konfigurasi yang Sudah Berfungsi

Jika halaman admin homepage sudah bisa dibuka, Anda akan melihat:

✅ **Hero Section Info**
- Title: "Sekolah yang"
- Subtitle: "Membentuk"
- Overlay Opacity: 35%
- Badge Text: "SELAMAT DATANG DI SD N 2 DERMolo"

✅ **Database Images** (jika ada)
- Background image utama
- Slideshow images

✅ **Panduan Edit**
- Cara mengubah config/school.php
- Perintah clear cache

## Selesai!

Jika semua langkah di atas berhasil:
- ✅ Error 404 sudah hilang
- ✅ Halaman `/admin/homepage` bisa diakses
- ✅ Menu admin muncul di sidebar
- ✅ Frontend tetap normal tanpa perubahan
- ✅ Performa lebih baik (data statis)

---

**Catatan:** Jika masih ada masalah setelah melakukan semua langkah di atas, 
silakan screenshot error yang muncul dan saya akan membantu troubleshoot lebih lanjut.
