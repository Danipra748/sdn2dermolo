<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\SchoolConfig;
use App\Support\SchoolData;
use App\Models\Guru;
use App\Models\Fasilitas;
use App\Models\Gallery;
use App\Models\Program;
use App\Models\Prestasi;
use App\Models\SiteSetting;
use App\Models\Article;
use App\Models\HomepageSection;
use App\Models\SchoolProfile;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function index()
    {
        $guru = Schema::hasTable('gurus')
            ? Guru::orderBy('no')->get()
            : collect(SchoolData::guru())->map(fn (array $item) => (object) $item);

        $kepsek = $guru->first(function ($item) {
            return $item->jabatan && str_contains(strtolower($item->jabatan), 'kepala');
        }) ?? $guru->first();

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

        // Get contact info from static config
        $kontak = SchoolConfig::contact();
        $alamatLines = SchoolConfig::addressLines();
        $mapsEmbed = SchoolConfig::mapsEmbed();
        $mapsOpen = SchoolConfig::mapsOpen();

        // Get hero section from database
        $hero = HomepageSection::getHero();

        // Get visi/misi from school profile
        $profile = SchoolProfile::getOrCreate();
        $visi = $profile->vision;
        $misi = is_array($profile->missions) ? implode("\n", $profile->missions) : $profile->missions;

        // Get latest news (3 posts)
        $berita = Schema::hasTable('articles')
            ? Article::with('category')
                ->published()
                ->latest('published_at')
                ->take(3)
                ->get()
            : collect();

        // Get latest gallery (4 photos)
        $galeri = Schema::hasTable('galleries')
            ? Gallery::latest()->take(4)->get()
            : collect();

        return view('home', compact(
            'hero',
            'kepsek',
            'sambutanText',
            'sambutanFoto',
            'kontak',
            'visi',
            'misi',
            'berita',
            'galeri',
            'mapsEmbed',
            'mapsOpen',
            'alamatLines'
        ));
    }

    public function programIndex()
    {
        $program = Schema::hasTable('programs')
            ? Program::orderBy('id')->get()
            : collect(SchoolData::program());

        return view('program.index', compact('program'));
    }

    public function fasilitasIndex()
    {
        $fasilitas = Schema::hasTable('fasilitas')
            ? Fasilitas::orderBy('id')->get()
            : collect(SchoolData::fasilitas());

        return view('fasilitas.index', compact('fasilitas'));
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
