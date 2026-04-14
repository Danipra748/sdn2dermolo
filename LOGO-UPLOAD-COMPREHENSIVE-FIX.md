# 🔧 PERBAIKAN KOMPREHENSIF - LOGO UPLOAD TIDAK TERSIMPAN

## 🔍 DIAGNOSIS LENGKAP

Setelah analisis mendalam, ditemukan **BEberapa MASALAH KRITIS**:

### ❌ **MASALAH #1: Error Messages Tidak Ditampilkan**
**File:** `resources/views/admin/school-profile/edit.blade.php`
**Masalah:** View hanya menampilkan `session('success')` tetapi TIDAK menampilkan `session('error')`
**Dampak:** User tidak tahu jika upload gagal

### ❌ **MASALAH #2: Controller Tidak Ada Logging**
**File:** `app/Http/Controllers/AdminSchoolProfileController.php`
**Masalah:** Tidak ada logging untuk debugging
**Dampak:** Tidak bisa trace apa yang sebenarnya terjadi

### ❌ **MASALAH #3: Database Update Mungkin Gagal**
**File:** `app/Http/Controllers/AdminSchoolProfileController.php`
**Masalah:** `$profile->update($validated)` mungkin gagal tanpa error message
**Dampak:** Data tidak tersimpan ke database

### ❌ **MASALAH #4: Fillable Property**
**File:** `app/Models/SchoolProfile.php`
**Cek:** Pastikan `logo` ada di `$fillable` array

---

## 📋 RENCANA PERBAIKAN KOMPREHENSIF

### **STEP 1: Tampilkan Error Messages di View**

**File:** `resources/views/admin/school-profile/edit.blade.php`

**Tambahkan setelah success message:**
```blade
@if (session('error'))
    <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
        <div class="font-semibold">Error!</div>
        {{ session('error') }}
    </div>
@endif
```

---

### **STEP 2: Tambahkan Logging dan Better Error Handling di Controller**

**File:** `app/Http/Controllers/AdminSchoolProfileController.php`

**Update method `update()`:**
```php
public function update(Request $request)
{
    try {
        $profile = SchoolProfile::getOrCreate();
        
        \Log::info('=== LOGO UPLOAD DEBUG START ===');
        \Log::info('Profile ID: ' . $profile->id);
        \Log::info('Has file: ' . ($request->hasFile('logo') ? 'YES' : 'NO'));

        $validated = $request->validate([
            // ... validation rules ...
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            
            \Log::info('File details:');
            \Log::info('- Name: ' . $file->getClientOriginalName());
            \Log::info('- Size: ' . $file->getSize());
            \Log::info('- MIME: ' . $file->getMimeType());
            
            if (!$file->isValid()) {
                \Log::error('File is not valid');
                return redirect()->back()
                    ->with('error', 'File upload gagal. File tidak valid.');
            }
            
            // Delete old logo
            if ($profile->logo) {
                $oldPath = storage_path('app/public/' . $profile->logo);
                \Log::info('Old logo path: ' . $oldPath);
                \Log::info('Old logo exists: ' . (file_exists($oldPath) ? 'YES' : 'NO'));
                
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                    \Log::info('Old logo deleted');
                }
            }
            
            // Ensure directory exists
            $directory = storage_path('app/public/school-profile');
            \Log::info('Directory: ' . $directory);
            \Log::info('Directory exists: ' . (is_dir($directory) ? 'YES' : 'NO'));
            
            if (!is_dir($directory)) {
                mkdir($directory, 0775, true);
                \Log::info('Directory created');
            }
            
            // Upload new logo
            $path = $file->store('school-profile', 'public');
            \Log::info('New logo path: ' . $path);
            
            // Verify file was saved
            $fullPath = storage_path('app/public/' . $path);
            \Log::info('Full path: ' . $fullPath);
            \Log::info('File exists after upload: ' . (file_exists($fullPath) ? 'YES' : 'NO'));
            
            if (!file_exists($fullPath)) {
                \Log::error('File does not exist after upload!');
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan file. Periksa permission folder storage.');
            }
            
            // Set permissions
            chmod($fullPath, 0664);
            \Log::info('Permissions set to 0664');
            
            $validated['logo'] = $path;
        }

        // Handle missions
        if ($request->has('mission_items')) {
            $missions = array_filter($request->input('mission_items'), function($item) {
                return !empty(trim($item));
            });
            $validated['missions'] = array_values($missions);
        }

        // Update profile
        \Log::info('Updating profile with data:');
        \Log::info(json_encode($validated));
        
        $updated = $profile->update($validated);
        
        \Log::info('Update result: ' . ($updated ? 'SUCCESS' : 'FAILED'));
        \Log::info('=== LOGO UPLOAD DEBUG END ===');

        if (!$updated) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan ke database. Pastikan kolom logo ada di tabel.');
        }

        return redirect()->route('admin.school-profile.edit')
            ->with('success', 'Profil sekolah berhasil diperbarui!');
            
    } catch (\Exception $e) {
        \Log::error('EXCEPTION: ' . $e->getMessage());
        \Log::error('Trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
            ->with('error', 'Terjadi error: ' . $e->getMessage());
    }
}
```

---

### **STEP 3: Verifikasi Model Fillable**

**File:** `app/Models/SchoolProfile.php`

**Pastikan `logo` ada di `$fillable`:**
```php
protected $fillable = [
    'school_name',
    'npsn',
    'school_status',
    'accreditation',
    'address',
    'village',
    'district',
    'city',
    'province',
    'postal_code',
    'phone',
    'email',
    'website',
    'history_content',
    'established_year',
    'land_area',
    'building_area',
    'total_classes',
    'total_students',
    'total_teachers',
    'total_staff',
    'vision',
    'missions',
    'logo',  // ✅ PASTIKAN INI ADA
    'hero_image',
];
```

---

### **STEP 4: Tambahkan Debug Info di View**

**File:** `resources/views/admin/school-profile/edit.blade.php`

**Tambahkan debug info (temporary):**
```blade
{{-- Debug Info - Hapus setelah fix --}}
<div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
    <h4 class="font-bold">Debug Info:</h4>
    <p>Current logo: <code>{{ $profile->logo ?? 'NULL' }}</code></p>
    <p>Profile ID: <code>{{ $profile->id }}</code></p>
    <p>Fillable: <code>{{ implode(', ', $profile->getFillable()) }}</code></p>
</div>
```

---

### **STEP 5: Verify Database Table**

**Run di server:**
```sql
-- Cek kolom logo ada
DESCRIBE school_profiles;

-- Cek data saat ini
SELECT id, school_name, logo FROM school_profiles LIMIT 1;
```

**Jika kolom `logo` tidak ada, tambahkan:**
```sql
ALTER TABLE school_profiles ADD COLUMN logo VARCHAR(255) NULL AFTER missions;
```

---

## 🚀 IMPLEMENTASI STEP-BY-STEP

### **Step 1: Update View - Add Error Messages**

Edit `resources/views/admin/school-profile/edit.blade.php`:
- Tampilkan `session('error')`
- Tambahkan debug info (temporary)

### **Step 2: Update Controller - Add Logging**

Edit `app/Http/Controllers/AdminSchoolProfileController.php`:
- Tambahkan logging di setiap step
- Tambahkan try-catch untuk error handling
- Tambahkan error messages yang jelas

### **Step 3: Verify Model**

Cek `app/Models/SchoolProfile.php`:
- Pastikan `logo` ada di `$fillable`

### **Step 4: Verify Database**

Cek database:
- Pastikan kolom `logo` ada di tabel `school_profiles`

### **Step 5: Test & Debug**

1. Upload logo
2. Cek `storage/logs/laravel.log`
3. Lihat log messages untuk trace masalah
4. Fix berdasarkan error yang muncul

---

## 📊 TROUBLESHOOTING GUIDE

### **Problem 1: "File upload gagal"**

**Cek log:**
```bash
tail -f storage/logs/laravel.log
```

**Kemungkinan:**
- File terlalu besar (> 2MB)
- File bukan image
- Permission folder storage salah

**Solusi:**
```bash
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

---

### **Problem 2: "Gagal menyimpan ke database"**

**Cek log untuk melihat query yang dijalankan**

**Kemungkinan:**
- Kolom `logo` tidak ada di database
- `$fillable` tidak include `logo`
- Database connection error

**Solusi:**
```sql
-- Tambah kolom jika tidak ada
ALTER TABLE school_profiles ADD COLUMN logo VARCHAR(255) NULL;
```

---

### **Problem 3: Logo tersimpan tapi tidak tampil**

**Kemungkinan:**
- Path salah di database
- Storage symlink tidak ada
- File permission salah

**Solusi:**
```bash
# Cek symlink
ls -la public/storage

# Buat symlink jika tidak ada
php artisan storage:link

# Cek file
ls -la storage/app/public/school-profile/
```

---

## ✅ TESTING CHECKLIST

- [ ] View menampilkan error message jika upload gagal
- [ ] Controller logging semua step upload
- [ ] Model memiliki `logo` di `$fillable`
- [ ] Database memiliki kolom `logo`
- [ ] Upload logo berhasil
- [ ] Logo tersimpan di database (cek log)
- [ ] Logo file ada di `storage/app/public/school-profile/`
- [ ] Logo tampil di website
- [ ] Delete logo berhasil
- [ ] Upload logo baru lagi berhasil

---

## 📝 DEPLOYMENT STEPS

1. **Update code:**
```bash
git pull origin main
```

2. **Clear cache:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

3. **Cek database:**
```sql
DESCRIBE school_profiles;
-- Pastikan kolom 'logo' ada
```

4. **Cek storage:**
```bash
php artisan storage:link
chmod -R 775 storage/
```

5. **Test upload logo**

6. **Cek log jika gagal:**
```bash
tail -f storage/logs/laravel.log
```

---

**Setelah fix ini, kita akan tahu EXACTLY apa yang salah dari log messages!** 🔍
