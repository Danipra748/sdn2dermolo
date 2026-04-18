# Plan 03: Smart Data Table Component

## 🎯 Fokus
Menciptakan komponen tabel yang "cerdas" dengan fitur pencarian real-time untuk mempermudah manajemen data massal.

## ⚙️ Fitur Komponen (`<x-admin.data-table>`)
1.  **Real-time Search (Client-side)**: Input teks yang memfilter baris tabel secara otomatis menggunakan JavaScript ringan (tanpa reload).
2.  **Empty State**: Tampilan ilustrasi dan teks jika hasil pencarian tidak ditemukan atau data memang kosong.
3.  **Action Slots**: Area khusus di setiap baris untuk tombol Edit, Hapus, dan View.
4.  **Responsive Mode**:
    - Desktop: Tabel standar yang spacious.
    - Mobile: `overflow-x-auto` yang rapi dengan indikator scroll.

## 📜 JavaScript Logic
- Script pencarian yang reusable dan bisa menargetkan kolom spesifik atau seluruh kolom.
- Mendukung filter tambahan (misal: filter berdasarkan kategori pada tabel Berita).
