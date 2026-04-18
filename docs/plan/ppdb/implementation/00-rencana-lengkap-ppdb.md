# Rencana Lengkap Pengembangan Sistem PPDB Hybrid
**SD N 2 Dermolo**

Rencana ini merinci pembangunan sistem Penerimaan Peserta Didik Baru (PPDB) yang menggabungkan keandalan Google Form dengan antarmuka website yang premium, otomatis, dan interaktif.

---

## 1. Arsitektur Sistem & Database
Sistem akan berjalan secara otomatis berdasarkan pengaturan waktu yang diinput oleh Admin.

### Skema Database:
- **Tabel `ppdb_settings`**: Menyimpan konfigurasi global.
    - `start_date` & `end_date`: Waktu mulai dan berakhir (DateTime).
    - `form_url`: Link Google Form pendaftaran.
- **Tabel `ppdb_banners`**: Menyimpan aset promosi.
    - `image_path`: Lokasi file gambar banner.
    - `title`: Judul banner (opsional).
    - `order`: Urutan tampilan.
    - `is_active`: Status aktif banner.

---

## 2. Logika "Time-Gate" (Otomatisasi Status)
Sistem tidak lagi menggunakan toggle manual "Aktif/Nonaktif". Status akan dihitung secara *real-time* oleh server dan client.

### 4 Tahapan Status:
1.  **⏳ Segera Dimulai (Waiting)**: `Waktu Sekarang < Waktu Mulai`.
2.  **🟢 Pendaftaran Dibuka (Open)**: `Waktu Mulai <= Waktu Sekarang <= Waktu Selesai`.
3.  **⚠️ Segera Ditutup (Closing Soon)**: `Waktu Selesai - Waktu Sekarang <= 24 Jam`.
4.  **🔴 Pendaftaran Ditutup (Closed)**: `Waktu Sekarang > Waktu Selesai`.

---

## 3. Desain Karakter Maskot & Visual (Aesthetics)
Halaman PPDB akan menggunakan karakter maskot siswa SD dalam bentuk **Inline SVG** agar ringan dan dapat dianimasikan secara halus.

### Ilustrasi Karakter per Status:
- **Waiting**: Karakter sedang melihat jam dinding besar dengan ekspresi antusias (Animasi: Jam berdetak).
- **Open**: Karakter melambai dengan ceria sambil memegang pensil raksasa (Animasi: Melambai & Mengapung).
- **Closing Soon**: Karakter dalam pose mengingatkan dengan ikon jam pasir merah (Animasi: Berdenyut/Pulse).
- **Closed**: Karakter melambai tangan dengan pose istirahat (Animasi: Hitam-putih halus/Grayscale).

### Desain Layout:
- **Responsif**: Desktop tampil **Horizontal** (Teks di kiri, Maskot/Banner di kanan), Mobile tampil **Vertikal**.
- **Rounded UI**: Menggunakan `rounded-[3rem]` untuk estetika modern dan ramah anak.
- **Micro-interactions**: Efek `hover` yang mengangkat kartu (lift-up) dan bayangan lembut.

---

## 4. Antarmuka Admin (Mission Control)
Admin memiliki kendali penuh melalui dasbor khusus yang sudah terintegrasi di sidebar.

- **Pengaturan Jadwal**: Input tanggal dan jam menggunakan picker yang intuitif.
- **Validasi Ketat**: Sistem akan menolak jika `Waktu Selesai` diinput sebelum `Waktu Mulai`.
- **Manajemen Banner**: CRUD banner dengan fitur *reorder* dan *toggle visibility*.
- **Real-time Status Badge**: Admin dapat melihat status PPDB saat ini di dasbor tanpa perlu refresh.

---

## 5. Integrasi Pendaftaran & Keamanan
Pendaftaran dilakukan melalui halaman khusus `/ppdb/daftar` yang memuat Google Form.

- **Seamless Embed**: Menggunakan `<iframe>` dengan kontainer yang dioptimalkan untuk mobile.
- **Session Monitor**: Jika user sedang mengisi form dan waktu berakhir (deadline lewat), sistem akan otomatis memunculkan **Modal Informasi** bertuliskan "Waktu Habis" dan menutup akses formulir.
- **Backend Protection**: Route pendaftaran akan memvalidasi waktu di sisi server sebelum merender konten.

---

## 6. Langkah Implementasi
1.  **Backend**: Finalisasi migrasi dan logika model `PpdbSetting` (Sudah selesai sebagian).
2.  **SPA Engine**: Update `spa.js` untuk menangani transisi status otomatis tanpa refresh.
3.  **Aset Visual**: Penulisan kode SVG maskot langsung ke dalam Blade template.
4.  **Styling**: Penerapan utility Tailwind untuk layout horizontal/vertikal dan sudut membulat.
5.  **Final QC**: Uji coba perpindahan status dari Menunggu -> Dibuka secara otomatis.
