<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\SchoolData;
use App\Models\Guru;
use App\Models\Fasilitas;
use App\Models\Program;
use App\Models\Prestasi;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function index()
    {
        $fasilitas = Schema::hasTable('fasilitas')
            ? Fasilitas::orderBy('id')->get()->map(function ($item) {
                $routeMap = [
                    'Ruang Kelas' => 'fasilitas.ruang-kelas',
                    'Perpustakaan' => 'fasilitas.perpustakaan',
                    'Musholla' => 'fasilitas.musholla',
                    'Lapangan Olahraga' => 'fasilitas.lapangan-olahraga',
                ];

                return [
                    'title' => $item->nama,
                    'description' => $item->deskripsi,
                    'icon' => $item->icon,
                    'icon_image' => $item->icon_image,
                    'color' => $item->warna,
                    'route' => $routeMap[$item->nama] ?? 'home',
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

        return view('home', compact('fasilitas', 'guru', 'program', 'prestasi', 'kepsek', 'guruLain', 'sambutanText', 'sambutanFoto'));
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
