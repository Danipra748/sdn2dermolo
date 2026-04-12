# Quick Start Guide - Pembaruan Website SD N 2 Dermolo

## Langkah Cepat (WAJIB DILAKUKAN)

### 1. Run Migration
```bash
cd c:\laragon\www\sdnegeri2dermolo
php artisan migrate
```

### 2. Clear Cache
```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

### 3. Ensure Storage Link
```bash
php artisan storage:link
```

### 4. Test Website
Buka browser dan akses: `http://localhost:8000/`

---

## Cara Menggunakan Fitur Hero Image Upload

### Dari Admin Panel:

1. **Login** ke admin panel: `http://localhost:8000/login`

2. **Navigasi** ke menu:
   ```
   Sidebar > Konten Publik > Gambar Hero Section
   ```

3. **Upload Gambar:**
   - Klik "Choose File" atau drag & drop gambar
   - Preview akan muncul otomatis
   - Klik "Unggah & Aktifkan"

4. **Verifikasi:**
   - Kembali ke beranda
   - Hero section sekarang menampilkan gambar yang diupload

5. **Hapus Gambar** (jika perlu):
   - Klik tombol "Hapus Gambar"
   - Konfirmasi penghapusan
   - Hero section kembali ke gradient biru

---

## Spesifikasi Gambar Hero

- **Format:** JPG, PNG, atau WebP
- **Ukuran File:** Maksimal 2MB
- **Resolusi Rekomendasi:** Minimal 1920x1080 piksel
- **Rasio:** 16:9 (landscape)
- **Konten:** Pastikan area tengah tidak terlalu ramai (akan ditutupi overlay)

---

## Testing Checklist

- [ ] Navbar tampil rata dan sejajar
- [ ] Tidak ada kotak putih saat klik menu
- [ ] Bisa upload gambar hero dari admin
- [ ] Hero section menampilkan gambar setelah upload
- [ ] Hero section kembali ke gradient setelah hapus gambar
- [ ] Navigasi SPA (AJAX) masih berfungsi
- [ ] Admin homepage (/admin/homepage) bisa diakses
- [ ] Tidak ada emoji di tampilan

---

## Troubleshooting Cepat

| Masalah | Solusi |
|---------|--------|
| Migration error | `php artisan migrate:status` (cek tabel sudah ada belum) |
| Gambar tidak muncul | `php artisan storage:link` |
| 404 di admin route | `php artisan route:clear` |
| Navbar masih tidak rata | Hard reload browser: `Ctrl+Shift+R` |
| Validation error upload | Cek format file (JPG/PNG/WebP) dan ukuran (max 2MB) |

---

## File Penting yang Berubah

1. **Navbar:** `resources/views/layouts/app.blade.php`
2. **Hero Frontend:** `resources/views/spa/partials/home.blade.php`
3. **Hero Admin:** `resources/views/admin/hero-image/index.blade.php`
4. **Routes:** `routes/web.php` (tambah route hero-image)
5. **Model:** `app/Models/SiteSetting.php` (tambah methods)

---

## Routes Baru

| Method | URL | Route Name | Fungsi |
|--------|-----|------------|--------|
| GET | `/admin/hero-image` | `admin.hero-image.index` | Halaman kelola hero image |
| PUT | `/admin/hero-image` | `admin.hero-image.update` | Upload hero image |
| DELETE | `/admin/hero-image` | `admin.hero-image.destroy` | Hapus hero image |

---

**Dokumentasi Lengkap:** Lihat file `TECHNICAL-UPDATES-COMPLETE.md`
