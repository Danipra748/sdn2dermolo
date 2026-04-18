# Plan 02: Dashboard & Data Insights

## 🎯 Fokus
Menghapus "Aksi Cepat" dan menggantinya dengan informasi strategis berbasis data dan grafik interaktif.

## 📊 Statistik & Chart
- **Chart.js Implementation**: Integrasi library Chart.js yang ringan.
- **Data Points**:
    - Grafik "Kunjungan Berita": Menghitung `ArticleView`.
    - Grafik "Pesan Masuk": Tren 7 hari terakhir.
- **Top Metrics**:
    - Total Berita (Published vs Draft).
    - Status PPDB (Waktu tersisa/Jumlah Pendaftar jika ada).
    - Data Guru & Fasilitas.

## 📱 Mobile Layout
- Statistik utama harus tampil 1 kolom di mobile dan 4 kolom di desktop.
- Chart harus *responsive* (aspek rasio otomatis menyesuaikan lebar layar).

## 🛠️ Logic Update
- Refaktorisasi `AdminController` untuk menghitung data grafik sebelum dikirim ke view.
