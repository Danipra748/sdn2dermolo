# Ringkasan Perbaikan Upload/Delete Pattern

## ✅ Yang Sudah Diperbaiki

### 1. **Base Controller** (`app/Http/Controllers/Controller.php`)
Menambahkan reusable methods yang bisa dipakai di semua controller:
- `uploadFile()` - Upload file ke storage
- `replaceFile()` - Hapus lama + upload baru
- `deletePhysicalFile()` - Hapus file fisik
- `handleFileUpload()` - Helper untuk controller (hapus lama + upload baru)
- `handleFileDeletion()` - Helper untuk controller (set kolom ke null, JANGAN hapus row)

### 2. **UploadableTrait** (`app/Traits/UploadableTrait.php`)
Trait untuk model dengan methods:
- `uploadToColumn()` - Upload ke kolom tertentu
- `deleteFromColumn()` - Delete dari kolom tertentu (set ke null)
- `hasFileInColumn()` - Cek apakah ada file
- `getFileFromColumn()` - Ambil path file

### 3. **Model yang Diperbaiki**

#### SiteSetting Model
```php
protected $uploadableColumns = ['hero_image', 'foto_kepsek'];
```
- Sudah menggunakan `updateOrCreate` pattern
- Delete = set ke null, bukan hapus row

#### Program Model  
```php
use UploadableTrait;
protected $uploadableColumns = ['foto', 'card_bg_image', 'logo'];
```
- Sekarang bisa pakai: `Program::uploadToColumn($id, 'foto', $file, 'program')`
- Dan: `Program::deleteFromColumn($id, 'foto')`

### 4. **Controllers yang Diperbaiki**

#### AdminProgramController
- ✅ `update()` menggunakan `handleFileUpload()` untuk foto, card_bg_image, logo
- ✅ `updateCardBackground()` menggunakan helper methods
- ✅ **BARU:** `deleteFoto()` - Delete foto (set ke null)
- ✅ **BARU:** `deleteCardBg()` - Delete card background (set ke null)
- ✅ **BARU:** `deleteLogo()` - Delete logo (set ke null)

#### AdminSambutanController
- ✅ `update()` menggunakan `deletePhysicalFile()` dari base controller
- ✅ Delete foto = set ke null (bukan hapus row)

#### AdminSchoolProfileController
- ✅ `update()` menggunakan `deletePhysicalFile()` dari base controller
- ✅ `deleteLogo()` menggunakan `deletePhysicalFile()` (lebih clean)

### 5. **Routes Baru** (`routes/web.php`)
```php
Route::delete('program-sekolah/{id}/foto', [..., 'deleteFoto'])
    ->name('program-sekolah.foto.delete');
Route::delete('program-sekolah/{id}/card-bg', [..., 'deleteCardBg'])
    ->name('program-sekolah.card-bg.delete');
Route::delete('program-sekolah/{id}/logo', [..., 'deleteLogo'])
    ->name('program-sekolah.logo.delete');
```

### 6. **Views yang Diperbaiki**

#### Program Info Form (`resources/views/admin/program/info.blade.php`)
- ✅ Input file SELALU ada (tidak conditional)
- ✅ Preview foto conditional (`@if($program->foto)`)
- ✅ Tombol delete dengan form POST terpisah
- ✅ Pesan helper: "Upload untuk mengganti. Kosongkan jika tidak ingin mengubah."
- ✅ Placeholder jika belum ada file

#### Settings Hidden (`resources/views/admin/settings_hidden.blade.php`)
- ✅ Sudah benar: Upload form selalu ada
- ✅ Preview conditional
- ✅ Delete button terpisah

---

## 🎯 Pattern yang Diterapkan

### Controller Pattern
```php
// UPLOAD
$data = array_merge($data, $this->handleFileUpload(
    $model, 
    'kolom_file',      // Kolom di database
    $request,          // Request object
    'nama_field',      // Field name di form
    'storage/path'     // Path storage
));
$model->update($data);

// DELETE
$deleteData = $this->handleFileDeletion($model, 'kolom_file');
$model->update($deleteData);
```

### Blade Pattern
```blade
<!-- Input file SELALU ada -->
<input type="file" name="foto">
<p>Upload untuk mengganti. Kosongkan jika tidak ingin mengubah.</p>

<!-- Preview conditional -->
@if($model->foto)
    <img src="{{ asset('storage/' . $model->foto) }}">
    <form action="{{ route('model.foto.delete', $model) }}" method="POST">
        @csrf @method('DELETE')
        <button>Hapus Foto</button>
    </form>
@else
    <p>Belum ada foto. Upload file di atas.</p>
@endif
```

### Model Pattern (dengan Trait)
```php
use UploadableTrait;
protected $uploadableColumns = ['foto', 'thumbnail'];

// Upload
Model::uploadToColumn($id, 'foto', $file, 'path');

// Delete (set ke null)
Model::deleteFromColumn($id, 'foto');
```

---

## 📋 Fitur yang Bisa Diperbaiki dengan Pattern Sama

Berikut fitur lain yang bisa menggunakan pattern yang sama:

1. ⏳ **Gallery** (`AdminGalleryController`) - Foto gallery
2. ⏳ **Artikel** (`AdminArticleController`) - Featured image
3. ⏳ **Hero Slides** (`AdminHeroSlideController`) - Hero slide images
4. ⏳ **Guru** (`GuruController`) - Photo guru
5. ⏳ **Fasilitas** (`FasilitasController`) - Foto fasilitas
6. ⏳ **Prestasi** (`AdminPrestasiController`) - Foto prestasi
7. ⏳ **Program Photos** (`AdminProgramPhotoController`) - Program photos

**Cara menambahkan:**
1. Tambahkan `use UploadableTrait` di model
2. Definisikan `$uploadableColumns`
3. Gunakan `handleFileUpload()` dan `handleFileDeletion()` di controller
4. Buat route delete terpisah
5. Update blade dengan static input + conditional preview

---

## 🎁 File yang Dibuat

1. ✅ `app/Traits/UploadableTrait.php` - Trait untuk model
2. ✅ `app/Http/Controllers/Controller.php` - Updated dengan helper methods
3. ✅ `GLOBAL-UPLOAD-PATTERN.md` - Dokumentasi lengkap
4. ✅ `RINGKASAN-PERBAIKAN.md` - File ini (ringkasan)

---

## 🚀 Testing

Untuk memastikan semuanya bekerja:

### Test 1: Upload Pertama Kali
```
1. Buka halaman edit program
2. Upload foto
3. ✅ Foto muncul
4. ✅ Database terupdate dengan path
```

### Test 2: Replace Foto
```
1. Upload foto baru
2. Submit form
3. ✅ Foto lama hilang
4. ✅ Foto baru muncul
5. ✅ File lama terhapus dari storage
```

### Test 3: Delete Foto
```
1. Klik "Hapus Foto"
2. Confirm
3. ✅ Foto hilang dari tampilan
4. ✅ Input file MASIH ADA
5. ✅ Database: kolom_foto = null
6. ✅ Row masih ada di database
7. ✅ Bisa upload foto baru
```

### Test 4: Upload Setelah Delete
```
1. Setelah delete, upload foto baru
2. Submit
3. ✅ Foto muncul lagi
4. ✅ Tidak ada error
5. ✅ Database terupdate
```

---

## 💡 Keuntungan

### Sebelum Perbaikan
- ❌ Row database terhapus setelah delete
- ❌ Input file hilang setelah delete
- ❌ Sulit upload lagi setelah delete
- ❌ Pattern tidak konsisten
- ❌ Code duplicate di mana-mana

### Setelah Perbaikan
- ✅ Row database TETAP ADA (hanya kolom yang null)
- ✅ Input file SELALU ADA
- ✅ Mudah upload lagi setelah delete
- ✅ Pattern KONSISTEN di semua fitur
- ✅ Code REUSABLE dan DRY

---

## 📚 Dokumentasi

Baca dokumentasi lengkap di:
- **`GLOBAL-UPLOAD-PATTERN.md`** - Panduan lengkap dengan contoh code

---

## ✨ Kesimpulan

Pattern upload/delete yang dinamis sudah diterapkan secara global untuk:
1. ✅ Program Sekolah (foto, card_bg, logo)
2. ✅ Foto Kepala Sekolah
3. ✅ Sambutan Kepala Sekolah
4. ✅ School Profile (logo)

**Pattern ini BISA dan MUDAH diterapkan ke fitur lain!**

Cukup ikuti langkah di `GLOBAL-UPLOAD-PATTERN.md` untuk menambahkan ke fitur baru.
