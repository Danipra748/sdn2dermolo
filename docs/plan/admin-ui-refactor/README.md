# 🚀 Master Plan: Admin UI/UX Modernization

## 📋 Overview
Project ini bertujuan untuk merombak total tampilan Admin Panel SD N 2 Dermolo menjadi lebih modern (Shadcn UI Like), interaktif, dan fleksibel di semua perangkat (Desktop & Mobile).

## 📂 Daftar Rencana Terfokus
Silakan jalankan implementasi berdasarkan urutan berikut:

1.  [**Fondasi & Desain Sistem**](./01-foundations.md)
    *   *Output*: Komponen Blade reusable (Button, Card, Header, dll).
2.  [**Dashboard & Data Insights**](./02-dashboard-refactor.md)
    *   *Output*: Penghapusan Aksi Cepat, Grafik Chart.js, Ringkasan Data.
3.  [**Smart Data Table**](./03-data-table-component.md)
    *   *Output*: Tabel dengan pencarian real-time dan responsive horizontal scroll.
4.  [**Standardisasi CRUD**](./04-crud-standardization.md)
    *   *Output*: Migrasi seluruh modul ke komponen baru, Modal Confirm, & Toasts.

## 🛠️ Prinsip Utama
- **DRY (Don't Repeat Yourself)**: Gunakan komponen untuk elemen berulang.
- **Mobile First**: Pastikan tabel dan form nyaman digunakan di HP.
- **Performance**: Gunakan JavaScript minimal (Vanilla JS) untuk menjaga kecepatan loading.

## 🏁 Goal Akhir
Admin memiliki alat manajemen sekolah yang stabil, indah dilihat, dan sangat mudah digunakan bahkan oleh orang awam melalui perangkat mobile.
