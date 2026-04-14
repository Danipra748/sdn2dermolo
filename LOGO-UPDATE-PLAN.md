# 📋 PERBAIKAN LOGO YANG BELUM BERUBAH

## 🔍 DIAGNOSIS MASALAH

Logo sudah berhasil berubah di favicon (menjadi Tut Wuri Handayani), tetapi masih menggunakan logo lama (`/storage/school-profile/logosd.png`) di beberapa tempat:

### ❌ Lokasi yang Masih Salah:

1. **Navbar (Header Website)**
   - File: `resources/views/layouts/app.blade.php` (Line 259)
   - Kode Saat Ini: `<img src="/storage/school-profile/logosd.png">`
   - Status: ❌ Hardcoded path ke logo lama

2. **Halaman Identitas Sekolah (About Page)**
   - File: `resources/views/spa/partials/about.blade.php` (Line 44)
   - Kode Saat Ini: `<img src="/storage/school-profile/logosd.png">`
   - Status: ❌ Hardcoded path ke logo lama

3. **Footer Website**
   - File: `resources/views/layouts/app.blade.php` (Line 353)
   - Kode Saat Ini: Sudah benar menggunakan `{{ asset('storage/' . $schoolProfile->logo) }}`
   - Status: ✅ Sudah dinamis (tapi mungkin `$schoolProfile->logo` belum terupdate di database)

---

## 🎯 RENCANA PERBAIKAN

### Step 1: Update Navbar Logo
**File:** `resources/views/layouts/app.blade.php`
**Line:** 259

**Sebelum:**
```php
<img src="/storage/school-profile/logosd.png" alt="SD N 2 Dermolo" class="w-full h-full object-contain p-1">
```

**Sesudah:**
```php
@if($schoolProfile->logo)
    <img src="{{ asset('storage/' . $schoolProfile->logo) }}" alt="{{ $schoolProfile->school_name ?? 'SD N 2 Dermolo' }}" class="w-full h-full object-contain p-1">
@else
    <div class="w-full h-full bg-gradient-to-br from-blue-600 to-blue-500 flex items-center justify-center text-white font-bold text-lg">
        SD
    </div>
@endif
```

---

### Step 2: Update About Page Logo
**File:** `resources/views/spa/partials/about.blade.php`
**Line:** 44

**Sebelum:**
```php
<img src="/storage/school-profile/logosd.png" alt="{{ $profile->school_name }}" class="w-full h-full object-cover">
```

**Sesudah:**
```php
@if($profile->logo)
    <img src="{{ asset('storage/' . $profile->logo) }}" alt="{{ $profile->school_name }}" class="w-full h-full object-cover">
@else
    <div class="w-full h-full flex items-center justify-center">
        <div class="text-6xl font-black text-blue-600">SD</div>
    </div>
@endif
```

---

### Step 3: Verifikasi Footer
**File:** `resources/views/layouts/app.blade.php`
**Line:** 352-353

**Status:** Sudah benar, tapi perlu dipastikan `$schoolProfile` tersedia di context footer.

**Kode Saat Ini (Sudah Benar):**
```php
@if($schoolProfile->logo)
    <img src="{{ asset('storage/' . $schoolProfile->logo) }}" class="w-full h-full object-contain p-1" alt="Logo Sekolah">
```

**Action:** Tidak perlu perubahan, hanya verifikasi bahwa variabel `$schoolProfile` tersedia.

---

### Step 4: Verifikasi Database
**Tabel:** `school_profiles`
**Kolom:** `logo`

**Action:**
Pastikan path logo yang baru sudah tersimpan di database dengan benar.

**Query Verifikasi:**
```sql
SELECT id, school_name, logo FROM school_profiles WHERE id = 1;
```

**Expected Result:**
```
logo = "school-profile/logo.jpeg" (atau nama file logo baru)
```

**Jika Masih Salah:**
Update manual via database atau upload ulang logo melalui admin panel.

---

### Step 5: Clear Cache
Setelah semua perubahan, clear cache Laravel:

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

---

## 📊 CHECKLIST IMPLEMENTASI

- [ ] **Step 1:** Update navbar logo di `layouts/app.blade.php`
- [ ] **Step 2:** Update about page logo di `spa/partials/about.blade.php`
- [ ] **Step 3:** Verifikasi footer sudah menggunakan path dinamis
- [ ] **Step 4:** Verifikasi database `school_profiles.logo` terupdate dengan benar
- [ ] **Step 5:** Clear cache Laravel
- [ ] **Step 6:** Test di browser (hard reload: Ctrl+Shift+R)
- [ ] **Step 7:** Verifikasi logo berubah di semua lokasi (navbar, about, footer)

---

## ⚠️ CATATAN PENTING

1. **Fallback Logo:** Jika `$schoolProfile->logo` kosong, tampilkan fallback "SD" box
2. **Browser Cache:** Logo mungkin ter-cache, perlu hard reload
3. **Consistency:** Semua lokasi harus menggunakan pattern yang sama: `{{ asset('storage/' . $logo_path) }}`

---

## 🎨 STRUKTUR PATH LOGO

**Format Path yang Benar:**
```
Database: school-profile/logo.jpeg
URL: {{ asset('storage/school-profile/logo.jpeg') }}
File: public/storage/school-profile/logo.jpeg
Symlink: public/storage -> storage/app/public
```

---

## ✅ HASIL YANG DIHARAPKAN

Setelah perbaikan:
1. ✅ Logo di navbar = Logo baru (Tut Wuri Handayani)
2. ✅ Logo di halaman identitas sekolah = Logo baru
3. ✅ Logo di footer = Logo baru
4. ✅ Logo di favicon = Logo baru (sudah berhasil)
5. ✅ Semua logo konsisten menggunakan file yang sama

---

**Estimasi Waktu:** 10-15 menit
**Risk Level:** 🟢 LOW (perubahan minor pada view files)
**Testing Required:** ✅ Manual testing di browser
