-- Migration for school_profiles table
-- Run this in phpMyAdmin or MySQL CLI

CREATE TABLE IF NOT EXISTS `school_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SD N 2 Dermolo',
  `npsn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Negeri',
  `accreditation` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'B',
  `address` text COLLATE utf8mb4_unicode_ci,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Jepara',
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Jawa Tengah',
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `history_content` text COLLATE utf8mb4_unicode_ci,
  `established_year` int DEFAULT NULL,
  `land_area` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `building_area` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_classes` int DEFAULT NULL,
  `total_students` int DEFAULT NULL,
  `total_teachers` int DEFAULT NULL,
  `total_staff` int DEFAULT NULL,
  `vision` text COLLATE utf8mb4_unicode_ci,
  `missions` json DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed initial data
INSERT INTO `school_profiles` (`id`, `school_name`, `npsn`, `school_status`, `accreditation`, `address`, `village`, `district`, `city`, `province`, `postal_code`, `phone`, `email`, `website`, `history_content`, `established_year`, `land_area`, `total_classes`, `vision`, `missions`, `created_at`, `updated_at`) VALUES
(1, 'SD N 2 Dermolo', '20318087', 'Negeri', 'B', 'Desa Dermolo', 'Dermolo', 'Kembang', 'Jepara', 'Jawa Tengah', '59453', '(0291) 123-456', 'sdn2dermolo@gmail.com', NULL, 'SD N 2 Dermolo adalah lembaga pendidikan dasar yang berkomitmen memberikan pendidikan berkualitas tinggi. Kami terus berinovasi menghadirkan metode pembelajaran yang efektif dan menyenangkan.\n\nMelalui pendekatan holistik, kami mengembangkan tidak hanya aspek akademik, tetapi juga karakter, kreativitas, dan keterampilan sosial setiap siswa.', 1975, '1.400 m²', 12, 'Terwujudnya peserta didik yang beriman, berakhlak mulia, berprestasi, berbudaya, dan berwawasan lingkungan.', '["Menyelenggarakan pendidikan berkualitas dengan kurikulum terkini", "Mengembangkan karakter siswa yang berakhlak mulia", "Menciptakan lingkungan belajar yang nyaman dan inspiratif", "Meningkatkan prestasi akademik dan non-akademik siswa", "Membina kerjasama yang baik dengan orang tua dan masyarakat"]', NOW(), NOW());
