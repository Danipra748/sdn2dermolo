# Drag & Drop Upload - Program Sekolah

## ✅ Fitur yang Sudah Diterapkan

Sistem drag and drop untuk upload foto di halaman Program Sekolah sudah berhasil diimplementasikan menggunakan **sistem global yang sudah ada** di project ini.

### 📍 Halaman yang Diperbarui

1. **Form Program Sekolah** (`resources/views/admin/program/info.blade.php`)
   - ✅ Background Kartu Program (`card_bg_image`)
   - ✅ Foto Program (`foto`)
   - ✅ Logo Program (`logo`)

2. **Form Dokumentasi** (`resources/views/admin/program/photos/form.blade.php`)
   - ✅ Foto Dokumentasi (`photo`)

---

## 🎨 Desain & Fitur

### Tampilan Kotak Drag & Drop
- **Border putus-putus (dashed)** dengan warna abu-abu elegan
- **Ikon upload** yang jelas dan intuitif
- **Teks instruksi**: "Tarik dan lepaskan file di sini atau klik untuk mengunggah"
- **Hint format**: "Format: .jpg, .jpeg, .png, .webp, .gif (Maks. 2MB)"

### Interaksi
- ✅ **Drag & Drop**: Seret foto langsung ke kotak upload
- ✅ **Click to Select**: Klik kotak untuk memilih file secara manual
- ✅ **Hover Effect**: Kotak berubah warna saat di-hover
- ✅ **Drag Over Effect**: Kotak highlight dengan warna hijau saat file diseret

### Preview & Feedback
- ✅ **Thumbnail Preview**: Muncul setelah foto dipilih/diseret
- ✅ **File Info Card**: Menampilkan nama dan ukuran file
- ✅ **Tombol Hapus**: Tombol merah "Hapus" untuk membatalkan pilihan foto
- ✅ **Validasi File**: 
  - Hanya menerima gambar (JPG, JPEG, PNG, WEBP, GIF)
  - Maksimal 2MB
  - Pesan error yang jelas jika validasi gagal

### Animasi
- ✅ **Fade In**: Preview muncul dengan animasi smooth
- ✅ **Scale Effect**: Kotak membesar sedikit saat drag over
- ✅ **Shake Effect**: Kotak error bergetar untuk feedback visual

---

## 🔧 Cara Kerja

### Untuk Admin SD N 2 Dermolo:

1. **Upload Background Kartu Program**:
   - Seret foto background ke kotak "Background Card Program"
   - ATAU klik kotak tersebut untuk memilih dari file explorer
   - Preview akan muncul otomatis
   - Klik "Hapus" jika salah pilih foto

2. **Upload Foto Dokumentasi**:
   - Seret foto dokumentasi ke kotak "Foto Dokumentasi"
   - ATAU klik untuk memilih manual
   - Preview muncul dengan info file
   - Klik "Hapus" untuk membatalkan

3. **Simpan Form**:
   - Setelah yakin dengan pilihan foto, klik "Simpan"
   - Laravel akan memproses upload seperti biasa

---

## 📂 File yang Digunakan

Sistem ini menggunakan **file global yang sudah ada** di project:

| File | Lokasi | Fungsi |
|------|--------|--------|
| `drop-zone.js` | `public/js/drop-zone.js` | JavaScript drag & drop handler |
| `drop-zone.css` | `public/css/drop-zone.css` | Styling untuk kotak drag & drop |

### Cara Menggunakan di Form Lain:

Cukup tambahkan class `drop-zone-enabled` pada input file:

```html
<input type="file" 
       name="nama_field" 
       accept=".jpg,.jpeg,.png,.webp"
       class="drop-zone-enabled">
```

Script akan otomatis mengubahnya menjadi drag & drop zone!

---

## ✅ Kompatibilitas Laravel

- ✅ **Name attribute tetap**: `card_bg_image`, `foto`, `logo`, `photo`
- ✅ **Controller tidak perlu diubah**: Semua upload berjalan normal
- ✅ **Validasi Laravel tetap berjalan**: Error messages ditampilkan seperti biasa
- ✅ **Existing file handling**: Checkbox "Hapus foto saat ini" tetap berfungsi

---

## 🎯 Keuntungan

1. **User-Friendly**: Admin SD N 2 Dermolo bisa upload dengan lebih mudah
2. **Visual Feedback**: Jelas file mana yang akan diupload
3. **Error Prevention**: Bisa batal jika salah pilih foto
4. **Profesional**: Tampilan modern dan elegan
5. **Reusable**: Bisa dipakai di form lain dengan 1 baris kode

---

## 📸 Contoh Penggunaan

### Sebelum Upload:
```
┌─────────────────────────────────┐
│          [Upload Icon]          │
│                                 │
│   Tarik dan lepaskan file       │
│   di sini atau klik untuk       │
│   mengunggah                    │
│                                 │
│   Format: .jpg, .jpeg, .png    │
│   (Maks. 2MB)                   │
└─────────────────────────────────┘
```

### Setelah Upload:
```
┌─────────────────────────────────┐
│                                 │
│      [Preview Thumbnail]        │
│                                 │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│ 📷 nama-foto.jpg         [Hapus]│
│    1.2 MB                       │
└─────────────────────────────────┘
```

---

## 🔮 Rekomendasi Selanjutnya (Opsional)

Jika ingin menambahkan drag & drop ke halaman lain:
- Fasilitas Sekolah
- Data Guru
- Galeri Foto
- Prestasi Sekolah
- Artikel/Berita

Cukup tambahkan class `drop-zone-enabled` pada `<input type="file">`!

---

**Status**: ✅ **SELESAI & SIAP DIGUNAKAN**

Admin SD N 2 Dermolo sekarang bisa upload foto untuk Program Sekolah dengan drag & drop yang lebih mudah dan intuitif!
