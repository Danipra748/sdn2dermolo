<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheableService
{
    /**
     * Flush cache tags safely if supported by the driver.
     */
    protected function flushCacheTags(array $tags): void
    {
        try {
            $cache = Cache::getFacadeRoot();
            if (method_exists($cache->store(), 'tags')) {
                Cache::tags($tags)->flush();
            } else {
                // If tags are not supported, we might want to clear the whole cache
                // or just do nothing (standard behavior for file/database)
                // Clearing the whole cache is safer for data consistency but slower
                Cache::flush();
            }
        } catch (\Exception $e) {
            \Log::warning('Cache flush failed: ' . $e->getMessage());
        }
    }
}
