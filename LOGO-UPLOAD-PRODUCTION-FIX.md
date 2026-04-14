# 🔧 PERBAIKAN LOGO UPLOAD DI PRODUCTION SERVER

## 🔍 DIAGNOSIS MASALAH

Logo upload berhasil di development (Windows/Laragon) tetapi **GAGAL** di production server (Linux).

### ❌ **Kemungkinan Penyebab:**

1. **Storage Symlink Tidak Ada**
   - Development: Otomatis created oleh Laravel/Laragon
   - Production: Harus manual `php artisan storage:link`

2. **Folder Tidak Ada di Production**
   - Development: Folder `storage/app/public/school-profile/` otomatis dibuat
   - Production: Folder mungkin tidak ada atau permission salah

3. **File Permissions Berbeda**
   - Windows: Permission lebih flexible
   - Linux: Memerlukan permission `775` atau `777` dan correct owner (www-data)

4. **Path Separator Berbeda**
   - Windows: `storage\app\public\school-profile\`
   - Linux: `storage/app/public/school-profile/`

---

## 📋 RENCANA PERBAIKAN KOMPREHENSIF

### **STEP 1: Fix Controller - Tambahkan Folder Creation**

**File:** `app/Http/Controllers/AdminSchoolProfileController.php`

**Masalah Saat Ini:**
```php
$validated['logo'] = $request->file('logo')->store('school-profile', 'public');
```

**Perbaikan:**
```php
// Pastikan folder ada
$directory = storage_path('app/public/school-profile');
if (!is_dir($directory)) {
    mkdir($directory, 0775, true);
}

// Upload logo baru
$validated['logo'] = $request->file('logo')->store('school-profile', 'public');

// Set permission yang benar untuk Linux
chmod($directory . '/' . basename($validated['logo']), 0664);
```

---

### **STEP 2: Fix Delete Logo - Tambahkan Error Handling**

**File:** `app/Http/Controllers/AdminSchoolProfileController.php`

**Masalah Saat Ini:**
```php
Storage::disk('public')->delete($profile->logo);
```

**Perbaikan:**
```php
if ($profile->logo) {
    $path = storage_path('app/public/' . $profile->logo);
    if (file_exists($path)) {
        unlink($path);
    }
}
```

---

### **STEP 3: Tambahkan Storage Link Command**

**File:** `deploy.sh` atau script deployment

**Command:**
```bash
php artisan storage:link
```

**Atau Manual:**
```bash
cd /path/to/your/project
ln -s storage/app/public public/storage
```

---

### **STEP 4: Fix File Permissions**

**Commands untuk Production Server:**
```bash
# Set folder permissions
chmod -R 775 storage/app/public/school-profile

# Set file permissions
chmod 664 storage/app/public/school-profile/*

# Set correct owner (www-data untuk Apache/Nginx)
chown -R www-data:www-data storage/app/public/school-profile
```

---

### **STEP 5: Tambahkan Validasi di Controller**

**File:** `app/Http/Controllers/AdminSchoolProfileController.php`

**Tambahkan logging dan error handling:**
```php
if ($request->hasFile('logo')) {
    $file = $request->file('logo');
    
    // Validasi file
    if (!$file->isValid()) {
        return redirect()->back()
            ->with('error', 'File upload gagal. Silakan coba lagi.');
    }
    
    // Hapus logo lama
    if ($profile->logo) {
        $oldPath = storage_path('app/public/' . $profile->logo);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }
    
    // Pastikan folder ada
    $directory = storage_path('app/public/school-profile');
    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }
    
    // Upload file baru
    $path = $file->store('school-profile', 'public');
    
    // Verifikasi file tersimpan
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        return redirect()->back()
            ->with('error', 'Gagal menyimpan file. Periksa permission folder storage.');
    }
    
    // Set permission yang benar
    chmod($fullPath, 0664);
    
    $validated['logo'] = $path;
}
```

---

## 🎯 IMPLEMENTASI DETAIL

### **1. Update Controller**

**File:** `app/Http/Controllers/AdminSchoolProfileController.php`

```php
public function update(Request $request)
{
    $profile = SchoolProfile::getOrCreate();

    $validated = $request->validate([
        // ... validation rules lainnya ...
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
    ]);

    // Handle logo upload dengan error handling
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        
        // Validasi file
        if (!$file->isValid()) {
            return redirect()->back()
                ->with('error', 'File upload gagal. Silakan coba lagi.');
        }
        
        // Hapus logo lama
        if ($profile->logo) {
            $oldPath = storage_path('app/public/' . $profile->logo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        
        // Pastikan folder ada
        $directory = storage_path('app/public/school-profile');
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }
        
        // Upload file baru
        $path = $file->store('school-profile', 'public');
        
        // Verifikasi file tersimpan
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan file. Periksa permission folder storage.');
        }
        
        // Set permission yang benar untuk Linux
        chmod($fullPath, 0664);
        
        $validated['logo'] = $path;
    }

    // ... code lainnya ...
}
```

---

### **2. Update Delete Logo**

**File:** `app/Http/Controllers/AdminSchoolProfileController.php`

```php
public function deleteLogo()
{
    $profile = SchoolProfile::getOrCreate();

    if ($profile->logo) {
        $path = storage_path('app/public/' . $profile->logo);
        
        if (file_exists($path)) {
            unlink($path);
        }
        
        $profile->update(['logo' => null]);
        
        return response()->json([
            'success' => true,
            'message' => 'Logo berhasil dihapus'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Logo tidak ditemukan'
    ]);
}
```

---

## 🚀 DEPLOYMENT CHECKLIST

### **Untuk Production Server:**

```bash
# 1. Pastikan storage symlink ada
php artisan storage:link

# 2. Buat folder jika belum ada
mkdir -p storage/app/public/school-profile

# 3. Set permissions
chmod -R 775 storage/app/public/school-profile
chown -R www-data:www-data storage/app/public/school-profile

# 4. Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 5. Restart web server (jika perlu)
sudo systemctl restart apache2
# atau
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
```

---

## ⚠️ TROUBLESHOOTING

### **Problem 1: "Permission Denied"**

**Solusi:**
```bash
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

### **Problem 2: "Folder Not Found"**

**Solusi:**
```bash
mkdir -p storage/app/public/school-profile
chmod 775 storage/app/public/school-profile
```

### **Problem 3: "Storage Link Not Found"**

**Solusi:**
```bash
# Hapus symlink lama (jika ada)
rm public/storage

# Buat symlink baru
php artisan storage:link

# Verifikasi
ls -la public/storage
# Harus menunjukkan: storage -> ../storage/app/public
```

### **Problem 4: "File Upload Gagal"**

**Solusi:**
1. Cek `php.ini` untuk upload_max_filesize:
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

2. Restart PHP-FPM/Apache setelah perubahan

---

## 📊 TESTING PLAN

### **Test di Development:**
- [ ] Upload logo baru
- [ ] Logo tampil di navbar
- [ ] Logo tampil di about page
- [ ] Logo tampil di footer
- [ ] Delete logo berhasil
- [ ] Upload logo baru lagi berhasil

### **Test di Production:**
- [ ] Upload logo baru
- [ ] Verifikasi file tersimpan di `storage/app/public/school-profile/`
- [ ] Verifikasi file accessible via URL `/storage/school-profile/xxx.jpg`
- [ ] Logo tampil di navbar
- [ ] Logo tampil di about page
- [ ] Logo tampil di footer
- [ ] Delete logo berhasil
- [ ] Upload logo baru lagi berhasil

---

## 🔧 FILE YANG PERLU DIUBAH

1. ✅ `app/Http/Controllers/AdminSchoolProfileController.php`
   - Tambahkan folder creation
   - Tambahkan error handling
   - Tambahkan file permission setting
   - Fix delete logo logic

2. ✅ `bootstrap/cache/` (production only)
   - Pastikan writable

3. ✅ `storage/app/public/` (production only)
   - Pastikan folder `school-profile` ada
   - Permission 775
   - Owner www-data:www-data

---

## 📝 DEPLOYMENT SCRIPT

**File:** `deploy.sh` (jika ada)

```bash
#!/bin/bash

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Create storage symlink
php artisan storage:link

# Create logo directory
mkdir -p storage/app/public/school-profile

# Set permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

# Restart services
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
```

---

## ✅ HASIL YANG DIHARAPKAN

Setelah perbaikan:
1. ✅ Logo upload berhasil di production
2. ✅ Logo tersimpan di folder yang benar
3. ✅ Logo tampil di semua halaman
4. ✅ Delete logo berfungsi
5. ✅ Error handling yang baik jika upload gagal
6. ✅ Permission otomatis benar

---

**Estimasi Waktu:** 15-20 menit
**Risk Level:** 🟢 LOW (dengan rollback plan)
**Testing Required:** ✅ Manual testing di development & production
