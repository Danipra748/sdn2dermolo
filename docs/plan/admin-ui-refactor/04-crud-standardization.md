# Plan 04: CRUD Standardization & Interaction

## 🎯 Fokus
Migrasi seluruh modul CRUD (Guru, Fasilitas, Berita, dll.) ke sistem komponen baru untuk mencapai konsistensi 100%.

## 🏗️ Pola Halaman
1.  **Index**: Menggunakan `<x-admin.page-header>` dan `<x-admin.data-table>`.
2.  **Create/Edit**:
    - Layout 1 kolom atau 2 kolom (Sidebar Form) yang interaktif.
    - Preview gambar real-time (saat admin memilih file).
    - Sticky footer untuk tombol simpan di mobile agar jempol mudah menjangkau.

## ⚠️ Konfirmasi & Notifikasi
- **Global Modal Confirm**: Mengganti `confirm()` browser yang membosankan dengan modal kustom Shadcn yang cantik.
- **Auto-dismissing Toasts**: Notifikasi "Berhasil Disimpan" yang muncul di pojok kanan atas dan menghilang otomatis.

## 🛠️ Modul yang Terdampak
- Data Guru & Staf
- Sarana & Prasarana
- Berita & Artikel
- Galeri Foto
- Prestasi Sekolah
- Program Sekolah
