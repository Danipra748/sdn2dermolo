<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageSection;

class HomepageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'hero',
                'section_name' => 'Hero Section',
                'is_active' => true,
                'display_order' => 1,
                'title' => 'SD N 2 Dermolo',
                'subtitle' => 'Unggul & Berkarakter',
                'description' => 'Sekolah Dasar Negeri 2 Dermolo berkomitmen memberikan pendidikan berkualitas tinggi.',
                'background_overlay_opacity' => 0.35,
                'extra_data' => json_encode([
                    'badge_text' => 'Selamat Datang',
                    'show_buttons' => true,
                    'primary_button_text' => 'Jelajahi',
                    'secondary_button_text' => 'Kontak',
                ]),
            ],
            [
                'section_key' => 'about',
                'section_name' => 'Tentang Kami',
                'is_active' => true,
                'display_order' => 2,
                'title' => 'Tentang Kami',
                'subtitle' => 'Mengenal SD N 2 Dermolo',
                'description' => 'SD N 2 Dermolo adalah lembaga pendidikan dasar yang berkomitmen memberikan pendidikan berkualitas tinggi bagi generasi muda Indonesia.',
                'extra_data' => json_encode([
                    'vision' => 'Menjadi sekolah unggulan yang berkarakter.',
                    'mission_points' => [
                        'Menyelenggarakan pendidikan berkualitas',
                        'Mengembangkan karakter siswa',
                        'Menciptakan lingkungan belajar yang nyaman'
                    ],
                ]),
            ],
            [
                'section_key' => 'stats',
                'section_name' => 'Statistik Sekolah',
                'is_active' => true,
                'display_order' => 3,
                'title' => 'Statistik',
                'subtitle' => 'Capaian Sekolah',
                'extra_data' => json_encode([
                    'stats' => [
                        ['label' => 'Siswa', 'value' => '150', 'icon' => 'heroicon-o-academic-cap'],
                        ['label' => 'Guru', 'value' => '25', 'icon' => 'heroicon-o-user-group'],
                        ['label' => 'Fasilitas', 'value' => '12', 'icon' => 'heroicon-o-building-library'],
                        ['label' => 'Program', 'value' => '8', 'icon' => 'heroicon-o-light-bulb'],
                    ]
                ]),
            ],
            [
                'section_key' => 'programs',
                'section_name' => 'Program Sekolah',
                'is_active' => true,
                'display_order' => 4,
                'title' => 'Program Sekolah',
                'subtitle' => 'Ekstrakurikuler Unggulan',
                'description' => 'Program-program yang mendukung pengembangan bakat dan karakter siswa.',
            ],
            [
                'section_key' => 'teachers',
                'section_name' => 'Guru & Tenaga Pendidik',
                'is_active' => true,
                'display_order' => 5,
                'title' => 'Guru & Tenaga Pendidik',
                'subtitle' => 'Profesional Berdedikasi',
                'description' => 'Tim pendidik profesional yang siap membimbing putra-putri Anda.',
            ],
            [
                'section_key' => 'facilities',
                'section_name' => 'Fasilitas Sekolah',
                'is_active' => true,
                'display_order' => 6,
                'title' => 'Fasilitas Sekolah',
                'subtitle' => 'Fasilitas Modern & Lengkap',
                'description' => 'Fasilitas pembelajaran yang modern dan lengkap untuk mendukung proses belajar.',
            ],
            [
                'section_key' => 'news',
                'section_name' => 'Berita & Artikel',
                'is_active' => true,
                'display_order' => 7,
                'title' => 'Berita Terbaru',
                'subtitle' => 'Kegiatan & Cerita Sekolah',
                'description' => 'Update kegiatan, prestasi, dan cerita inspiratif dari lingkungan sekolah.',
            ],
            [
                'section_key' => 'contact',
                'section_name' => 'Kontak',
                'is_active' => true,
                'display_order' => 8,
                'title' => 'Hubungi Kami',
                'subtitle' => 'Kami Siap Melayani',
                'description' => 'Jangan ragu untuk menghubungi kami kapan saja.',
            ],
        ];

        foreach ($sections as $section) {
            HomepageSection::create($section);
        }
    }
}
