# Panduan Lengkap: Upload & Delete File yang Dinamis

## Masalah yang Diperbaiki

Setelah menghapus foto/file, kesulitan menambahkannya kembali karena:
1. ❌ Row data terhapus dari database
2. ❌ Input file hilang dari tampilan
3. ❌ Logika upload dan delete tidak konsisten di setiap fitur

## Solusi Global yang Diterapkan

### ✅ Prinsip Utama

1. **JANGAN hapus row dari database** - Row tetap ada, hanya kolom file yang berubah jadi `null`
2. **Gunakan `updateOrCreate` atau `update`** - Untuk memastikan row tetap ada
3. **Input file SELALU muncul** - Tidak peduli ada file atau tidak
4. **Tombol delete terpisah** - Dengan form POST sendiri
5. **Konsisten di semua fitur** - Pattern yang sama untuk semua upload/delete

---

## Arsitektur Baru

### 1. Base Controller Methods

**File:** `app/Http/Controllers/Controller.php`

Semua controller sekarang mewarisi methods dari base controller:

```php
// Upload file baru
protected function uploadFile(Request $request, string $fieldName, string $storagePath, string $disk = 'public'): ?string

// Hapus file lama + upload file baru
protected function replaceFile(?string $oldFilePath, Request $request, string $fieldName, string $storagePath, string $disk = 'public'): ?string

// Hapus file fisik dari storage
protected function deletePhysicalFile(string $filePath, string $disk = 'public'): bool

// Handle upload di controller (hapus lama + upload baru)
protected function handleFileUpload($model, string $column, Request $request, string $fieldName, string $storagePath, string $disk = 'public'): array

// Handle delete di controller (set kolom ke null, JANGAN hapus row)
protected function handleFileDeletion($model, string $column, string $disk = 'public'): array
```

### 2. UploadableTrait (untuk Model)

**File:** `app/Traits/UploadableTrait.php`

Trait ini bisa digunakan di model untuk upload/delete yang dinamis:

```php
use App\Traits\UploadableTrait;

class Program extends Model
{
    use HasFactory, UploadableTrait;
    
    // Definisikan kolom mana yang bisa upload file
    protected $uploadableColumns = ['foto', 'card_bg_image', 'logo'];
}

// Usage:
Program::uploadToColumn($id, 'foto', $file, 'program');
Program::deleteFromColumn($id, 'foto');
Program::hasFileInColumn($id, 'foto');
Program::getFileFromColumn($id, 'foto');
```

---

## Pattern Implementation

### Controller Pattern

#### ✅ UPDATE dengan Upload

```php
public function update(Request $request, $id)
{
    $model = Model::findOrFail($id);
    $data = $request->validate([...]);

    // Handle upload (otomatis hapus file lama jika ada)
    $data = array_merge($data, $this->handleFileUpload(
        $model, 
        'kolom_file', 
        $request, 
        'nama_field_form', 
        'path/storage'
    ));

    $model->update($data);
    
    return redirect()->back()->with('success', 'Berhasil update');
}
```

#### ✅ DELETE File (Set ke Null)

```php
public function deleteFile(Request $request, $id)
{
    $model = Model::findOrFail($id);
    
    // Hapus file fisik + set kolom ke null (JANGAN hapus row)
    $deleteData = $this->handleFileDeletion($model, 'kolom_file');
    $model->update($deleteData);
    
    return redirect()->back()->with('success', 'File dihapus. Bisa upload lagi.');
}
```

#### ✅ UPLOAD + REPLACE dalam Satu Form

```php
public function update(Request $request, $id)
{
    $model = Model::findOrFail($id);
    $data = $request->validate([
        'file_field' => ['nullable', 'image', 'mimes:jpg,png', 'max:2048'],
    ]);

    // Jika ada file baru, otomatis hapus yang lama
    if ($request->hasFile('file_field')) {
        $uploadData = $this->handleFileUpload(
            $model, 
            'kolom_file', 
            $request, 
            'file_field', 
            'storage/path'
        );
        $data = array_merge($data, $uploadData);
    }

    $model->update($data);
    return redirect()->back()->with('success', 'Update berhasil');
}
```

---

### Blade View Pattern

#### ✅ INPUT FILE STATIK (Selalu Muncul)

```blade
<!-- Input file SELALU ada, tidak peduli ada file atau tidak -->
<label>Foto</label>
<input type="file" 
       name="foto" 
       accept=".jpg,.jpeg,.png"
       class="form-control">
<p class="text-muted">Upload untuk mengganti foto. Kosongkan jika tidak ingin mengubah.</p>

<!-- Preview jika ada file -->
@if($model->foto)
    <div class="preview mt-3">
        <div class="text-xs font-semibold mb-2">Foto Saat Ini:</div>
        <img src="{{ asset('storage/' . $model->foto) }}" class="img-thumbnail">
        
        <!-- Tombol delete terpisah -->
        <form action="{{ route('model.foto.delete', $model) }}" method="POST" 
              class="mt-2" onsubmit="return confirm('Hapus foto? Bisa upload lagi nanti.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Hapus Foto</button>
        </form>
    </div>
@else
    <div class="mt-3 text-muted italic">Belum ada foto. Upload file di atas.</div>
@endif
```

#### ❌ JANGAN Lakukan Ini

```blade
<!-- ❌ SALAH: Input file conditional, hilang jika tidak ada foto -->
@if($model->foto)
    <input type="file" name="foto">
    <img src="{{ asset('storage/' . $model->foto) }}">
    <label><input type="checkbox" name="remove_foto"> Hapus foto</label>
@endif
```

#### ✅ Lakukan Ini

```blade
<!-- ✅ BENAR: Input file selalu ada, preview conditional -->
<input type="file" name="foto">

@if($model->foto)
    <img src="{{ asset('storage/' . $model->foto) }}">
    <form action="..." method="POST">
        <button>Hapus Foto</button>
    </form>
@else
    <p>Belum ada foto</p>
@endif
```

---

## Contoh Implementasi Lengkap

### 1. Program Sekolah

**Controller:** `AdminProgramController.php`

```php
public function update(Request $request, $id)
{
    $program = Program::findOrFail($id);
    $data = $this->validateProgram($request, $program->id);

    // Handle multiple uploads
    $data = array_merge($data, $this->handleFileUpload($program, 'foto', $request, 'foto', 'program'));
    $data = array_merge($data, $this->handleFileUpload($program, 'card_bg_image', $request, 'card_bg_image', 'program/card'));
    $data = array_merge($data, $this->handleFileUpload($program, 'logo', $request, 'logo', 'program/logo'));

    $program->update($data);
    return redirect()->back()->with('success', 'Program updated');
}

public function deleteFoto(Request $request, $id)
{
    $program = Program::findOrFail($id);
    $deleteData = $this->handleFileDeletion($program, 'foto');
    $program->update($deleteData);
    
    return redirect()->back()->with('success', 'Foto dihapus. Bisa upload lagi.');
}
```

**Routes:**

```php
Route::put('program-sekolah/{id}', [AdminProgramController::class, 'update'])
    ->name('program-sekolah.update');
Route::delete('program-sekolah/{id}/foto', [AdminProgramController::class, 'deleteFoto'])
    ->name('program-sekolah.foto.delete');
Route::delete('program-sekolah/{id}/card-bg', [AdminProgramController::class, 'deleteCardBg'])
    ->name('program-sekolah.card-bg.delete');
Route::delete('program-sekolah/{id}/logo', [AdminProgramController::class, 'deleteLogo'])
    ->name('program-sekolah.logo.delete');
```

**Blade:** `resources/views/admin/program/info.blade.php`

```blade
<!-- Input file selalu ada -->
<input type="file" name="foto" accept=".jpg,.jpeg,.png">

@if($program->foto)
    <img src="{{ asset('storage/' . $program->foto) }}">
    <form action="{{ route('admin.program-sekolah.foto.delete', $program) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus Foto</button>
    </form>
@else
    <p>Belum ada foto</p>
@endif
```

---

### 2. Foto Kepala Sekolah (SiteSetting)

**Controller:** `AdminSettingsController.php`

```php
public function uploadFotoKepsek(Request $request)
{
    $request->validate([
        'foto_kepsek' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:3072'],
    ]);

    $path = SiteSetting::uploadFotoKepsek($request->file('foto_kepsek'));
    
    return redirect()->back()->with('success', 'Foto berhasil diupload');
}

public function deleteFotoKepsek()
{
    SiteSetting::deleteFotoKepsek(); // Set to null, don't delete row
    
    return redirect()->back()->with('success', 'Foto dihapus. Bisa upload lagi.');
}
```

**Model:** `SiteSetting.php`

```php
public static function uploadFotoKepsek($image): ?string
{
    // Hapus foto lama
    $oldFoto = self::getFotoKepsek();
    if ($oldFoto) {
        Storage::disk('public')->delete($oldFoto);
    }

    // Store foto baru
    $path = $image->store('kepala-sekolah', 'public');

    // UPDATE atau CREATE (row tidak pernah dihapus)
    static::updateOrCreate(
        ['key' => 'foto_kepsek'],
        ['foto_kepsek' => $path]
    );

    return $path;
}

public static function deleteFotoKepsek(): bool
{
    // Hapus file fisik
    $oldFoto = self::getFotoKepsek();
    if ($oldFoto) {
        Storage::disk('public')->delete($oldFoto);
    }

    // Set ke null (JANGAN delete row)
    static::updateOrCreate(
        ['key' => 'foto_kepsek'],
        ['foto_kepsek' => null]
    );

    return true;
}
```

**Blade:** `resources/views/admin/settings_hidden.blade.php`

```blade
<!-- Upload form SELALU ada -->
<form action="{{ route('admin.settings.upload-foto-kepsek') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="foto_kepsek" accept=".jpg,.jpeg,.png,.webp">
    <button type="submit">Upload Foto</button>
</form>

<!-- Preview conditional -->
@if($fotoKepsek)
    <img src="{{ asset('storage/' . $fotoKepsek) }}">
    <form action="{{ route('admin.settings.delete-foto-kepsek') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus Foto</button>
    </form>
@else
    <p>Belum ada foto</p>
@endif
```

---

## Flow Lengkap

### Upload Pertama Kali

```
User pilih file → Submit
  ↓
Controller validasi
  ↓
handleFileUpload() dipanggil
  ↓
Cek file lama → Tidak ada
  ↓
Store file baru
  ↓
Update database: kolom_file = 'path/baru.jpg'
  ↓
Redirect dengan pesan sukses
  ↓
Blade menampilkan file
```

### Replace File

```
User pilih file baru → Submit
  ↓
Controller validasi
  ↓
handleFileUpload() dipanggil
  ↓
Cek file lama → Ada ('path/lama.jpg')
  ↓
Hapus file lama dari storage
  ↓
Store file baru
  ↓
Update database: kolom_file = 'path/baru.jpg'
  ↓
Redirect dengan pesan sukses
  ↓
Blade menampilkan file baru
```

### Delete File

```
User klik "Hapus File" → Confirm
  ↓
Controller panggil delete method
  ↓
handleFileDeletion() dipanggil
  ↓
Cek file lama → Ada ('path/file.jpg')
  ↓
Hapus file dari storage
  ↓
Update database: kolom_file = null
  ↓
Row TETAP ADA, hanya kolom yang null
  ↓
Redirect dengan pesan sukses
  ↓
Blade menampilkan placeholder "Belum ada file"
  ↓
Input file MASIH ADA → Bisa upload lagi
```

### Upload Setelah Delete

```
User pilih file → Submit
  ↓
Controller validasi
  ↓
handleFileUpload() dipanggil
  ↓
Cek file lama → null (karena sudah dihapus)
  ↓
Store file baru
  ↓
Update database: kolom_file = 'path/baru.jpg'
  ↓
Redirect dengan pesan sukses
  ↓
Blade menampilkan file baru
```

---

## Keuntungan Pattern Ini

### ✅ Data Aman
- Row tidak pernah dihapus dari database
- Hanya kolom file yang berubah jadi `null`
- Tidak ada orphaned records

### ✅ User Friendly
- Input file selalu tersedia
- Bisa upload kapan saja tanpa masalah
- Tidak ada "kolom hilang" setelah delete

### ✅ Konsisten
- Pattern yang sama di semua fitur
- Mudah di-maintain
- Mudah ditambahkan ke fitur baru

### ✅ Flexible
- Bisa upload/delete berulang kali
- Tidak ada batasan jumlah
- Idempotent (aman dipanggil berulang)

### ✅ Clean Code
- Reusable methods di base controller
- Trait untuk model
- DRY (Don't Repeat Yourself)

---

## Checklist Implementasi

Untuk setiap fitur yang punya upload/delete:

### Controller
- [ ] Gunakan `handleFileUpload()` untuk upload
- [ ] Gunakan `handleFileDeletion()` untuk delete
- [ ] Jangan gunakan `delete()` untuk row database
- [ ] Redirect dengan pesan sukses

### Model (jika pakai Trait)
- [ ] `use UploadableTrait`
- [ ] Definisikan `$uploadableColumns`
- [ ] Gunakan `uploadToColumn()` dan `deleteFromColumn()`

### Routes
- [ ] Route untuk upload/update (POST/PUT)
- [ ] Route terpisah untuk delete (DELETE)
- [ ] Naming: `resource.field.delete`

### Blade View
- [ ] Input file SELALU ada (tidak conditional)
- [ ] Preview file conditional (`@if`)
- [ ] Tombol delete dengan form terpisah
- [ ] Placeholder jika tidak ada file
- [ ] Pesan helper untuk user

---

## Fitur yang Sudah Diperbaiki

### ✅ Sudah Selesai

1. **Program Sekolah** (`AdminProgramController`)
   - Foto program
   - Card background
   - Logo program
   - Dedicated delete routes

2. **Foto Kepala Sekolah** (`AdminSettingsController` + `SiteSetting`)
   - Upload foto
   - Delete foto (set to null)
   - Static input form

3. **Sambutan Kepala Sekolah** (`AdminSambutanController`)
   - Foto sambutan
   - Delete (set to null)

4. **School Profile** (`AdminSchoolProfileController`)
   - Logo sekolah
   - Delete logo (set to null)

### 📋 Bisa Ditambahkan Dengan Pattern Sama

5. **Gallery** (`AdminGalleryController`)
   - Foto gallery

6. **Artikel** (`AdminArticleController`)
   - Featured image

7. **Hero Slides** (`AdminHeroSlideController`)
   - Hero slide images

8. **Guru** (`GuruController`)
   - Photo guru

9. **Fasilitas** (`FasilitasController`)
   - Foto fasilitas

10. **Prestasi** (`AdminPrestasiController`)
    - Foto prestasi

11. **Program Photos** (`AdminProgramPhotoController`)
    - Program photos

Untuk menambahkan ke fitur lain, cukup ikuti pattern di atas!

---

## Troubleshooting

### Masalah: File tidak muncul setelah upload

**Solusi:**
```php
// Cek apakah file tersimpan
dd($model->kolom_file);

// Cek apakah file ada di storage
\Storage::disk('public')->exists($model->kolom_file);

// Pastikan storage link sudah dibuat
php artisan storage:link
```

### Masalah: Input file hilang setelah delete

**Solusi:**
```blade
<!-- ❌ SALAH: Input conditional -->
@if($model->file)
    <input type="file" name="file">
@endif

<!-- ✅ BENAR: Input selalu ada -->
<input type="file" name="file">

@if($model->file)
    <img src="{{ asset('storage/' . $model->file) }}">
    <form>...</form>
@else
    <p>Belum ada file</p>
@endif
```

### Masalah: Error "Column cannot be null"

**Solusi:**
```php
// Pastikan kolom di migration nullable
Schema::table('table_name', function (Blueprint $table) {
    $table->string('kolom_file')->nullable(); // ← PENTING!
});
```

### Masalah: File lama tidak terhapus

**Solusi:**
```php
// Pastikan path benar
if ($model->kolom_file) {
    \Storage::disk('public')->delete($model->kolom_file);
}

// Debug path
dd($model->kolom_file);
dd(\Storage::disk('public')->path($model->kolom_file));
```

### Masalah: Row terhapus dari database

**Solusi:**
```php
// ❌ SALAH: Delete row
$model->delete();

// ✅ BENAR: Set column to null
$model->update(['kolom_file' => null]);

// Atau pakai helper
$this->handleFileDeletion($model, 'kolom_file');
```

---

## Best Practices

### 1. Selalu Gunakan Helper Methods

```php
// ❌ Manual (rawannya bug)
if ($request->hasFile('foto')) {
    if ($model->foto) {
        Storage::delete($model->foto);
    }
    $model->update(['foto' => $request->file('foto')->store('path')]);
}

// ✅ Pakai helper (lebih aman)
$data = $this->handleFileUpload($model, 'foto', $request, 'foto', 'path');
$model->update($data);
```

### 2. Validasi File di Controller

```php
$validated = $request->validate([
    'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
]);
```

### 3. Gunakan Dedicated Delete Routes

```php
// ❌ Delete via checkbox dalam form update
<input type="checkbox" name="remove_foto">

// ✅ Delete via route terpisah
Route::delete('resource/{id}/foto', [Controller::class, 'deleteFoto']);
```

### 4. Tambah Pesan yang Jelas

```php
return redirect()->back()
    ->with('success', 'Foto berhasil dihapus. Anda bisa upload foto baru kapan saja.');
```

### 5. Confirmation Before Delete

```blade
<form onsubmit="return confirm('Yakin hapus file? Bisa upload lagi nanti.')">
```

---

## Migration Template

Untuk fitur baru, pastikan kolom file nullable:

```php
Schema::create('table_name', function (Blueprint $table) {
    $table->id();
    // ... kolom lain
    $table->string('foto')->nullable(); // ← PENTING!
    $table->string('thumbnail')->nullable();
    $table->timestamps();
});
```

Atau add column ke table yang sudah ada:

```php
Schema::table('table_name', function (Blueprint $table) {
    $table->string('foto')->nullable()->after('column_name');
});
```

---

## Kesimpulan

Pattern ini menyelesaikan masalah "kolom hilang setelah hapus foto" secara global dengan:

1. ✅ **Row database tidak pernah dihapus** - Hanya kolom file yang di-set ke null
2. ✅ **Input file selalu tersedia** - Bisa upload kapan saja
3. ✅ **Konsisten di semua fitur** - Pattern yang sama
4. ✅ **Reusable code** - Base controller methods + trait
5. ✅ **User friendly** - Jelas dan tidak membingungkan

**Setiap kali ada fitur upload/delete baru, gunakan pattern ini!**
