# 📋 PERBAIKAN MASALAH LOGO DINAMIS

## 🔍 DIAGNOSIS MASALAH

### Akar Masalah:
1. **Hardcoded Path di Layout** (Line 353)
   - File: `resources/views/layouts/app.blade.php`
   - Masalah: `<img src="/storage/school-profile/logosd.png">` 
   - Seharusnya: Menggunakan path dinamis dari `$schoolProfile->logo`

2. **Dua Sistem Upload Logo Berbeda**
   - **Sistem A** (AdminSettingsController): 
     - Upload ke: `storage/logos/sd-negeri-2-dermolo.*`
     - Tidak menggunakan database
     - Akses via: `resolveCurrentLogoPublicPath()`
   
   - **Sistem B** (AdminSchoolProfileController):
     - Upload ke: `storage/school-profile/*`
     - Menyimpan path ke database: `school_profiles.logo`
     - Akses via: `$schoolProfile->logo`

3. **Layout Membaca dari Sistem yang Salah**
   - Layout check: `@if($schoolProfile->logo)` ✅
   - Tapi render: `src="/storage/school-profile/logosd.png"` ❌ (hardcoded!)
   - Seharusnya: `src="{{ asset('storage/' . $schoolProfile->logo) }}"`

---

## 🎯 SOLUSI

### Opsi 1: **UNIFIKASI - Gunakan Satu Sistem Saja (RECOMMENDED)**

**Pilih:** Sistem SchoolProfile (database-based) karena lebih terstruktur.

#### Langkah:
1. ✅ Fix layout untuk menggunakan path dinamis
2. ✅ Hapus/hide AdminSettingsController logo upload
3. ✅ Redirect logo settings ke School Profile page
4. ✅ Cleanup old logo files di `storage/logos/`

### Opsi 2: **DUAL SYSTEM SUPPORT (Fallback)**

**Pertahankan:** Kedua sistem dengan fallback logic.

#### Langkah:
1. ✅ Fix layout untuk prioritaskan database
2. ✅ Fallback ke AdminSettings logo jika database kosong
3. ✅ Sinkronisasi kedua sistem saat upload

---

## 📝 IMPLEMENTASI (Opsi 1 - RECOMMENDED)

### Step 1: Fix Layout Logo Display
**File:** `resources/views/layouts/app.blade.php`

**Before:**
```php
@if($schoolProfile->logo)
    <img src="/storage/school-profile/logosd.png" class="...">
```

**After:**
```php
@if($schoolProfile->logo)
    <img src="{{ asset('storage/' . $schoolProfile->logo) }}" class="...">
```

### Step 2: Hapus Logo Upload di AdminSettingsController
**File:** `app/Http/Controllers/AdminSettingsController.php`

- Hapus method `uploadLogo()`
- Hapus method `resolveCurrentLogoStoragePath()`
- Hapus method `resolveCurrentLogoPublicPath()`
- Hapus method `resolveAllLogoStoragePaths()`
- Update `hiddenSettings()` untuk tidak menampilkan logo settings

### Step 3: Update Routes
**File:** `routes/web.php`

Hapus atau redirect:
```php
Route::get('settings/logo', ...) // Redirect ke school-profile
```

### Step 4: Update AdminSchoolProfileController
**File:** `app/Http/Controllers/AdminSchoolProfileController.php`

Tambahkan validasi dan resize image jika perlu.

### Step 5: Cleanup Old Files
```bash
rm -rf storage/app/public/logos/
```

### Step 6: Update UI Views
**File:** `resources/views/admin/settings_hidden.blade.php`
- Hapus section logo upload

**File:** `resources/views/admin/school-profile/edit.blade.php`
- Pastikan ada logo upload yang jelas dan fungsional

---

## ✅ TESTING CHECKLIST

- [ ] Upload logo baru via School Profile
- [ ] Logo tersimpan di storage/school-profile/
- [ ] Path tersimpan di database (school_profiles.logo)
- [ ] Logo muncul di navbar/header
- [ ] Logo muncul di footer
- [ ] Ganti logo lagi (replace) berhasil
- [ ] Hapus logo berhasil
- [ ] Clear cache & logo tetap muncul
- [ ] Hard reload browser (Ctrl+Shift+R)

---

## ⚠️ CATATAN PENTING

1. **Cache Browser**: Logo mungkin ter-cache oleh browser
   - Solution: Tambahkan cache busting dengan timestamp
   
2. **Storage Link**: Pastikan `public/storage` symlink sudah ada
   - Command: `php artisan storage:link`
   
3. **File Permissions**: Pastikan writable
   - Command: `chmod -R 775 storage/`

4. **Backup Old Logos**: Sebelum hapus file lama
   - Backup ke: `storage/app/public/logos-backup/`

---

## 🚀 ROLLBACK PLAN

Jika ada masalah:
1. Restore hardcoded path jika perlu
2. Kembalikan AdminSettingsController methods
3. Restore old logo files dari backup

---

**Status:** Ready untuk implementasi
**Estimasi:** 15-20 menit
**Risk:** Low (dengan rollback plan)
