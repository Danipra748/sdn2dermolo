<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\SchoolData;
use App\Models\Guru;
use App\Models\Fasilitas;
use App\Models\Program;
use App\Models\Prestasi;
use App\Models\SiteSetting;
use App\Models\Article;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function index()
    {
        $fasilitas = Schema::hasTable('fasilitas')
            ? Fasilitas::orderBy('id')->get()->map(function ($item) {
                return [
                    'title' => $item->nama,
                    'description' => $item->deskripsi,
                    'icon' => $item->icon,
                    'icon_image' => $item->icon_image,
                    'card_bg_image' => $item->card_bg_image,
                    'color' => $item->warna,
                ];
            })->toArray()
            : SchoolData::fasilitas();

        $guru = Guru::orderBy('no')->get();
        $program = Schema::hasTable('programs')
            ? Program::orderBy('id')->get()->map(function ($item) {
                $colorMap = [
                    'pramuka' => 'blue',
                    'seni-ukir' => 'green',
                    'drumband' => 'yellow',
                ];

                return [
                    'title' => $item->title,
                    'desc' => $item->desc,
                    'color' => $colorMap[$item->slug] ?? 'blue',
                    'route' => 'program.' . $item->slug,
                    'foto' => $item->foto,
                    'emoji' => $item->emoji,
                    'card_bg_image' => $item->card_bg_image,
                ];
            })->toArray()
            : SchoolData::program();

        $prestasi = Schema::hasTable('prestasis')
            ? Prestasi::latest()->take(3)->get()->map(function ($item) {
                return [
                    'judul' => $item->judul,
                    'deskripsi' => $item->deskripsi,
                    'foto' => $item->foto,
                ];
            })->toArray()
            : [];

        $berita = collect();
        if (Schema::hasTable('articles')) {
            $query = Article::published()->latest('published_at');
            // Prioritaskan type='berita', tapi tampilkan juga yang published lainnya
            if (Schema::hasColumn('articles', 'type')) {
                // Cek apakah ada berita dengan type='berita'
                $hasBerita = (clone $query)->where('type', 'berita')->exists();
                if ($hasBerita) {
                    $query->where('type', 'berita');
                }
                // Jika tidak ada yang type='berita', tampilkan semua yang published
            }
            $berita = $query->take(3)->get();
        }

        $kepsek = $guru->first(function ($item) {
            return $item->jabatan && str_contains(strtolower($item->jabatan), 'kepala');
        }) ?? $guru->first();

        $guruLain = $kepsek
            ? $guru->reject(fn ($item) => $item->id === $kepsek->id)->values()
            : collect();

        $defaultSambutan = implode("\n", [
            'SD N 2 Dermolo adalah lembaga pendidikan dasar yang berkomitmen memberikan pendidikan berkualitas tinggi. Kami terus berinovasi menghadirkan metode pembelajaran yang efektif dan menyenangkan.',
            'Melalui pendekatan holistik, kami mengembangkan tidak hanya aspek akademik, tetapi juga karakter, kreativitas, dan keterampilan sosial setiap siswa.',
        ]);

        $sambutanText = Schema::hasTable('site_settings')
            ? SiteSetting::getValue('kepsek_sambutan_text', $defaultSambutan)
            : $defaultSambutan;

        $sambutanFoto = Schema::hasTable('site_settings')
            ? SiteSetting::getValue('kepsek_sambutan_foto')
            : null;

        $kontakDefaults = [
            'address' => "Desa Dermolo, Kecamatan Kembang\nKabupaten Jepara, Jawa Tengah",
            'phone' => '(0291) 123-456',
            'email' => 'sdn2dermolo@gmail.com',
            'maps_url' => '',
        ];

        $kontak = Schema::hasTable('site_settings')
            ? [
                'address' => SiteSetting::getValue('school_address', $kontakDefaults['address']),
                'phone' => SiteSetting::getValue('school_phone', $kontakDefaults['phone']),
                'email' => SiteSetting::getValue('school_email', $kontakDefaults['email']),
                'maps_url' => SiteSetting::getValue('school_maps_url', $kontakDefaults['maps_url']),
            ]
            : $kontakDefaults;

        return view('home', compact(
            'fasilitas',
            'guru',
            'program',
            'prestasi',
            'berita',
            'kepsek',
            'guruLain',
            'sambutanText',
            'sambutanFoto',
            'kontak'
        ));
    }

    public function programIndex()
    {
        $program = Schema::hasTable('programs')
            ? Program::orderBy('id')->get()
            : collect(SchoolData::program());

        $heroBg = Schema::hasTable('site_settings')
            ? SiteSetting::getValue('program_hero_bg_image')
            : null;

        return view('program.index', compact('program', 'heroBg'));
    }

    public function fasilitasIndex()
    {
        $fasilitas = Schema::hasTable('fasilitas')
            ? Fasilitas::orderBy('id')->get()
            : collect(SchoolData::fasilitas());

        $heroBg = Schema::hasTable('site_settings')
            ? SiteSetting::getValue('fasilitas_hero_bg_image')
            : null;

        return view('fasilitas.index', compact('fasilitas', 'heroBg'));
    }

    public function guruIndex()
    {
        $guru = Guru::orderBy('no')->get();

        $kepsek = $guru->first(function ($item) {
            return $item->jabatan && str_contains(strtolower($item->jabatan), 'kepala');
        }) ?? $guru->first();

        $guruLain = $kepsek
            ? $guru->reject(fn ($item) => $item->id === $kepsek->id)->values()
            : collect();

        return view('guru.index', compact('guru', 'kepsek', 'guruLain'));
    }
}
