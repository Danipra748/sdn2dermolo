# Workflow & Planning (Ringkas, Mudah Dipahami)

## Tujuan Umum
Merapikan fitur berita, meningkatkan UX admin (CRUD), menyempurnakan UI halaman publik, dan menambah beberapa fitur baru.

## Aturan Umum Implementasi
1. Semua perubahan UI harus konsisten dengan gaya yang sudah ada (warna, radius, shadow, font).
2. Setiap aksi destructive (hapus) wajib memakai modal konfirmasi.
3. Perubahan admin dan publik harus berjalan beriringan (data masuk dari admin tampil di halaman publik).

---

# Workflow Detail Per Fitur

## 1) Berita: Hapus Section Kategori & Tambahkan Filter
**Target:** Halaman news tidak lagi punya section “Kategori Berita”, diganti filter kategori.

**Langkah:**
1. Hapus section “Kategori” pada `resources/views/news/index.blade.php`.
2. Tambahkan filter kategori di bagian pencarian:
   - Dropdown kategori.
   - Submit filter kategori.
3. Update controller `NewsController@index` agar menerima parameter `category`.
4. Pastikan filter tetap aktif saat pagination.

**Output:**
- News page menampilkan filter kategori tanpa section kategori.

---

## 2) Admin Fasilitas: Editor Konten + Pilihan Icon
**Target:** Konten detail fasilitas pakai rich text editor, icon dipilih dari dropdown/search.

**Langkah:**
1. Ganti input “Konten Detail (JSON)” menjadi rich text editor.
   - Rekomendasi editor open-source: `Trix` atau `Quill`.
2. Pastikan field disimpan sebagai HTML.
3. Ganti input icon manual menjadi dropdown searchable.
   - Rekomendasi: gunakan library icon seperti `Heroicons` atau `FontAwesome`.
4. Tambahkan pilihan icon lengkap dengan search filter.
5. Simpan icon sebagai string identifier (contoh: `heroicons:academic-cap`).

**Output:**
- Admin bisa edit konten fasilitas dengan editor visual.
- Icon dipilih dari dropdown lengkap.

---

## 3) Modal Validasi CRUD (Hapus)
**Target:** Aksi hapus selalu memakai modal konfirmasi.

**Langkah:**
1. Buat komponen modal reusable (Blade + JS).
2. Ganti semua `confirm()` di CRUD menjadi modal.
3. Pastikan konsisten di semua CRUD (guru, fasilitas, program, artikel, prestasi).

**Output:**
- UX hapus lebih rapi dan konsisten.

---

## 4) CRUD Guru: Hapus Form Absen + Layout Card
**Target:** Form guru tanpa input absen (S/I/A) dan layout dibagi per kelompok.

**Langkah:**
1. Hapus input absen dari form guru.
2. Kelompokkan field ke beberapa card:
   - Identitas Guru
   - Data Kepegawaian
   - Informasi Tambahan
3. Simpan semua field di satu form.

**Output:**
- Form lebih rapi dan mudah diisi.

---

## 5) Program Sekolah: Improve Navigasi (Tanpa Button CRUD)
**Target:** Navigasi CRUD program lebih jelas.

**Langkah:**
1. Hapus tombol CRUD umum di halaman list program.
2. Tambahkan panel navigasi per program:
   - Link “Dokumentasi Program”
3. Pastikan navigasi konsisten di admin sidebar dan halaman list.

**Output:**
- Admin hanya fokus edit dokumentasi program.

---

## 6) Artikel & News: Tambah Field Type (Berita/Artikel)
**Target:** Artikel memiliki field `type`.

**Langkah:**
1. Tambah kolom `type` di migration `articles`.
2. Update form admin untuk input type.
3. Update query di halaman publik:
   - Berita = tampil di halaman utama.
   - Artikel = tampil di halaman berita.

**Output:**
- Artikel bisa dibedakan sebagai “berita” atau “artikel”.

---

## 7) Beranda: Pindahkan Visi & Misi
**Target:** Visi & Misi berada di bawah sambutan (sejajar menyamping).

**Langkah:**
1. Pindahkan layout card Visi/Misi.
2. Pastikan tetap responsive (stack di mobile).

**Output:**
- Struktur beranda lebih rapi.

---

## 8) Program Card Thumbnail (UI)
**Target:** Thumbnail tidak bundar, mengikuti ukuran card.

**Langkah:**
1. Update CSS pada `resources/views/program/index.blade.php`.
2. Ganti class avatar bulat menjadi `w-full h-full object-cover`.

**Output:**
- Thumbnail lebih proporsional.

---

## 9) Prestasi Hero Background
**Target:** Background hero prestasi bisa diubah dari gambar.

**Langkah:**
1. Tambahkan field `hero_bg_image` di admin prestasi.
2. Simpan path gambar di DB.
3. Render background hero dengan `background-image`.

**Output:**
- Admin bisa ganti background hero prestasi.

---

## 10) Navbar Admin/Logout via Avatar
**Target:** Menu admin & logout jadi dropdown avatar.

**Langkah:**
1. Ganti link admin/logout jadi avatar button.
2. Saat klik muncul dropdown card:
   - Link ke admin panel
   - Button logout (pakai modal konfirmasi)
3. Gunakan style konsisten.

**Output:**
- Navbar lebih modern dan bersih.

---

# Planning Implementasi (Urutan)

1. Berita: hapus section kategori → tambah filter kategori.
2. Admin Fasilitas: ganti editor konten + dropdown icon.
3. Global modal konfirmasi CRUD.
4. CRUD Guru: hapus absen + redesign form card.
5. Program sekolah: navigasi CRUD fokus dokumentasi.
6. Artikel & News: tambah field type.
7. Beranda: pindahkan Visi & Misi.
8. Program card thumbnail tidak bundar.
9. Prestasi hero background editable.
10. Navbar avatar menu admin/logout.

---

# Catatan Pengujian
- Cek CRUD di admin (create, update, delete).
- Cek tampilan publik (news, program, prestasi, beranda).
- Pastikan semua tombol hapus muncul modal.

