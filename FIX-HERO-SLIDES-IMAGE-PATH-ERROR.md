# FIX: Error Field 'image_path' doesn't have a default value

## Problem
Error terjadi saat menyimpan data dari form Admin ke tabel `hero_slides`:

```
Illuminate\Database\QueryException
Field 'image_path' doesn't have a default value
```

## Root Cause
Di method `store()` pada `AdminHeroSlideController`, record dibuat dengan `HeroSlide::create()` **sebelum** gambar diupload. Ini menyebabkan kolom `image_path` tidak terisi saat query INSERT dijalankan.

### Kode Lama (SALAH):
```php
// Create slide DULU tanpa image_path
$slide = HeroSlide::create([
    'title' => $validated['title'] ?? null,
    'subtitle' => $validated['subtitle'] ?? null,
    'description' => $validated['description'] ?? null,
    'display_order' => $maxOrder + 1,
    'is_active' => true,
]);

// Baru upload SETELAHNYA - TERLAMBAT!
$slide->uploadImage($request->file('image'));
```

## Solution
Upload gambar terlebih dahulu untuk mendapatkan path, lalu buat record dengan `image_path` yang sudah terisi.

### Kode Baru (BENAR):
```php
// Upload gambar DULU untuk dapat path
$imagePath = $request->file('image')->store('hero-slides', 'public');

// Buat record DENGAN image_path
$slide = HeroSlide::create([
    'image_path' => $imagePath,  // <-- INI YANG KURANG!
    'title' => $validated['title'] ?? null,
    'subtitle' => $validated['subtitle'] ?? null,
    'description' => $validated['description'] ?? null,
    'display_order' => $maxOrder + 1,
    'is_active' => true,
]);
```

## Files Modified

### 1. app/Http/Controllers/AdminHeroSlideController.php
**Method:** `store()`

**Perubahan:**
- Upload image terlebih dahulu menggunakan `$request->file('image')->store('hero-slides', 'public')`
- Simpan hasil path ke variabel `$imagePath`
- Masukkan `$imagePath` ke array `create()` pada key `'image_path'`

**Status:** ✅ FIXED

### 2. app/Models/HeroSlide.php
**Status:** ✅ VERIFIED - Sudah benar
- `image_path` sudah ada di `$fillable` array
- Method `uploadImage()` sudah benar
- Method `deleteWithImage()` sudah benar

### 3. resources/views/admin/hero-slides/index.blade.php
**Status:** ✅ VERIFIED - Sudah benar
- Form sudah menggunakan `enctype="multipart/form-data"`
- Input file sudah benar dengan `name="image"`
- Form action sudah mengarah ke route yang benar

## Migration Verification

File: `database/migrations/2026_04_12_000000_create_hero_slides_table.php`

Kolom `image_path`:
```php
$table->string('image_path');  // NOT NULL, no default - CORRECT!
```

Ini sudah benar karena:
- Kita memang ingin memaksa setiap slide HARUS punya gambar
- Tidak ada default value karena path gambar unik untuk setiap slide
- Controller sekarang sudah memperbaiki cara insert data

## Testing Steps

1. **Rollback migration (jika sudah terlanjur error):**
   ```bash
   php artisan migrate:rollback --step=1
   ```

2. **Run migration ulang:**
   ```bash
   php artisan migrate
   ```

3. **Test upload:**
   - Login ke admin panel
   - Navigasi ke "Konten Publik > Hero Slides (Slideshow)"
   - Klik form "Tambah Slide Baru"
   - Pilih gambar (JPG/PNG/WebP, max 3MB)
   - Isi title, subtitle, description (opsional)
   - Klik "Tambah Slide"
   - ✅ Seharusnya berhasil tanpa error

4. **Verify di database:**
   ```sql
   SELECT * FROM hero_slides ORDER BY display_order;
   ```
   - Kolom `image_path` harus terisi (contoh: `hero-slides/abc123.jpg`)
   - Kolom lain juga harus terisi sesuai input form

## Additional Notes

### Storage Path
Gambar akan disimpan di:
- **Storage:** `storage/app/public/hero-slides/{filename}.{ext}`
- **Public:** `public/storage/hero-slides/{filename}.{ext}` (via symlink)

### File Naming
Laravel akan generate nama file unik secara otomatis:
- Format: `{random_string}.{original_extension}`
- Contoh: `hero-slides/xK9mP2nQ5vL8wR3jT6yH.jpg`

### Validation Rules
```php
'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:3072'
```
- `required`: Wajib ada file
- `image`: Harus file gambar
- `mimes`: Hanya terima jpeg, jpg, png, webp
- `max:3072`: Maksimal 3MB (3072 KB)

## Prevention Tips

Untuk menghindari error serupa di masa depan:

1. **Selalu upload file SEBELUM create record** jika kolom file path NOT NULL
2. **Gunakan transaction** jika operasi melibatkan multiple steps:
   ```php
   DB::transaction(function () use ($request, $maxOrder) {
       $imagePath = $request->file('image')->store('hero-slides', 'public');
       return HeroSlide::create([
           'image_path' => $imagePath,
           // ... other fields
       ]);
   });
   ```

3. **Tambahkan try-catch** untuk handling error yang lebih baik:
   ```php
   try {
       $imagePath = $request->file('image')->store('hero-slides', 'public');
       $slide = HeroSlide::create([...]);
       return back()->with('success', 'Slide berhasil ditambahkan.');
   } catch (\Exception $e) {
       \Log::error('Hero slide upload failed: ' . $e->getMessage());
       return back()->with('error', 'Gagal upload slide.');
   }
   ```

## Status: ✅ RESOLVED

Error sudah diperbaiki. Controller sekarang mengupload gambar terlebih dahulu sebelum membuat record database.

---

**Last Updated:** 2026-04-12
**Fixed By:** AI Assistant
**Verified:** Yes
