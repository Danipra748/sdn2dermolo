<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Support\SchoolConfig;
use Illuminate\Support\Facades\Schema;

class AboutController extends Controller
{
    /**
     * Display about page
     */
    public function index()
    {
        $profile = SchoolProfile::getOrCreate();
        $sambutanText = SiteSetting::getValue('kepsek_sambutan_text', '');
        $sambutanFoto = SiteSetting::getValue('kepsek_sambutan_foto');
        $fotoKepsek = SiteSetting::getFotoKepsek();

        $guru = Schema::hasTable('gurus')
            ? Guru::orderBy('no')->get()
            : collect();

        $kepsek = $guru->first(function ($item) {
            $jabatan = strtolower((string) data_get($item, 'jabatan', ''));

            return str_contains($jabatan, 'kepala') || str_contains($jabatan, 'kepsek');
        }) ?? $guru->first();
        
        // Get contact info from static config
        $kontak = SchoolConfig::contact();
        $alamatLines = SchoolConfig::addressLines();
        $mapsEmbed = SchoolConfig::mapsEmbed();
        $mapsOpen = SchoolConfig::mapsOpen();

        return view('about.index', compact(
            'profile',
            'sambutanText',
            'sambutanFoto',
            'fotoKepsek',
            'kepsek',
            'kontak',
            'mapsEmbed',
            'mapsOpen',
            'alamatLines'
        ));
    }
}
