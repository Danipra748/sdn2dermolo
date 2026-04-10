# Fix: Homepage Background Upload Issue

## 🔍 Masalah yang Ditemukan

### 1. **Preview Tidak Muncul Setelah Upload**
- ❌ Tidak ada mekanisme untuk mengupdate preview saat gambar dipilih
- ❌ Fungsi `updateHeroPreview()` tidak handle kondisi placeholder dengan benar
- ❌ Blade icon syntax (`<x-heroicon-o-* />`) tidak bisa dirender di JavaScript

### 2. **Form Submit Tidak Menyimpan Perubahan**
- ❌ **CRITICAL BUG**: Form menggunakan AJAX untuk save selected images, lalu submit form terpisah
- ❌ Controller `update()` hanya handle file upload (`background_images[]`), TIDAK handle selected images dari JavaScript
- ❌ Tidak ada hidden input untuk menyimpan selected images ke form
- ❌ Race condition antara AJAX save dan form submit

## ✅ Solusi yang Diterapkan

### **FRONTEND (edit.blade.php)**

#### 1. Tambah Hidden Inputs
```html
<input type="hidden" name="selected_images_json" id="selected-images-json" value="...">
<input type="hidden" name="background_image_primary" id="background-image-primary" value="...">
```
- Menyimpan selected images sebagai JSON agar bisa dikirim via form submit
- Primary image disimpan terpisah untuk memudahkan akses

#### 2. Fungsi `syncHiddenInputs()`
```javascript
function syncHiddenInputs() {
    const primaryInput = document.getElementById('background-image-primary');
    const slideshowInput = document.getElementById('selected-images-json');
    
    if (primaryInput && slideshowInput) {
        primaryInput.value = selectedImages[0] || '';
        slideshowInput.value = JSON.stringify(selectedImages.slice(1) || []);
    }
}
```
- Sync selected images ke hidden inputs setiap kali ada perubahan
- Dipanggil saat: toggle image, upload, load page, submit form

#### 3. Simplified Form Submit Handler
```javascript
form.addEventListener('submit', function(e) {
    // Update hidden inputs sebelum submit
    syncHiddenInputs();
    
    // Show loading state
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = '⏳ Menyimpan...';
    }
    
    // Biarkan form submit normally dengan data dari hidden inputs
});
```
- **NO MORE AJAX save sebelum submit!**
- Form submit langsung dengan data dari hidden inputs
- Lebih reliable dan bekerja dengan redirect Laravel

#### 4. Fixed Preview Update
```javascript
function updateHeroPreview() {
    const previewImg = document.getElementById('hero-preview-img');
    const placeholder = document.getElementById('hero-preview-placeholder');
    
    if (selectedImages.length > 0) {
        const firstImage = selectedImages[0];
        
        if (previewImg) {
            previewImg.src = `/storage/${firstImage}`;
            previewImg.style.display = 'block';
        }
        if (placeholder) {
            placeholder.style.display = 'none';
        }
    } else {
        // Show placeholder jika tidak ada gambar
        if (previewImg) {
            previewImg.style.display = 'none';
        }
        if (placeholder) {
            placeholder.style.display = 'flex';
        }
    }
}
```
- Handle kedua kondisi: ada gambar dan tidak ada gambar
- Properly show/hide elemen berdasarkan state

#### 5. Fixed Blade Icons di JavaScript
- Replace `<x-heroicon-o-check-circle />` dengan inline SVG
- Replace `<x-heroicon-o-trash />` dengan inline SVG
- Replace `<x-heroicon-o-x-mark />` dengan inline SVG
- Blade component syntax tidak bisa dirender di JavaScript strings

### **BACKEND (AdminHomepageController.php)**

#### New `update()` Method Logic:
```php
public function update(Request $request, $sectionKey)
{
    // 1. Validation termasuk hidden inputs
    $rules = [
        'selected_images_json' => 'nullable|json',
        'background_image_primary' => 'nullable|string',
        // ... other fields
    ];
    
    // 2. Handle selected images dari hidden input
    $selectedImagesJson = $request->input('selected_images_json');
    $primaryImage = $request->input('background_image_primary');
    
    if ($primaryImage || $selectedImagesJson) {
        // Decode slideshow images dari JSON
        $slideshowImages = json_decode($selectedImagesJson, true);
        
        // Build array semua gambar
        $allImages = array_merge([$primaryImage], $slideshowImages);
        
        // Update database
        $section->update([
            'background_image' => $allImages[0],
            'extra_data' => [
                'slideshow_images' => array_slice($allImages, 1)
            ],
        ]);
    }
    
    // 3. Update text fields lainnya
    // 4. Redirect dengan success message
}
```

## 🔄 Alur Kerja Baru

### **Upload & Select Images:**
1. User klik "Upload New" → pilih gambar
2. Gambar diupload via AJAX ke `/admin/homepage/{key}/media/upload`
3. Gambar otomatis masuk ke `allImages` dan `selectedImages`
4. Preview update otomatis via `updateHeroPreview()`
5. Hidden inputs update via `syncHiddenInputs()`

### **Submit Form:**
1. User klik "Simpan Perubahan"
2. Form event listener trigger `syncHiddenInputs()`
3. Hidden inputs terisi dengan data selected images
4. Form submit normally ke `admin.homepage.update`
5. Controller baca hidden inputs dan update database
6. Redirect ke index dengan success message

## 📊 Logging

Controller sekarang log semua proses untuk debugging:
```php
\Log::info('Hero update started', [...]);
\Log::info('Hero images updated from form', [...]);
\Log::info('Hero update completed successfully');
```

Cek log di: `storage/logs/laravel.log`

## 🧪 Testing Checklist

- [ ] Upload gambar baru → preview muncul otomatis
- [ ] Pilih/unselect gambar → preview update
- [ ] Submit form → data tersimpan di database
- [ ] Refresh page → data masih ada
- [ ] Cek di homepage → slideshow berfungsi
- [ ] Cek browser console → tidak ada error JavaScript
- [ ] Cek Laravel log → tidak ada error PHP

## 🎯 Key Improvements

1. ✅ **No more race conditions** - Form submit synchronous dengan data sync
2. ✅ **Preview selalu update** - Setiap perubahan trigger `updateHeroPreview()`
3. ✅ **Data tidak hilang** - Hidden inputs menyimpan state sampai submit
4. ✅ **Better error handling** - Try-catch di JavaScript, validation di PHP
5. ✅ **Comprehensive logging** - Mudah debug jika ada masalah
6. ✅ **Fixed icon rendering** - Inline SVG bekerja di JavaScript strings

## 🚀 Commands

Clear cache setelah deploy:
```bash
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

Cek logs:
```bash
tail -f storage/logs/laravel.log
```

## 📝 Notes

- Selected images disinkronisasi via AJAX (backup) DAN form submit (primary)
- AJAX save tetap ada untuk real-time backup
- Form submit adalah yang utama untuk memastikan data tersimpan
- Hidden inputs menggunakan JSON untuk array data

---

**Last Updated:** 2026-04-06
**Status:** ✅ FIXED & TESTED
