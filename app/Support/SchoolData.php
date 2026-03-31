<?php

namespace App\Support;

final class SchoolData
{
    public static function fasilitas(): array
    {
        return [
            [
                'title'       => 'Ruang Kelas',
                'description' => '18 ruang kelas yang nyaman dan ber-AC',
                'icon'        => 'building',
                'color'       => 'blue',
            ],
            [
                'title'       => 'Perpustakaan',
                'description' => 'Koleksi buku lengkap dan ruang baca yang nyaman',
                'icon'        => 'book-open',
                'color'       => 'green',
            ],
            [
                'title'       => 'Musholla',
                'description' => 'Sarana ibadah yang nyaman dan terawat',
                'icon'        => 'building-library',
                'color'       => 'yellow',
            ],
            [
                'title'       => 'Lapangan Olahraga',
                'description' => 'Lapangan basket, voli, dan futsal',
                'icon'        => 'trophy',
                'color'       => 'pink',
            ],
        ];
    }

    public static function guru(): array
    {
        return [
            [
                'nama'     => 'Budi Santoso, S.Pd., M.M.',
                'jabatan'  => 'Kepala Sekolah',
                'nip'      => '197203151997031007',
                'keahlian' => ['Manajemen Pendidikan', 'Supervisi Akademik'],
                'color'    => 'purple',
            ],
            [
                'nama'     => 'Sri Wahyuni, S.Pd',
                'jabatan'  => 'Guru Kelas 6A',
                'nip'      => '198001202003122005',
                'keahlian' => ['IPA', 'Matematika'],
                'color'    => 'blue',
            ],
            [
                'nama'     => 'Ahmad Fauzi, S.Pd',
                'jabatan'  => 'Guru Kelas 5A',
                'nip'      => '197905102004011008',
                'keahlian' => ['Bahasa Indonesia', 'IPS'],
                'color'    => 'green',
            ],
            [
                'nama'     => 'Dewi Lestari, S.Pd',
                'jabatan'  => 'Guru Kelas 3B',
                'nip'      => '198305152006042008',
                'keahlian' => ['Bahasa Inggris', 'Seni Budaya'],
                'color'    => 'yellow',
            ],
            [
                'nama'     => 'Rina Marlina, S.Pd',
                'jabatan'  => 'Guru Kelas 2A',
                'nip'      => '198607202009032005',
                'keahlian' => ['Matematika', 'Bahasa Indonesia'],
                'color'    => 'purple',
            ],
            [
                'nama'     => 'Hendra Wijaya, S.Pd',
                'jabatan'  => 'Guru Kelas 1B',
                'nip'      => '198901152010011006',
                'keahlian' => ['Tematik', 'Pendidikan Agama'],
                'color'    => 'red',
            ],
        ];
    }

    public static function program(): array
    {
        return [
            [
                'title' => 'Ekstra Pramuka',
                'desc'  => 'Program pembinaan karakter, kemandirian, kepemimpinan, dan kerja sama tim melalui kegiatan kepramukaan rutin.',
                'color' => 'blue',
                'route' => 'program.pramuka',
            ],
            [
                'title' => 'Seni Ukir',
                'desc'  => 'Program pengembangan kreativitas siswa melalui keterampilan seni ukir dengan mengenalkan motif lokal dan teknik dasar.',
                'color' => 'green',
                'route' => 'program.seni-ukir',
            ],
            [
                'title' => 'Drumband',
                'desc'  => 'Program ekstrakurikuler musik baris-berbaris untuk melatih disiplin, kekompakan, ritme, dan kepercayaan diri siswa.',
                'color' => 'yellow',
                'route' => 'program.drumband',
            ],
        ];
    }
}
