# GALERI FOTO - FORM LENGKAP (KOLOM TUNGGAL)

## ✅ Fitur yang Sudah Diterapkan

Form galeri foto dengan layout **kolom tunggal** yang bersih dan mudah dipahami oleh admin SD N 2 Dermolo.

---

## 🎨 Tata Letak Form

### 1. **Judul Foto** (Wajib)
- Input text dengan placeholder yang jelas
- Validasi required dari Laravel
- Error message dengan icon warning

### 2. **Deskripsi (Opsional)**
- Textarea 4 baris
- Label dengan penanda "(Opsional)"
- Helper text dengan icon 💡
- Bisa dikosongkan

### 3. **Foto** (Wajib ⭐)
- Label dengan bintang merah: `<span class="text-red-500">*</span>`
- **Drag & Drop Zone** yang intuitif
- Preview gambar setelah upload
- Info file: Nama File + Ukuran
- Tombol "Hapus Foto"
- Validasi format & ukuran

---

## 📋 Struktur Kode HTML

```html
<div class="glass rounded-3xl p-6 max-w-2xl">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        
        {{-- 1. Judul Foto --}}
        <div class="space-y-1">
            <label class="block text-sm font-medium text-slate-700">
                Judul Foto
            </label>
            <input type="text" name="judul" ...>
            @error('judul')
                <p class="text-xs text-red-600 mt-1">...</p>
            @enderror
        </div>

        {{-- 2. Deskripsi (Opsional) --}}
        <div class="space-y-1">
            <label class="block text-sm font-medium text-slate-700">
                Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span>
            </label>
            <textarea name="deskripsi" ...></textarea>
            <p class="text-xs text-slate-500 mt-1">💡 Helper text...</p>
        </div>

        {{-- 3. Foto dengan Drag & Drop --}}
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700">
                Foto <span class="text-red-500">*</span>
            </label>
            
            <div id="gallery-drop-zone" class="...">
                <!-- Drop Zone Content -->
                <div id="drop-zone-content">
                    <!-- Icon + Text -->
                </div>
                
                <!-- Preview (hidden by default) -->
                <div id="gallery-preview" class="hidden">
                    <img id="preview-image" src="" ...>
                    <p><span class="font-medium">Nama File:</span> <span id="file-name">-</span></p>
                    <p><span class="font-medium">Ukuran:</span> <span id="file-size">-</span></p>
                    <button onclick="removeGalleryFile()">Hapus Foto</button>
                </div>
                
                <input type="file" id="foto-input" name="foto" class="hidden" required>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit">Simpan</button>
            <a href="...">Batal</a>
        </div>
    </form>
</div>
```

---

## 🎯 Fitur Drag & Drop

### Tampilan Sebelum Upload:
```
┌──────────────────────────────────────┐
│                                      │
│           📤 [Icon Upload]           │
│                                      │
│   Seret foto ke sini atau klik      │
│   untuk memilih                      │
│                                      │
│   Format: JPG, JPEG, PNG, WEBP      │
│   (Maks. 2MB)                        │
│                                      │
└──────────────────────────────────────┘
```

**Styling:**
- Border: 2px dashed `#CBD5E1` (abu-abu)
- Background: `#F8FAFC` (abu-abu muda)
- Hover: Border `#0EA5E9` (cyan) + background cyan muda
- Cursor: pointer

### Tampilan Saat Drag File:
```
┌──────────────────────────────────────┐
│      🟢 Border Hijau + Background    │
│                                      │
│           📤 [Icon Upload]           │
│                                      │
│   Seret foto ke sini atau klik      │
│   untuk memilih                      │
│                                      │
└──────────────────────────────────────┘
```

**Effect:**
- Border: `#10B981` (hijau)
- Background: `#F0FDF4` (hijau muda)
- Transform: scale up sedikit

### Tampilan Setelah Upload:
```
┌──────────────────────────────────────┐
│                                      │
│      [Thumbnail Preview Gambar]      │
│                                      │
└──────────────────────────────────────┘

┌──────────────────────────────────────┐
│ Nama File: dani.png                  │
│ Ukuran: 1.2 MB                       │
└──────────────────────────────────────┘

[🗑️ Hapus Foto]
```

**Preview:**
- Max-height: 16rem (256px)
- Rounded corners
- Box shadow
- Border hijau menandakan file valid

---

## 🔧 JavaScript Functions

### 1. **validateFile(file)**
Validasi format dan ukuran file:
```javascript
const config = {
    acceptedTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'],
    maxSize: 2 * 1024 * 1024, // 2MB
};

function validateFile(file) {
    if (!config.acceptedTypes.includes(file.type)) {
        return { valid: false, message: 'Format tidak didukung' };
    }
    if (file.size > config.maxSize) {
        return { valid: false, message: 'Ukuran terlalu besar' };
    }
    return { valid: true };
}
```

### 2. **handleFile(file)**
Menangani file yang dipilih/di-drop:
```javascript
function handleFile(file) {
    const validation = validateFile(file);
    if (!validation.valid) {
        showError(validation.message);
        return false;
    }

    // Set file ke input
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    fileInput.files = dataTransfer.files;

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        previewImage.src = e.target.result;
        galleryPreview.classList.remove('hidden');
        dropZoneContent.classList.add('hidden');
    };
    reader.readAsDataURL(file);

    // Show file info
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    
    return true;
}
```

### 3. **removeGalleryFile()**
Menghapus file yang sudah dipilih:
```javascript
window.removeGalleryFile = function() {
    fileInput.value = '';
    previewImage.src = '';
    galleryPreview.classList.add('hidden');
    dropZoneContent.classList.remove('hidden');
    hideError();
};
```

### 4. **showError(message)**
Menampilkan pesan error:
```javascript
function showError(message) {
    galleryError.textContent = message;
    galleryError.classList.remove('hidden');
    
    setTimeout(() => {
        galleryError.classList.add('hidden');
    }, 5000); // Auto-hide setelah 5 detik
}
```

---

## 📂 Controller Laravel

**File:** `app/Http/Controllers/AdminGalleryController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function create()
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia.');
        }

        return view('admin.gallery.form', [
            'gallery' => new Gallery(),
            'action' => route('admin.gallery.store'),
            'method' => 'POST',
            'title' => 'Tambah Foto Galeri',
        ]);
    }

    public function store(Request $request)
    {
        if (!$this->hasRequiredTables()) {
            return redirect()->route('admin.dashboard')
                ->with('status', 'Tabel galeri belum tersedia.');
        }

        $data = $this->validateGallery($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('gallery', 'public');
        }

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin.gallery.form', [
            'gallery' => $gallery,
            'action' => route('admin.gallery.update', $gallery),
            'method' => 'PUT',
            'title' => 'Edit Foto Galeri',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);
        $data = $this->validateGallery($request);

        if ($request->hasFile('foto')) {
            if ($gallery->foto) {
                Storage::disk('public')->delete($gallery->foto);
            }
            $data['foto'] = $request->file('foto')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('status', 'Foto galeri berhasil diperbarui.');
    }

    private function validateGallery(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function hasRequiredTables(): bool
    {
        return Schema::hasTable('galleries');
    }
}
```

---

## 🗄️ Database Structure

**Migration:** `database/migrations/xxxx_xx_xx_create_galleries_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('foto'); // Path ke file gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
```

**Model:** `app/Models/Gallery.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
    ];
}
```

---

## 🎨 Styling Classes

### Label Wajib (Foto):
```html
<label class="block text-sm font-medium text-slate-700">
    Foto <span class="text-red-500">*</span>
</label>
```

### Drop Zone:
```css
/* Default State */
border: 2px dashed #CBD5E1;
background: #F8FAFC;
border-radius: 12px;
padding: 1.5rem;

/* Hover State */
hover:border-cyan;
hover:bg-cyan-50;

/* Drag Over State */
border-green-500;
bg-green-100;

/* Has File State */
border-green-500;
bg-green-50;
```

### Preview Container:
```css
max-height: 16rem; /* 256px */
border-radius: 12px;
object-fit: cover;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
```

### File Info Card:
```css
background: white;
border-radius: 8px;
padding: 0.75rem 1rem;
border: 1px solid #E2E8F0;
```

---

## ✅ Validasi Laravel

```php
return $request->validate([
    'judul' => [
        'required',        // Wajib diisi
        'string',          // Harus string
        'max:255'          // Max 255 karakter
    ],
    'deskripsi' => [
        'nullable',        // Boleh kosong
        'string'           // Harus string
    ],
    'foto' => [
        'required',        // Wajib diisi (saat create)
        'image',           // Harus gambar
        'mimes:jpg,jpeg,png,webp',  // Format yang diterima
        'max:2048'         // Max 2MB (dalam KB)
    ],
]);
```

---

## 🚀 Cara Penggunaan

### Untuk Admin SD N 2 Dermolo:

1. **Buka halaman:** Admin → Galeri Foto → Tambah Foto
2. **Isi Judul Foto** (wajib)
3. **Isi Deskripsi** (opsional, boleh dikosongkan)
4. **Upload Foto:**
   - **Cara 1 (Drag & Drop):** Seret foto dari folder ke kotak upload
   - **Cara 2 (Klik):** Klik kotak upload → pilih foto → Open
5. **Preview muncul** dengan info:
   - Nama File: `dani.png`
   - Ukuran: `1.2 MB`
6. **Jika salah pilih:** Klik tombol "Hapus Foto"
7. **Klik "Simpan"**

---

## 📸 Contoh Tampilan Lengkap

```
┌────────────────────────────────────────────┐
│  Form Tambah Foto Galeri                   │
├────────────────────────────────────────────┤
│                                            │
│  Judul Foto                                │
│  ┌────────────────────────────────────┐   │
│  │ Kegiatan Upacara Bendera 2024     │   │
│  └────────────────────────────────────┘   │
│                                            │
│  Deskripsi (Opsional)                      │
│  ┌────────────────────────────────────┐   │
│  │ Upacara bendera dalam rangka       │   │
│  │ peringatan HUT RI ke-79 yang       │   │
│  │ diikuti oleh seluruh siswa...     │   │
│  └────────────────────────────────────┘   │
│  💡 Isi deskripsi untuk memberikan...     │
│                                            │
│  Foto *                                    │
│  ┌────────────────────────────────────┐   │
│  │                                    │   │
│  │      [Preview Gambar Muncul]      │   │
│  │                                    │   │
│  └────────────────────────────────────┘   │
│  ┌────────────────────────────────────┐   │
│  │ Nama File: upacara-2024.jpg        │   │
│  │ Ukuran: 1.5 MB                    │   │
│  └────────────────────────────────────┘   │
│  [🗑️ Hapus Foto]                          │
│                                            │
│  ┌────────────────┐  ┌────────────────┐   │
│  │ ✓ Simpan       │  │ Batal          │   │
│  └────────────────┘  └────────────────┘   │
│                                            │
└────────────────────────────────────────────┘
```

---

## 🐛 Troubleshooting

### Drop Zone Tidak Berfungsi
1. Buka Console (F12)
2. Cek error JavaScript
3. Pastikan script dimuat dengan benar
4. Refresh halaman (Ctrl+F5)

### Preview Tidak Muncul
1. Pastikan file adalah gambar (JPG/PNG/WEBP)
2. Cek ukuran file (max 2MB)
3. Lihat pesan error di bawah drop zone

### Validasi Gagal
1. Pastikan judul diisi
2. Pastikan foto dipilih (saat create)
3. Format file harus JPG/JPEG/PNG/WEBP
4. Ukuran file max 2MB

---

## 📝 Catatan Penting

### Kenapa Tidak Pakai Global Drop Zone?

Form ini menggunakan **JavaScript inline** karena:
- ✅ Lebih mudah di-maintain
- ✅ Tidak ada konflik dengan script lain
- ✅ Preview dan info file lebih terintegrasi
- ✅ Error handling lebih baik
- ✅ Semua dalam satu file

### Label Bintang Merah

Dirender dengan benar menggunakan:
```php
Foto {{ $method === 'POST' ? '<span class="text-red-500">*</span>' : '' }}
```

Atau langsung di Blade:
```html
<label class="block text-sm font-medium text-slate-700">
    Foto <span class="text-red-500">*</span>
</label>
```

---

**Status:** ✅ **SELESAI & SIAP DIGUNAKAN**

Form galeri foto dengan layout kolom tunggal yang bersih dan lengkap sudah siap digunakan oleh admin SD N 2 Dermolo! 🎉
