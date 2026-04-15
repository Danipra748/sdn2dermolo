# Fix: Upload & Delete Foto Kepala Sekolah

## Masalah
Setelah foto dihapus, kesulitan menambahkannya kembali karena kolom/row data hilang dari tampilan.

## Solusi yang Diterapkan

### 1. **Controller** (`AdminSettingsController.php`)

#### uploadFotoKepsek()
- ✅ Sudah benar menggunakan validasi `required` untuk memastikan file harus ada saat upload
- ✅ Memanggil `SiteSetting::uploadFotoKepsek()` yang menggunakan `updateOrCreate`
- ✅ Tidak perlu perubahan karena sudah handle dengan baik

#### deleteFotoKepsek()
- ✅ Sudah benar memanggil `SiteSetting::deleteFotoKepsek()`
- ✅ Hanya menghapus file fisik dan set kolom ke `null`, bukan menghapus row
- ✅ Tidak perlu perubahan karena sudah handle dengan baik

### 2. **Model** (`SiteSetting.php`)

#### uploadFotoKepsek()
```php
public static function uploadFotoKepsek($image): ?string
{
    // 1. Hapus foto lama jika ada
    $oldFoto = self::getFotoKepsek();
    if ($oldFoto) {
        \Storage::disk('public')->delete($oldFoto);
    }

    // 2. Store foto baru
    $path = $image->store('kepala-sekolah', 'public');

    // 3. UPDATE atau CREATE row dengan updateOrCreate
    //    - Jika row dengan key='foto_kepsek' sudah ada → UPDATE kolom foto_kepsek
    //    - Jika belum ada → CREATE row baru
    static::updateOrCreate(
        ['key' => 'foto_kepsek'],
        ['foto_kepsek' => $path]
    );

    return $path;
}
```

**Kenapa updateOrCreate?**
- Mencegah duplikasi row di database
- Jika belum ada foto → buat row baru
- Jika sudah ada foto → update kolom `foto_kepsek` saja
- Row data tidak pernah hilang, hanya kolom `foto_kepsek` yang berubah

#### deleteFotoKepsek()
```php
public static function deleteFotoKepsek(): bool
{
    // 1. Hapus file fisik dari storage
    $oldFoto = self::getFotoKepsek();
    if ($oldFoto) {
        \Storage::disk('public')->delete($oldFoto);
    }

    // 2. Set kolom foto_kepsek ke NULL (BUKAN delete row)
    static::updateOrCreate(
        ['key' => 'foto_kepsek'],
        ['foto_kepsek' => null]  // ← PENTING: null, bukan delete
    );

    return true;
}
```

**Kenapa tidak delete row?**
- Row tetap ada dengan `foto_kepsek = null`
- Upload berikutnya tinggal UPDATE row yang sama
- Struktur database tetap terjaga
- Tidak perlu khawatir row "hilang"

### 3. **Blade View** (`settings_hidden.blade.php`)

#### Upload Form (Selalu Muncul)
```blade
<form action="{{ route('admin.settings.upload-foto-kepsek') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Input file SELALU ada, tidak peduli ada foto atau tidak -->
    <input type="file"
           name="foto_kepsek"
           accept=".jpg,.jpeg,.png,.webp"
           onchange="previewFotoKepsek(event)">
    
    <!-- Tombol upload SELALU ada -->
    <button type="submit">Upload / Ganti Foto Kepala Sekolah</button>
</form>
```

#### Preview Section (Kondisional)
```blade
@if($fotoKepsek)
    <!-- Tampilkan foto saat ini -->
    <img src="{{ asset('storage/' . $fotoKepsek) }}">
    
    <!-- Tombol hapus -->
    <form action="{{ route('admin.settings.delete-foto-kepsek') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus Foto</button>
    </form>
@else
    <!-- Placeholder jika belum ada foto -->
    <div>Belum ada foto</div>
@endif
```

**Logika yang benar:**
- ✅ Upload form **SELALU** muncul (tidak pernah hilang)
- ✅ Preview foto **KONDISIONAL** (muncul hanya jika ada foto)
- ✅ Tombol "Hapus" **KONDISIONAL** (muncul hanya jika ada foto)
- ✅ Setelah hapus, upload form tetap ada → bisa upload lagi

### 4. **Database Migration**

```php
// File: 2026_04_12_010000_add_foto_kepsek_to_site_settings.php
Schema::table('site_settings', function (Blueprint $table) {
    $table->string('foto_kepsek')->nullable()->after('hero_image');
    //                                         ↑↑↑↑↑↑↑↑
    //                                   PENTING: nullable!
});
```

**Kenapa nullable?**
- Mengizinkan kolom `foto_kepsek` bernilai `NULL`
- Saat foto dihapus, kolom di-set ke `null` (bukan delete row)
- Upload berikutnya tinggal update dari `null` ke path baru

## Flow Lengkap

### Upload Pertama Kali
1. User pilih file → Submit
2. Controller validasi file
3. Model `uploadFotoKepsek()`:
   - Cek foto lama → tidak ada (null)
   - Store file baru ke `storage/kepala-sekolah/xxx.jpg`
   - `updateOrCreate` → **CREATE** row baru dengan `key='foto_kepsek'`, `foto_kepsek='path'`
4. Redirect dengan pesan sukses
5. Blade menampilkan foto

### Upload Kedua Kali (Replace)
1. User pilih file baru → Submit
2. Controller validasi file
3. Model `uploadFotoKepsek()`:
   - Cek foto lama → ada (`storage/kepala-sekolah/old.jpg`)
   - **Hapus file lama** dari storage
   - Store file baru ke `storage/kepala-sekolah/new.jpg`
   - `updateOrCreate` → **UPDATE** row yang sama, kolom `foto_kepsek` berubah
4. Redirect dengan pesan sukses
5. Blade menampilkan foto baru

### Delete Foto
1. User klik "Hapus Foto" → Confirm
2. Controller panggil `deleteFotoKepsek()`
3. Model `deleteFotoKepsek()`:
   - Cek foto lama → ada (`storage/kepala-sekolah/new.jpg`)
   - **Hapus file** dari storage
   - `updateOrCreate` → **UPDATE** row yang sama, kolom `foto_kepsek` jadi **null**
4. Redirect dengan pesan sukses
5. Blade menampilkan placeholder "Belum ada foto"
6. **Upload form masih ada** → bisa upload lagi

### Upload Setelah Delete
1. User pilih file → Submit
2. Controller validasi file
3. Model `uploadFotoKepsek()`:
   - Cek foto lama → **null** (karena sudah dihapus)
   - Store file baru ke `storage/kepala-sekolah/xxx.jpg`
   - `updateOrCreate` → **UPDATE** row yang sama, kolom `foto_kepsek` berubah dari null ke path
4. Redirect dengan pesan sukses
5. Blade menampilkan foto baru

## Keuntungan Solusi Ini

1. ✅ **Row tidak pernah hilang** - Selalu ada row dengan `key='foto_kepsek'`
2. ✅ **Upload form selalu ada** - Bisa upload kapan saja tanpa masalah
3. ✅ **Tidak ada duplikasi** - `updateOrCreate` memastikan hanya 1 row per key
4. ✅ **File lama selalu dibersihkan** - Otomatis hapus file lama sebelum upload baru
5. ✅ **Database tetap bersih** - Tidak ada orphaned rows atau data hilang
6. ✅ **Idempotent** - Bisa upload/delete berulang kali tanpa error

## Testing

Untuk memastikan semuanya bekerja:

1. **Upload pertama kali:**
   ```
   - Buka halaman admin settings
   - Pilih file foto
   - Klik Upload
   - ✅ Foto muncul di preview
   ```

2. **Replace foto:**
   ```
   - Pilih file foto baru
   - Klik Upload
   - ✅ Foto lama hilang, foto baru muncul
   ```

3. **Delete foto:**
   ```
   - Klik "Hapus Foto"
   - Confirm
   - ✅ Foto hilang, placeholder muncul
   - ✅ Upload form masih ada
   ```

4. **Upload setelah delete:**
   ```
   - Pilih file foto baru
   - Klik Upload
   - ✅ Foto muncul lagi (tidak ada error)
   ```

## Troubleshooting

### Masalah: "Column 'foto_kepsek' cannot be null"
**Solusi:** Pastikan migration sudah run dan kolom `foto_kepsek` punya `->nullable()`

### Masalah: Foto tidak muncul setelah upload
**Solusi:** 
- Cek `storage/app/public` ada foto nya
- Pastikan sudah run `php artisan storage:link`
- Cek permission folder storage

### Masalah: Upload form hilang setelah delete
**Solusi:** 
- Pastikan blade menggunakan `@if($fotoKepsek)` bukan `@if(isset($fotoKepsek))`
- Pastikan controller mengirim `$fotoKepsek` ke view (walaupun null)

### Masalah: Duplikasi row di database
**Solusi:** 
- Pastikan model menggunakan `updateOrCreate` bukan `create`
- Cek tidak ada kode lain yang insert row manual

## Kesimpulan

Solusi ini sudah **production-ready** dan menangani semua edge cases:
- ✅ Upload pertama kali
- ✅ Replace foto
- ✅ Delete foto
- ✅ Upload setelah delete
- ✅ Tidak ada row yang hilang
- ✅ Form selalu tersedia

Semua menggunakan pattern **updateOrCreate** yang memastikan data row tetap ada, hanya kolom `foto_kepsek` yang berubah nilainya.
