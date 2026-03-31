# Planning Update 1

Tujuan: merapikan UI/UX beranda dan komponen terkait, menstandarkan ikon, serta memastikan fungsionalitas filter berita dan menu aktif navbar.

## Ruang Lingkup
1. Ganti seluruh emoji/icon inline dengan package ikon yang konsisten.
2. Rapikan grid card Program Sekolah di beranda agar rapi dan konsisten.
3. Perbaiki filter Berita (kategori: Berita, Artikel) agar jelas dan fungsional.
4. Pastikan menu aktif navbar fleksibel dan benar sesuai halaman/anchor.
5. Sembunyikan NIP pada daftar guru & tenaga pendidik di publik.
6. Rapikan tampilan card Berita di beranda agar konsisten UI/UX.
7. Redesain Fasilitas Sekolah: grid responsif, card gambar 16:9 dengan judul di bawah gambar (overlay shadow), dan modal detail yang responsif.

## Rencana Pekerjaan
1. Audit penggunaan emoji/icon di view publik (beranda, navbar, section lain) dan tentukan package ikon yang akan dipakai.
2. Integrasikan package ikon secara global (layout/app) dan ganti semua emoji/icon ke komponen ikon yang baru.
3. Beranda: perbaiki grid Program Sekolah (layout, spacing, tinggi card) agar konsisten.
4. Beranda: rapikan list Berita (grid, tinggi gambar, teks ringkas, jarak/typography).
5. Berita: implementasi filter kategori (UI jelas + logika filter) dan pastikan kategori “Berita” dan “Artikel” bekerja.
6. Navbar: perbaiki state aktif (berdasar route & anchor) agar fleksibel untuk halaman/section.
7. Guru: hilangkan NIP dari tampilan publik (list & detail yang tampil di beranda).
8. Fasilitas: redesign card 16:9 + judul overlay; tambah modal detail responsif saat card diklik.
9. Final pass: konsistensi UI/UX (spacing, warna, hover) dan cek responsif.

## Output/Deliverables
- Perubahan pada `resources/views/layouts/app.blade.php` untuk ikon dan navbar aktif.
- Perubahan pada `resources/views/home.blade.php` untuk Program, Berita, Guru, Fasilitas.
- Perubahan pada tampilan Berita dan Fasilitas (view terkait).
- Modal fasilitas (markup + CSS + JS).

## Catatan
- Hindari emoji di UI publik.
- Gunakan satu set ikon konsisten di seluruh halaman.
- Pastikan semua perubahan tetap responsif (mobile–desktop).
