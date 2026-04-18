<?php

namespace App\Services\Modules;

use App\Models\Article;
use App\Models\Category;
use App\Models\Fasilitas;
use App\Models\Gallery;
use App\Models\Guru;
use App\Models\Prestasi;
use App\Models\Program;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Models\PpdbSetting;
use App\Models\PpdbBanner;
use App\Models\HeroSlide;
use App\Support\SchoolConfig;
use App\Support\SchoolData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class SpaService
{
    /**
     * Get home page data.
     */
    public function getHomeData(): array
    {
        $heroSlides = Schema::hasTable('hero_slides') ? HeroSlide::getActiveOrdered() : null;
        $guru = $this->getGuruCollection();
        $kepsek = $this->findKepsek($guru);
        
        $defaultSambutan = implode("\n", [
            'SD N 2 Dermolo adalah lembaga pendidikan dasar yang berkomitmen memberikan pendidikan berkualitas tinggi.',
            'Kami terus berinovasi menghadirkan metode pembelajaran yang efektif dan menyenangkan.'
        ]);

        $profile = SchoolProfile::getOrCreate();
        
        return [
            'heroSlides' => $heroSlides,
            'sambutanFoto' => SiteSetting::getValue('kepsek_sambutan_foto'),
            'fotoKepsek' => SiteSetting::getFotoKepsek(),
            'sambutanText' => SiteSetting::getValue('kepsek_sambutan_text', $defaultSambutan),
            'kepsek' => $kepsek,
            'visi' => $profile->vision,
            'misi' => is_array($profile->missions) ? implode("\n", array_filter($profile->missions)) : ($profile->missions ?? ''),
            'berita' => $this->getPublishedNews(3),
            'galeri' => Schema::hasTable('galleries') ? Gallery::latest()->take(4)->get() : collect(),
            'kontak' => SchoolConfig::contact(),
            'mapsEmbed' => SchoolConfig::mapsEmbed(),
            'mapsOpen' => SchoolConfig::mapsOpen(),
            'alamatLines' => SchoolConfig::addressLines(),
        ];
    }

    /**
     * Get public guru collection.
     */
    public function getGuruCollection(): Collection
    {
        if (!Schema::hasTable('gurus')) {
            return collect(SchoolData::guru())->map(fn ($item) => (object) $item);
        }
        return Guru::orderBy('no')->get();
    }

    /**
     * Find principal from collection.
     */
    public function findKepsek(Collection $guru): mixed
    {
        return $guru->first(function ($item) {
            $jabatan = strtolower((string) data_get($item, 'jabatan', ''));
            return str_contains($jabatan, 'kepala') || str_contains($jabatan, 'kepsek');
        }) ?? $guru->first();
    }

    /**
     * Get published news with optional limit.
     */
    public function getPublishedNews(?int $limit = null): Collection
    {
        if (!Schema::hasTable('articles')) {
            return collect();
        }

        $query = Article::with('category')->published()->latest('published_at');

        if (Schema::hasColumn('articles', 'type')) {
            if ((clone $query)->where('type', 'berita')->exists()) {
                $query->where('type', 'berita');
            }
        }

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }
}
