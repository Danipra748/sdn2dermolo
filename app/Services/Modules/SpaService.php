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
use Illuminate\Support\Facades\Cache;

class SpaService
{
    /**
     * Get home page data.
     */
    public function getHomeData(): array
    {
        $cache = Cache::getFacadeRoot();
        $tags = ['hero_slides', 'gurus', 'articles', 'galleries', 'school_profile', 'site_settings'];
        
        $callback = function () {
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
        };

        if (method_exists($cache->store(), 'tags')) {
            return Cache::tags($tags)->rememberForever('spa_home_data', $callback);
        }

        return Cache::rememberForever('spa_home_data', $callback);
    }

    /**
     * Get public guru collection.
     */
    public function getGuruCollection(): Collection
    {
        $cache = Cache::getFacadeRoot();
        $callback = function () {
            if (!Schema::hasTable('gurus')) {
                return collect(SchoolData::guru())->map(fn ($item) => (object) $item);
            }
            return Guru::orderBy('no')->get();
        };

        if (method_exists($cache->store(), 'tags')) {
            return Cache::tags(['gurus'])->rememberForever('spa_guru_collection', $callback);
        }

        return Cache::rememberForever('spa_guru_collection', $callback);
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
        $cache = Cache::getFacadeRoot();
        $callback = function () use ($limit) {
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
        };

        if (method_exists($cache->store(), 'tags')) {
            return Cache::tags(['articles', 'categories'])->rememberForever('spa_published_news_' . ($limit ?? 'all'), $callback);
        }

        return Cache::rememberForever('spa_published_news_' . ($limit ?? 'all'), $callback);
    }
}
