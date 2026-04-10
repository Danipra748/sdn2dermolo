<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\HomepageSection;
use App\Models\Prestasi;
use App\Models\Program;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Support\SchoolConfig;
use App\Support\SchoolData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class SpaController extends Controller
{
    public function getHomeContent(Request $request): JsonResponse|RedirectResponse
    {
        $hero = Schema::hasTable('homepage_sections')
            ? HomepageSection::getHero()
            : null;

        $guru = $this->getGuruCollection();
        $kepsek = $this->findKepsek($guru);

        $defaultSambutan = implode("\n", [
            'SD N 2 Dermolo adalah lembaga pendidikan dasar yang berkomitmen memberikan pendidikan berkualitas tinggi. Kami terus berinovasi menghadirkan metode pembelajaran yang efektif dan menyenangkan.',
            'Melalui pendekatan holistik, kami mengembangkan tidak hanya aspek akademik, tetapi juga karakter, kreativitas, dan keterampilan sosial setiap siswa.',
        ]);

        $sambutanText = SiteSetting::getValue('kepsek_sambutan_text', $defaultSambutan);
        $sambutanFoto = SiteSetting::getValue('kepsek_sambutan_foto');

        $profile = SchoolProfile::getOrCreate();
        $visi = $profile->vision;
        $misi = is_array($profile->missions)
            ? implode("\n", array_filter($profile->missions))
            : ($profile->missions ?? '');

        // Get latest news (3 posts)
        $berita = $this->getPublishedNews(3);

        // Get contact info from static config
        $kontak = SchoolConfig::contact();
        $alamatLines = SchoolConfig::addressLines();
        $mapsEmbed = SchoolConfig::mapsEmbed();
        $mapsOpen = SchoolConfig::mapsOpen();

        return $this->respond(
            $request,
            'spa.partials.home',
            compact(
                'hero',
                'sambutanFoto',
                'sambutanText',
                'kepsek',
                'visi',
                'misi',
                'berita',
                'kontak',
                'mapsEmbed',
                'mapsOpen',
                'alamatLines'
            ),
            'Beranda - SD N 2 Dermolo',
            route('home')
        );
    }

    public function getSaranaPrasaranaContent(Request $request): JsonResponse|RedirectResponse
    {
        $fasilitas = Schema::hasTable('fasilitas')
            ? Fasilitas::orderBy('id')->get()
            : collect(SchoolData::fasilitas());

        return $this->respond(
            $request,
            'spa.partials.sarana-prasarana',
            compact('fasilitas'),
            'Sarana & Prasarana - SD N 2 Dermolo',
            route('fasilitas.index')
        );
    }

    public function getDataGuruContent(Request $request): JsonResponse|RedirectResponse
    {
        $guru = $this->getGuruCollection();
        $kepsek = $this->findKepsek($guru);
        $guruLain = $kepsek
            ? $guru->reject(fn ($item) => data_get($item, 'id') === data_get($kepsek, 'id'))->values()
            : $guru;

        return $this->respond(
            $request,
            'spa.partials.data-guru',
            compact('kepsek', 'guruLain'),
            'Data Guru - SD N 2 Dermolo',
            route('guru.index')
        );
    }

    public function getPrestasiContent(Request $request): JsonResponse|RedirectResponse
    {
        $prestasi = Schema::hasTable('prestasis')
            ? Prestasi::latest()->get()
            : collect();

        return $this->respond(
            $request,
            'spa.partials.prestasi',
            compact('prestasi'),
            'Prestasi - SD N 2 Dermolo',
            route('prestasi.index')
        );
    }

    public function getAboutContent(Request $request): JsonResponse|RedirectResponse
    {
        $profile = SchoolProfile::getOrCreate();
        
        // Get contact info from static config
        $kontak = SchoolConfig::contact();
        $alamatLines = SchoolConfig::addressLines();
        $mapsEmbed = SchoolConfig::mapsEmbed();
        $mapsOpen = SchoolConfig::mapsOpen();

        return $this->respond(
            $request,
            'spa.partials.about',
            compact('profile', 'mapsEmbed', 'mapsOpen', 'alamatLines'),
            'Tentang Kami - SD N 2 Dermolo',
            route('about')
        );
    }

    public function getBeritaContent(Request $request): JsonResponse|RedirectResponse
    {
        $news = $this->getPublishedNews();
        $categories = Schema::hasTable('categories')
            ? Category::orderBy('name')->get()
            : collect();

        return $this->respond(
            $request,
            'spa.partials.berita',
            compact('news', 'categories'),
            'Berita - SD N 2 Dermolo',
            route('news.index')
        );
    }

    public function getProgramContent(Request $request): JsonResponse|RedirectResponse
    {
        $program = Schema::hasTable('programs')
            ? Program::orderBy('id')->get()
            : collect(SchoolData::program());

        return $this->respond(
            $request,
            'spa.partials.program',
            compact('program'),
            'Program - SD N 2 Dermolo',
            route('program.index')
        );
    }

    private function respond(
        Request $request,
        string $view,
        array $data,
        string $title,
        string $url
    ): JsonResponse|RedirectResponse {
        if (! $this->isSpaRequest($request)) {
            return redirect()->to($url);
        }

        return response()->json([
            'success' => true,
            'html' => view($view, $data)->render(),
            'title' => $title,
            'url' => $url,
        ]);
    }

    private function isSpaRequest(Request $request): bool
    {
        return $request->ajax()
            || $request->expectsJson()
            || $request->header('X-Requested-With') === 'XMLHttpRequest';
    }

    private function getGuruCollection(): Collection
    {
        if (! Schema::hasTable('gurus')) {
            return collect(SchoolData::guru())
                ->map(fn (array $item) => (object) $item);
        }

        return Guru::orderBy('no')->get();
    }

    private function findKepsek(Collection $guru): mixed
    {
        return $guru->first(function ($item) {
            $jabatan = strtolower((string) data_get($item, 'jabatan', ''));

            return str_contains($jabatan, 'kepala') || str_contains($jabatan, 'kepsek');
        }) ?? $guru->first();
    }

    private function getPublishedNews(?int $limit = null): Collection
    {
        if (! Schema::hasTable('articles')) {
            return collect();
        }

        $query = Article::with('category')
            ->published()
            ->latest('published_at');

        if (Schema::hasColumn('articles', 'type')) {
            $hasBerita = (clone $query)->where('type', 'berita')->exists();

            if ($hasBerita) {
                $query->where('type', 'berita');
            }
        }

        if ($limit !== null) {
            $query->take($limit);
        }

        return $query->get();
    }
}
