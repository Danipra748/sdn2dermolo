<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheableService
{
    /**
     * Flush specific cache keys.
     */
    protected function clearModuleCache(array $additionalKeys = []): void
    {
        // Core keys that affect the public SPA frontend
        $baseKeys = [
            'spa_home_data',
            'spa_guru_collection',
            'spa_published_news_all',
            'spa_published_news_3',
        ];

        $keys = array_merge($baseKeys, $additionalKeys);

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    /**
     * Clear all cache as a safety measure.
     */
    protected function clearAllCache(): void
    {
        Cache::flush();
    }
}
