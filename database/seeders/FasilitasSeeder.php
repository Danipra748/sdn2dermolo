<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = [
            [
                'nama' => 'Ruang Kelas',
                'deskripsi' => 'Ruang belajar nyaman dilengkapi fasilitas mendukung proses pembelajaran',
                'icon' => '',
                'warna' => 'blue',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Perpustakaan',
                'deskripsi' => 'Tempat membaca nyaman dengan koleksi buku lengkap siswa',
                'icon' => '',
                'warna' => 'green',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Musholla',
                'deskripsi' => 'Tempat ibadah bersih untuk shalat dan kegiatan keagamaan',
                'icon' => '',
                'warna' => 'purple',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lapangan Olahraga',
                'deskripsi' => 'Area luas untuk olahraga, upacara, dan aktivitas fisik siswa',
                'icon' => '',
                'warna' => 'orange',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($fasilitas as $item) {
            // Cek apakah sudah ada, jika belum maka insert
            if (!DB::table('fasilitas')->where('nama', $item['nama'])->exists()) {
                DB::table('fasilitas')->insert($item);
            }
        }
    }
}
