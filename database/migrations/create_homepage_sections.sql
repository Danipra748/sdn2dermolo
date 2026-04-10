-- Migration for homepage_sections table
-- Run this in phpMyAdmin or MySQL CLI

CREATE TABLE IF NOT EXISTS `homepage_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_overlay_opacity` decimal(3,2) NOT NULL DEFAULT '0.40',
  `extra_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homepage_sections_section_key_unique` (`section_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed data for homepage_sections
INSERT INTO `homepage_sections` (`section_key`, `section_name`, `is_active`, `display_order`, `title`, `subtitle`, `description`, `background_overlay_opacity`, `extra_data`, `created_at`, `updated_at`) VALUES
('hero', 'Hero Section', 1, 1, 'SD N 2 Dermolo', 'Unggul & Berkarakter', 'Sekolah Dasar Negeri 2 Dermolo berkomitmen memberikan pendidikan berkualitas tinggi.', 0.35, '{\"badge_text\":\"Selamat Datang\",\"show_buttons\":true,\"primary_button_text\":\"Jelajahi\",\"secondary_button_text\":\"Kontak\"}', NOW(), NOW()),
('about', 'Tentang Kami', 1, 2, 'Tentang Kami', 'Mengenal SD N 2 Dermolo', 'SD N 2 Dermolo adalah lembaga pendidikan dasar yang berkomitmen memberikan pendidikan berkualitas tinggi bagi generasi muda Indonesia.', 0.40, '{\"vision\":\"Menjadi sekolah unggulan yang berkarakter.\",\"mission_points\":[\"Menyelenggarakan pendidikan berkualitas\",\"Mengembangkan karakter siswa\",\"Menciptakan lingkungan belajar yang nyaman\"]}', NOW(), NOW()),
('stats', 'Statistik Sekolah', 1, 3, 'Statistik', 'Capaian Sekolah', NULL, 0.40, '{\"stats\":[{\"label\":\"Siswa\",\"value\":\"150\",\"icon\":\"heroicon-o-academic-cap\"},{\"label\":\"Guru\",\"value\":\"25\",\"icon\":\"heroicon-o-user-group\"},{\"label\":\"Fasilitas\",\"value\":\"12\",\"icon\":\"heroicon-o-building-library\"},{\"label\":\"Program\",\"value\":\"8\",\"icon\":\"heroicon-o-light-bulb\"}]}', NOW(), NOW()),
('programs', 'Program Sekolah', 1, 4, 'Program Sekolah', 'Ekstrakurikuler Unggulan', 'Program-program yang mendukung pengembangan bakat dan karakter siswa.', 0.40, NULL, NOW(), NOW()),
('teachers', 'Guru & Tenaga Pendidik', 1, 5, 'Guru & Tenaga Pendidik', 'Profesional Berdedikasi', 'Tim pendidik profesional yang siap membimbing putra-putri Anda.', 0.40, NULL, NOW(), NOW()),
('facilities', 'Fasilitas Sekolah', 1, 6, 'Fasilitas Sekolah', 'Fasilitas Modern & Lengkap', 'Fasilitas pembelajaran yang modern dan lengkap untuk mendukung proses belajar.', 0.40, NULL, NOW(), NOW()),
('news', 'Berita & Artikel', 1, 7, 'Berita Terbaru', 'Kegiatan & Cerita Sekolah', 'Update kegiatan, prestasi, dan cerita inspiratif dari lingkungan sekolah.', 0.40, NULL, NOW(), NOW()),
('contact', 'Kontak', 1, 8, 'Hubungi Kami', 'Kami Siap Melayani', 'Jangan ragu untuk menghubungi kami kapan saja.', 0.40, NULL, NOW(), NOW());
