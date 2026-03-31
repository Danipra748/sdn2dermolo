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
            'title' => 'Prestasi Sekolah',
            'subtitle' => 'Dokumentasi capaian akademik dan non-akademik SD N 2 Dermolo.',
            'initial' => 'A',
            'hero_bg_image' => null,
            'items' => [
                'Juara lomba akademik tingkat kecamatan.',
                'Prestasi seni dan budaya tingkat kabupaten.',
                'Capaian olahraga dan kegiatan ekstrakurikuler.',
            ],
            'dokumentasi' => [],
        ];

        if (Schema::hasTable('site_settings')) {
            $saved = SiteSetting::getValue('prestasi_ringkasan');
            $heroBg = SiteSetting::getValue('prestasi_hero_bg_image');

            if ($saved) {
                $decoded = json_decode($saved, true);

                if (is_array($decoded) && ! empty($decoded)) {
                    $data['items'] = $decoded;
                }
            }

            if ($heroBg) {
                $data['hero_bg_image'] = $heroBg;
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
