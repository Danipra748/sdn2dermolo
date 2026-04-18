<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\Program;
use App\Models\PpdbSetting;
use App\Models\PpdbBanner;
use App\Support\SchoolConfig;
use App\Support\SchoolData;
use App\Services\Modules\SpaService;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    protected $spaService;

    public function __construct(SpaService $spaService)
    {
        $this->spaService = $spaService;
    }

    public function index()
    {
        $data = $this->spaService->getHomeData();
        return view('home', $data);
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
        $guru = $this->spaService->getGuruCollection();
        $kepsek = $this->spaService->findKepsek($guru);
        $guruLain = $kepsek
            ? $guru->reject(fn ($item) => data_get($item, 'id') === data_get($kepsek, 'id'))->values()
            : $guru;

        return view('guru.index', compact('guru', 'kepsek', 'guruLain'));
    }

    public function contactIndex()
    {
        $kontak = SchoolConfig::contact();
        $alamatLines = SchoolConfig::addressLines();
        $mapsEmbed = SchoolConfig::mapsEmbed();
        $mapsOpen = SchoolConfig::mapsOpen();

        return view('contact', compact('kontak', 'alamatLines', 'mapsEmbed', 'mapsOpen'));
    }

    public function ppdbIndex()
    {
        $settings = PpdbSetting::getInstance();
        $banners = PpdbBanner::active()->get();
        $status = $settings->getStatus();

        return view('ppdb.index', compact('settings', 'banners', 'status'));
    }

    public function ppdbRegister()
    {
        $settings = PpdbSetting::getInstance();
        $status = $settings->getStatus();

        if ($status === 'waiting' || $status === 'closed') {
            return redirect()->route('ppdb')->with('error', 'Pendaftaran PPDB sedang tidak dibuka.');
        }

        return view('ppdb.register', compact('settings', 'status'));
    }
}
