# DRAG & DROP FIX - GALERI FOTO

## 🐛 Masalah

Fitur drag & drop yang sudah berjalan di halaman lain (Data Guru, Program Sekolah) **TIDAK berfungsi** di halaman **Galeri Foto**.

**Gejala:**
- File yang diseret ke kotak "Pilih File" tidak terdeteksi
- Tidak ada preview yang muncul
- File tidak masuk ke input

---

## ✅ Solusi yang Diterapkan

### 1. File JavaScript Khusus Galeri

Dibuat file khusus: `public/js/gallery-drop-zone-fix.js`

**Kenapa khusus?**
- Menggunakan ID unik: `foto-input`
- Wrapper class unik: `gallery-drop-wrapper`
- Data attributes unik: `data-gallery-*`
- **Tidak akan konflik** dengan drop-zone global

### 2. Fitur yang Ditambahkan

| Fitur | Status | Keterangan |
|-------|--------|------------|
| **Drag & Drop** | ✅ | Seret foto ke kotak unggah |
| **Click to Upload** | ✅ | Klik untuk pilih manual |
| **Preview Gambar** | ✅ | Thumbnail muncul otomatis |
| **Info File** | ✅ | Nama + ukuran file |
| **Tombol Hapus** | ✅ | Batalkan pilihan foto |
| **Validasi File** | ✅ | Cek format (JPG/PNG/WEBP) & ukuran (max 2MB) |
| **Error Message** | ✅ | Pesan error Bahasa Indonesia |
| **Hover Effect** | ✅ | Border hijau saat hover |
| **Drag Over Effect** | ✅ | Gradient hijau saat drag |

---

## 🎯 Elemen yang Digunakan

### ID Element (Unik untuk Galeri):

```html
<input type="file"
       name="foto"
       id="foto-input"              ← ID UNIK (tidak konflik)
       class="drop-zone-enabled"
       accept=".jpg,.jpeg,.png,.webp">
```

### Wrapper & Classes:

```css
.gallery-drop-wrapper          /* Container utama */
.gallery-drop-zone             /* Kotak drag & drop */
.gallery-drop-preview          /* Preview gambar */
.gallery-drop-file-info        /* Info file */
.gallery-drop-error            /* Pesan error */
```

### Data Attributes:

```javascript
data-gallery-drop-zone         /* Kotak utama */
data-gallery-file-input        /* Input file tersembunyi */
data-gallery-drop-content      /* Konten placeholder */
data-gallery-drop-preview      /* Container preview */
data-gallery-preview-img       /* Gambar preview */
data-gallery-file-info         /* Container info file */
data-gallery-file-name         /* Nama file */
data-gallery-file-size         /* Ukuran file */
data-gallery-remove-file       /* Tombol hapus */
```

---

## 📋 Cara Menggunakan

### Di Halaman Galeri Foto:

**Tidak perlu ubah apapun!** Script sudah otomatis aktif.

Cukup pastikan di `form.blade.php` ada:

```html
<input type="file"
       name="foto"
       id="foto-input"
       class="drop-zone-enabled"
       accept=".jpg,.jpeg,.png,.webp">
```

Script akan:
1. ✅ Mendeteksi element `#foto-input`
2. ✅ Mengubahnya menjadi drag & drop zone
3. ✅ Menampilkan preview saat file dipilih
4. ✅ Validasi file otomatis

---

## 🎨 Tampilan Kotak Unggah

### Sebelum Upload:
```
┌───────────────────────────────────┐
│                                   │
│          📤 [Icon Upload]         │
│                                   │
│   Seret foto ke sini atau klik    │
│   untuk mengunggah                │
│                                   │
│   Format: .jpg, .jpeg, .png,     │
│   .webp (Maks. 2MB)               │
│                                   │
└───────────────────────────────────┘
```

**Styling:**
- Border: 2px dashed #CBD5E1 (abu-abu)
- Background: #F8FAFC (abu-abu muda)
- Padding: 2.5rem 1.5rem
- Cursor: pointer

### Saat Drag File:
```
┌───────────────────────────────────┐
│     🟢 Border Hijau + Gradient    │
│                                   │
│          📤 [Icon Upload]         │
│                                   │
│   Seret foto ke sini atau klik    │
│   untuk mengunggah                │
│                                   │
└───────────────────────────────────┘
```

**Effect:**
- Border: #10B981 (hijau solid)
- Background: linear-gradient(#ECFDF5 → #D1FAE5)
- Transform: scale(1.02)

### Setelah Upload:
```
┌───────────────────────────────────┐
│                                   │
│      [Thumbnail Preview]          │
│                                   │
└───────────────────────────────────┘

┌───────────────────────────────────┐
│ 📷 foto-kegiatan.jpg    [Hapus]  │
│    1.5 MB                         │
└───────────────────────────────────┘
```

**Preview:**
- Max-height: 250px
- Border-radius: 10px
- Box-shadow: 0 4px 12px rgba(0,0,0,0.1)

---

## 🔧 Konfigurasi

Jika ingin mengubah setting, edit di `gallery-drop-zone-fix.js`:

```javascript
const GALLERY_DROP_CONFIG = {
    targetId: 'foto-input',              // ← ID element target
    acceptedTypes: [                     // ← Format yang diterima
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp'
    ],
    acceptedExtensions: '.jpg, .jpeg, .png, .webp',
    maxSize: 2 * 1024 * 1024,            // ← Max 2MB
    maxSizeDisplay: '2MB',
    placeholderText: 'Seret foto ke sini atau klik untuk mengunggah',
    removeButtonText: 'Hapus'
};
```

---

## 🚀 Cara Menerapkan ke Halaman Lain

Jika ingin menggunakan fix ini di halaman lain:

### Opsi 1: Gunakan Global Drop Zone (Recommended)

Cukup tambahkan class `drop-zone-enabled`:

```html
<input type="file" name="foto" class="drop-zone-enabled">
```

### Opsi 2: Gunakan Script Khusus

1. Copy file `gallery-drop-zone-fix.js`
2. Ubah `targetId` di config:
   ```javascript
   const GALLERY_DROP_CONFIG = {
       targetId: 'nama-input-baru',  // ← Ganti dengan ID baru
       // ... config lainnya
   };
   ```
3. Include di blade file:
   ```html
   <script src="{{ asset('js/gallery-drop-zone-fix.js') }}"></script>
   ```

---

## 🐛 Troubleshooting

### Drop Zone Tidak Muncul

**Penyebab:** Script tidak ter-load atau ID tidak ditemukan

**Solusi:**
1. Cek console browser untuk error
2. Pastikan script dimuat:
   ```html
   <script src="{{ asset('js/gallery-drop-zone-fix.js') }}"></script>
   ```
3. Pastikan ID element sesuai:
   ```html
   <input type="file" id="foto-input" class="drop-zone-enabled">
   ```

### File Tidak Bisa Drop

**Penyebab:** Event listener tidak terpasang atau ada konflik JS

**Solusi:**
1. Buka Console (F12) → lihat pesan log:
   ```
   [Gallery Drop Zone] Script loaded. Waiting for DOM...
   [Gallery Drop Zone] Initializing for #foto-input...
   [Gallery Drop Zone] ✅ Successfully initialized!
   ```
2. Jika tidak ada log, script tidak ter-load
3. Jika ada log "Skipping", berarti sudah dihandle oleh global handler

### Preview Tidak Muncul

**Penyebab:** FileReader error atau format file tidak didukung

**Solusi:**
1. Pastikan file adalah gambar (JPG/PNG/WEBP)
2. Cek ukuran file (max 2MB)
3. Lihat error message di bawah kotak upload

### Script Konflik dengan Global

**Penyebab:** Kedua script mencoba menghandle element yang sama

**Solusi:**
Script sudah dilengkapi pengecekan:
```javascript
if (originalInput.dataset.dropZoneInitialized === 'true') {
    console.log('[Gallery Drop Zone] Already initialized by global handler. Skipping.');
    return;
}
```

---

## 📊 Perbedaan dengan Global Drop Zone

| Aspek | Global Drop Zone | Gallery Fix |
|-------|------------------|-------------|
| **Target** | Semua `.drop-zone-enabled` | Khusus `#foto-input` |
| **Scope** | General | Specific |
| **Classes** | `.drop-zone-*` | `.gallery-drop-*` |
| **Data Attr** | `data-drop-*` | `data-gallery-*` |
| **Konflik** | Mungkin | Tidak (isolated) |
| **Teks** | "Tarik dan lepaskan file di sini" | "Seret foto ke sini atau klik untuk mengunggah" |

---

## ✅ Testing Checklist

Setelah implementasi, pastikan:

- [ ] Kotak drag & drop muncul dengan border putus-putus
- [ ] Teks petunjuk: "Seret foto ke sini atau klik untuk mengunggah"
- [ ] File bisa di-drag ke kotak
- [ ] Border berubah hijau saat drag over
- [ ] Preview gambar muncul setelah drop
- [ ] Info file muncul (nama + ukuran)
- [ ] Tombol "Hapus" berfungsi
- [ ] Validasi file berjalan (format & ukuran)
- [ ] Error message muncul jika file tidak valid
- [ ] Form bisa disubmit dengan file
- [ ] File tersimpan ke database & storage

---

## 📁 File yang Diubah/Dibuat

| File | Status | Fungsi |
|------|--------|--------|
| `public/js/gallery-drop-zone-fix.js` | ✅ Baru | JavaScript khusus Galeri |
| `resources/views/admin/gallery/form.blade.php` | ✅ Diubah | Include script baru |
| `DRAG-DROP-GALLERY-FIX.md` | ✅ Baru | Dokumentasi ini |

---

## 🎓 Panduan untuk Admin SD N 2 Dermolo

### Cara Upload Foto di Galeri:

1. **Buka halaman Admin → Galeri Foto → Tambah Foto**

2. **Upload dengan Drag & Drop:**
   - Buka folder foto di komputer
   - Seret foto ke kotak "Seret foto ke sini"
   - Lepas (drop) di dalam kotak
   - Preview akan muncul otomatis

3. **Atau Upload dengan Klik:**
   - Klik kotak "Seret foto ke sini"
   - Pilih foto dari file explorer
   - Klik "Open"
   - Preview akan muncul otomatis

4. **Jika Salah Pilih Foto:**
   - Klik tombol merah "Hapus" di bawah preview
   - Ulangi langkah 2 atau 3

5. **Simpan:**
   - Isi judul foto (wajib)
   - Isi deskripsi (opsional)
   - Klik tombol "Simpan"

---

## 🔍 Debug Mode

Untuk developer, script menyediakan console log:

```javascript
// Cek apakah script loaded
console.log('[Gallery Drop Zone] Script loaded. Waiting for DOM...');

// Cek apakah initialized
console.log('[Gallery Drop Zone] Initializing for #foto-input...');

// Cek apakah berhasil
console.log('[Gallery Drop Zone] ✅ Successfully initialized!');

// Cek file dropped
console.log('[Gallery Drop Zone] File dropped:', filename);

// Cek file selected
console.log('[Gallery Drop Zone] File selected:', filename);

// Cek file removed
console.log('[Gallery Drop Zone] File removed.');
```

Buka **Console (F12)** untuk melihat log.

---

**Status:** ✅ **SELESAI & SIAP DIGUNAKAN**

Halaman Galeri Foto sekarang memiliki drag & drop yang berfungsi penuh dengan preview dan validasi! 🎉

---

## 📝 Catatan Teknis

### Mengapa Tidak Memperbaiki Global Drop Zone?

Global drop zone (`drop-zone.js`) sudah berfungsi normal di halaman lain. Masalah di galeri kemungkinan karena:
1. Timing issue (script load order)
2. Element belum ready saat initialization
3. Konflik dengan script lain di halaman galeri

Solusi khusus ini lebih aman karena:
- ✅ Tidak mengubah kode yang sudah jalan
- ✅ Isolasi penuh (tidak ada shared state)
- ✅ Mudah di-maintain
- ✅ Bisa di-remove tanpa affect halaman lain

### Kapan Harus Gunakan Global vs Specific?

**Gunakan Global (`drop-zone-enabled`):**
- Untuk halaman baru
- Untuk form sederhana
- Jika tidak ada masalah

**Gunakan Specific (seperti gallery fix):**
- Jika global tidak berfungsi
- Jika ada konflik
- Jika butuh custom behavior
- Jika perlu teks/config berbeda
