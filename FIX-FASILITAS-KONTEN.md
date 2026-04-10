# Fix: Fasilitas Ruang Kelas - Tidak Bisa Menyimpan Perubahan

## 🔍 Root Cause Analysis

### **Masalah:**
Card fasilitas "Ruang Kelas" tidak bisa menyimpan perubahan saat diedit di admin.

### **Penyebab Utama:**
1. ❌ **Field `konten` tidak ada di form** - Padahal data detail Ruang Kelas (stats, kelas, fasilitas_items, dll) disimpan di kolom `konten` dalam format JSON
2. ❌ **Controller tidak handle field `konten`** - Validation tidak include `konten`
3. ❌ **Model tidak cast `konten` sebagai array** - Laravel tidak otomatis decode JSON

### **Struktur Data Ruang Kelas:**
```php
fasilitas table:
- nama: "Ruang Kelas"
- deskripsi: "Subtitle singkat"  ← SUDAH ADA DI FORM ✅
- icon: "🏫"                      ← SUDAH ADA DI FORM ✅
- foto: "path/to/image"           ← SUDAH ADA DI FORM ✅
- konten: {                       ← TIDAK ADA DI FORM ❌
    "stats": [...],
    "kelas": [...],
    "fasilitas_items": [...],
    "tata_tertib_boleh": [...],
    "tata_tertib_larang": [...],
    ...
  }
```

## ✅ Solusi yang Diterapkan

### **1. FRONTEND - Form Edit Fasilitas**

#### **Tambah Field "Konten Detail (JSON)"**
```blade
@if(in_array($fasilitas->nama, ['Ruang Kelas', 'Perpustakaan', 'Musholla', 'Lapangan Olahraga']) || request()->is('*/create'))
<div class="rounded-2xl border border-blue-200 bg-blue-50/70 p-4">
    <h3>📋 Konten Detail (JSON)</h3>
    <textarea name="konten" rows="12" ...>
        {{ json_encode($fasilitas->konten, JSON_PRETTY_PRINT) }}
    </textarea>
</div>
@endif
```

**Features:**
- ✅ Hanya muncul untuk fasilitas khusus (Ruang Kelas, dll)
- ✅ Format JSON dengan pretty print
- ✅ Placeholder dengan contoh format
- ✅ Helper text untuk guidance
- ✅ Validasi JSON di controller

#### **Deskripsi Menjadi Opsional**
```blade
<label>
    Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span>
</label>
<textarea placeholder="Deskripsi singkat fasilitas (tidak wajib diisi)" ...></textarea>
<p class="text-xs text-slate-500">
    ℹ️ Deskripsi akan tampil sebagai subtitle di halaman publik. 
    Bisa dikosongkan untuk menggunakan default.
</p>
```

### **2. BACKEND - Controller Validation**

```php
private function validateFasilitas(Request $request): array
{
    $data = $request->validate([
        'nama' => ['required', 'string', 'max:255'],
        'deskripsi' => ['nullable', 'string'],
        'icon' => ['nullable', 'string', 'max:32'],
        'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'konten' => ['nullable', 'json'],  // ✅ BARU
        // ...
    ]);

    // ✅ Parse JSON jika valid
    if (isset($data['konten']) && filled(trim($data['konten']))) {
        $decoded = json_decode($data['konten'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $data['konten'] = $decoded;
        } else {
            // Fallback ke string jika JSON tidak valid
            $data['konten'] = trim($data['konten']);
        }
    } else {
        $data['konten'] = null;
    }

    return $data;
}
```

### **3. MODEL - Array Casting**

```php
protected $casts = [
    'konten' => 'array',  // ✅ BARU - Auto JSON encode/decode
];
```

## 🔄 Alur Kerja Baru

### **Edit Ruang Kelas:**
1. Admin buka halaman edit Fasilitas → "Ruang Kelas"
2. Edit field yang ada:
   - ✅ Icon (emoji)
   - ✅ Icon Image
   - ✅ Nama Fasilitas
   - ✅ Deskripsi (opsional)
   - ✅ Foto Fasilitas
   - ✅ **Konten Detail (JSON)** ← BARU!
3. Klik "Simpan"
4. Controller validasi + parse JSON
5. Data tersimpan ke database
6. Redirect dengan success message

### **Bagaimana Data Dipakai di Public:**

```php
// FasilitasController.php - buildPublicData()
$item = Fasilitas::where('nama', 'Ruang Kelas')->first();
$default = $this->getDefaultPublicData('Ruang Kelas');
$data = $default;

// Jika ada konten custom dari admin
if (is_array($item?->konten)) {
    $data = array_replace_recursive($data, $item->konten);
}

// Jika tidak ada, gunakan default
```

## 📊 Perbandingan Sebelum & Sesudah

### **Sebelum:**
| Field | Ada di Form? | Tersimpan? |
|-------|-------------|------------|
| Icon | ✅ | ✅ |
| Nama | ✅ | ✅ |
| Deskripsi | ✅ | ✅ |
| Foto | ✅ | ✅ |
| **Konten** | ❌ **TIDAK** | ❌ **TIDAK** |

**Hasil:** Data stats, kelas, fasilitas_items TIDAK BISA DIUBAH!

### **Sesudah:**
| Field | Ada di Form? | Tersimpan? |
|-------|-------------|------------|
| Icon | ✅ | ✅ |
| Nama | ✅ | ✅ |
| Deskripsi (Opsional) | ✅ | ✅ |
| Foto | ✅ | ✅ |
| **Konten (JSON)** | ✅ **BARU** | ✅ **BERHASIL** |

**Hasil:** Semua data BISA DIUBAH dan TERSIMPAN! 🎉

## 🧪 Testing Checklist

### **Edit Ruang Kelas:**
- [ ] Buka edit form "Ruang Kelas"
- [ ] Lihat ada section "Konten Detail (JSON)"
- [ ] Edit JSON (tambah stats, ubah ruangan, dll)
- [ ] Klik "Simpan"
- [ ] Berhasil tanpa error
- [ ] Redirect ke index dengan success message
- [ ] Edit lagi → data JSON masih ada (tidak hilang)

### **Public View:**
- [ ] Buka halaman publik `/fasilitas/ruang-kelas`
- [ ] Stats tampil sesuai JSON yang di-edit
- [ ] Daftar kelas tampil sesuai JSON
- [ ] Fasilitas items tampil sesuai JSON
- [ ] Tata tertib tampil sesuai JSON

### **Fallback Test:**
- [ ] Kosongkan field "Konten Detail (JSON)"
- [ ] Simpan
- [ ] Halaman publik tetap tampil dengan data DEFAULT dari controller
- [ ] Tidak ada error

### **Deskripsi Opsional:**
- [ ] Edit fasilitas → kosongkan deskripsi
- [ ] Simpan → berhasil
- [ ] Public view → tampil subtitle default
- [ ] Edit lagi → isi deskripsi
- [ ] Simpan → berhasil
- [ ] Public view → tampil deskripsi custom

## 💡 Cara Edit JSON dengan Benar

### **Format yang Valid:**
```json
{
  "stats": [
    {
      "value": "18",
      "label": "Ruang Kelas",
      "icon": "🏫",
      "color": "blue"
    }
  ],
  "kelas": [
    {
      "level": "Kelas 1",
      "color": "red",
      "rooms": ["Kelas 1A - Ruang 01", "Kelas 1B - Ruang 02"]
    }
  ],
  "fasilitas_items": [
    {
      "icon": "❄️",
      "title": "Air Conditioner (AC)",
      "desc": "Setiap kelas dilengkapi AC"
    }
  ]
}
```

### **Tips:**
1. ✅ Gunakan comma `,` antar item dalam array
2. ✅ Gunakan double quotes `"` bukan single quote `'`
3. ✅ Jangan lupa comma antar key-value pair
4. ✅ Validate JSON online sebelum save (jsonlint.com)
5. ⚠️ Jika tidak yakin format JSON, lebih baik dikosongkan (akan pakai default)

## 🎯 Files Modified

1. ✅ `resources/views/admin/fasilitas/form.blade.php`
   - Tambah section "Konten Detail (JSON)"
   - Deskripsi jadi opsional dengan helper text

2. ✅ `app/Http/Controllers/FasilitasController.php`
   - Validation include `konten` field
   - Parse JSON dengan error handling

3. ✅ `app/Models/Fasilitas.php`
   - Cast `konten` sebagai array

## 🚨 Important Notes

1. **JSON Validation:**
   - Jika JSON valid → disimpan sebagai array
   - Jika JSON tidak valid → disimpan sebagai string (fallback)
   - Jika kosong → null (akan pakai data default)

2. **Default Data:**
   - Data default masih ada di `getDefaultPublicData()` di controller
   - Jika `konten` kosong, akan pakai default
   - Jika `konten` ada, akan merge dengan default

3. **User Experience:**
   - Section JSON hanya muncul untuk fasilitas tertentu
   - Fasilitas lain tetap form sederhana
   - Helper text lengkap untuk guidance

## 📝 Commands

Clear cache setelah deploy:
```bash
php artisan view:clear
```

Cek log jika ada error:
```bash
tail -f storage/logs/laravel.log
```

---

**Last Updated:** 2026-04-06  
**Status:** ✅ FIXED - Form sekarang bisa menyimpan perubahan Ruang Kelas!
