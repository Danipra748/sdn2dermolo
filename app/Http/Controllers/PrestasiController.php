<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class PrestasiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Prestasi Siswa',
            'subtitle' => 'Catatan kebanggaan dan pencapaian luar biasa yang diraih oleh siswa-siswi terbaik kami.',
            'initial' => 'A',
            'items' => [
                'Juara lomba akademik tingkat kecamatan.',
                'Prestasi seni dan budaya tingkat kabupaten.',
                'Capaian olahraga dan kegiatan ekstrakurikuler.',
            ],
            'dokumentasi' => [],
        ];

        if (Schema::hasTable('site_settings')) {
            $saved = SiteSetting::getValue('prestasi_ringkasan');

            if ($saved) {
                $decoded = json_decode($saved, true);

                if (is_array($decoded) && ! empty($decoded)) {
                    $data['items'] = $decoded;
                }
            }
        }

        if (Schema::hasTable('prestasis')) {
            $prestasi = Prestasi::latest()->get();

            if ($prestasi->isNotEmpty()) {
                $data['dokumentasi'] = $prestasi->map(function ($item) {
                    return [
                        'judul' => $item->judul,
                        'deskripsi' => $item->deskripsi,
                        'foto' => $item->foto,
                    ];
                })->all();
            }
        }

        return view('prestasi.index', compact('data'));
    }
}
