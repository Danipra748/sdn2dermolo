# Plan 01: Foundations & Design System

## 🎯 Fokus
Membangun fondasi desain ala Shadcn UI dan library komponen Blade yang dapat digunakan kembali di seluruh aplikasi.

## 🎨 Spesifikasi Visual
- **Tipografi**: Plus Jakarta Sans (Utama), Inter (Fallback).
- **Warna**: Palet neutral Zinc/Slate (`slate-950` untuk sidebar, `slate-50` untuk background, `white` untuk card).
- **Sistem Border**: `border-slate-200` dengan radius `rounded-xl` atau `rounded-2xl` yang konsisten.

## 🧱 Komponen Blade (`resources/views/components/admin/`)
Setiap komponen harus mendukung atribut fleksibel (`@props` dan `$attributes`):

1.  **`button.blade.php`**: Mendukung varian:
    - `primary` (Black/Dark Zinc)
    - `secondary` (Slate light)
    - `outline` (Transparent border)
    - `destructive` (Red for delete)
    - `ghost` (No background)
2.  **`stat-card.blade.php`**: Kartu metrik dengan ikon dan label ringkas.
3.  **`page-header.blade.php`**: Wrapper untuk judul halaman, sub-judul, dan tombol aksi utama.
4.  **`form-group.blade.php`**: Merapikan label, input, dan pesan error dalam satu kesatuan.
5.  **`badge.blade.php`**: Indikator status (Published, Draft, Active) dengan warna lembut.

## ✅ Acceptance Criteria
- Komponen harus bersifat "headless" (tidak terikat logika bisnis).
- Desain harus mobile-friendly (font-size adaptif).
