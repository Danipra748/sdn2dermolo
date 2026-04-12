# Panduan Deployment - SD N 2 Dermolo

## Checklist Sebelum Deploy

### 1. Build Assets untuk Production
```bash
# Build optimized assets
php artisan vite:build

# ATAU gunakan npm
npm run build
```

### 2. Pastikan Storage Link Sudah Ada
```bash
# Buat symbolic link dari public/storage ke storage/app/public
php artisan storage:link
```

**PENTING:** Jika sudah ada error "link already exists", itu artinya sudah benar.

### 3. Konfigurasi Environment (.env)
Ubah setting berikut di file `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_database
DB_PASSWORD=password_database
```

### 4. Migration & Seeder
```bash
# Jalankan migration
php artisan migrate --force

# Jika perlu seed data
php artisan db:seed --force
```

### 5. Clear Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan cache:clear
```

---

## Cara Menggunakan Gambar di Laravel

### Metode yang Benar (Sudah Digunakan):

#### 1. **Gambar Upload (Storage)**
Untuk gambar yang diupload user (logo, foto, background, dll):

```blade
<img src="{{ asset('storage/' . $model->foto) }}" alt="Description">
```

**Contoh:**
```blade
<img src="{{ asset('storage/' . $schoolProfile->logo) }}" alt="Logo">
<img src="{{ asset('storage/' . $fasilitas->card_bg_image) }}" alt="Background">
```

**Penjelasan:**
- File disimpan di `storage/app/public/nama_folder/nama_file.jpg`
- Akses via browser: `domain.com/storage/nama_file.jpg`
- Helper `asset()` otomatis generate URL lengkap

#### 2. **Gambar Statis (Public)**
Untuk gambar yang sudah ada di project (icon, logo default, dll):

```blade
<!-- Simpan di public/images/ -->
<img src="{{ asset('images/logo.png') }}" alt="Logo">

<!-- Simpan di resources/img/ (di-compile via Vite) -->
<img src="{{ Vite::asset('resources/img/logo.png') }}" alt="Logo">
```

#### 3. **Background Image Inline**
```blade
<div style="background-image: url('{{ asset('storage/' . $bgImage) }}');">
```

### ⚠️ JANGAN Gunakan:
```blade
<!-- ❌ SALAH - Path relatif tidak akan work di production -->
<img src="../storage/foto.jpg">
<img src="/storage/foto.jpg">

<!-- ✅ BENAR - Selalu gunakan asset() helper -->
<img src="{{ asset('storage/' . $foto) }}">
```

---

## Struktur Folder Gambar

```
sdnegeri2dermolo/
├── storage/app/public/          # Folder upload
│   ├── logos/                   # Logo sekolah
│   ├── guru/                    # Foto guru
│   ├── fasilitas/               # Foto fasilitas
│   ├── gallery/                 # Foto gallery
│   ├── program/                 # Foto program
│   ├── articles/                # Foto artikel
│   └── ...
├── public/
│   ├── storage -> storage/app/public/  # Symbolic link (AUTO)
│   ├── images/                  # Gambar statis (optional)
│   └── build/                   # Build Vite (AUTO)
└── resources/
    ├── css/app.css              # CSS utama
    └── js/app.js                # JS utama
```

---

## Troubleshooting

### Gambar Tidak Muncul di Production

**Solusi 1:** Pastikan storage link ada
```bash
php artisan storage:link
```

**Solusi 2:** Hapus dan buat ulang
```bash
# Windows
rmdir public\storage
php artisan storage:link

# Linux/Mac
rm public/storage
php artisan storage:link
```

**Solusi 3:** Cek permission folder
```bash
# Linux/Mac
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### CSS/JS Tidak Muncul

**Solusi 1:** Build ulang
```bash
npm run build
# atau
php artisan vite:build
```

**Solusi 2:** Pastikan `@vite` directive ada di layout
```blade
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
```

**Solusi 3:** Cek folder `public/build/`
Harus ada file `manifest.json` dan asset compiled.

### Error Migration

**Error:** `Table doesn't exist`
**Solusi:** Sudah diperbaiki di file migration. Jalankan:
```bash
php artisan migrate:fresh --force
```
⚠️ **PERINGATAN:** `migrate:fresh` akan menghapus SEMUA data!

---

## Deploy ke cPanel

### Langkah Lengkap:

1. **Zip seluruh project** (kecuali `vendor`, `node_modules`, `.git`)

2. **Upload ke cPanel** via File Manager atau FTP

3. **Extract di folder tujuan** (misal: `/home/username/public_html`)

4. **Jalankan via SSH/Terminal cPanel:**
```bash
cd /home/username/public_html

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Edit .env sesuai database cPanel

# Setup storage
php artisan storage:link

# Migrate database
php artisan migrate --force

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

5. **Set Document Root** ke folder `public/`

6. **Set File Permissions:**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

---

## Catatan Penting

### Vite vs CDN
- ✅ **PAKE VITE** (sudah dikonfigurasi) - Build asset ter-optimasi
- ❌ **JANGAN PAKE CDN Tailwind** (sudah dihapus dari layout)

### Asset Helper
- ✅ `asset('storage/' . $file)` - Untuk file upload
- ✅ `asset('css/style.css')` - Untuk file di public/
- ✅ `Vite::asset('resources/img/logo.png')` - Untuk resource via Vite

### Environment
- `APP_DEBUG=true` - Untuk development (local)
- `APP_DEBUG=false` - Untuk production (wajib!)

---

## Kontak Developer
Jika ada masalah deployment, hubungi: Dani Pramudianto
