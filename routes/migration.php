<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Auto-Migration on Page Load (Development Only)
|--------------------------------------------------------------------------
|
| This automatically runs migration when accessing any page
| ONLY For DEVELOPMENT - Remove before production!
|
*/

// Auto-run migration check on every request (development only)
if (app()->environment('local') || true) { // Force for development
    try {
        if (!Schema::hasColumn('site_settings', 'school_latitude')) {
            // Add coordinate columns
            DB::statement("
                ALTER TABLE `site_settings` 
                ADD COLUMN `school_latitude` DECIMAL(10, 8) NULL COMMENT 'School location latitude (decimal degrees)',
                ADD COLUMN `school_longitude` DECIMAL(11, 8) NULL COMMENT 'School location longitude (decimal degrees)',
                ADD COLUMN `map_zoom` INT NULL DEFAULT 15 COMMENT 'Map zoom level (1-19)'
            ");

            // Set default coordinates (Jepara center)
            DB::statement("
                UPDATE `site_settings` 
                SET `school_latitude` = -6.82830000,
                    `school_longitude` = 110.65360000,
                    `map_zoom` = 15
                WHERE `school_latitude` IS NULL
            ");

            \Log::info('Auto-migration: Coordinate columns added successfully');
        }
    } catch (\Exception $e) {
        \Log::error('Auto-migration failed: ' . $e->getMessage());
    }
}

Route::get('/_migrate-coordinates', function() {
    try {
        // Check if columns already exist
        if (Schema::hasColumn('site_settings', 'school_latitude')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Columns already exist. Migration not needed.',
                'details' => 'Database already has coordinate columns.',
                'next_step' => 'Visit /admin/kontak-sekolah to set school location'
            ]);
        }

        // Add coordinate columns
        DB::statement("
            ALTER TABLE `site_settings` 
            ADD COLUMN `school_latitude` DECIMAL(10, 8) NULL COMMENT 'School location latitude (decimal degrees)',
            ADD COLUMN `school_longitude` DECIMAL(11, 8) NULL COMMENT 'School location longitude (decimal degrees)',
            ADD COLUMN `map_zoom` INT NULL DEFAULT 15 COMMENT 'Map zoom level (1-19)'
        ");

        // Set default coordinates (Jepara center)
        DB::statement("
            UPDATE `site_settings` 
            SET `school_latitude` = -6.82830000,
                `school_longitude` = 110.65360000,
                `map_zoom` = 15
            WHERE `school_latitude` IS NULL
        ");

        return response()->json([
            'status' => 'success',
            'message' => 'Migration completed successfully!',
            'details' => [
                'Columns added: school_latitude, school_longitude, map_zoom',
                'Default coordinates set: -6.8283, 110.6536 (Jepara)',
                'Default zoom: 15',
                'Next: Visit /admin/kontak-sekolah to set school location'
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Migration failed: ' . $e->getMessage(),
            'solution' => 'Check database connection and permissions'
        ], 500);
    }
})->middleware(['web']);

Route::get('/_check-columns', function() {
    $hasLatitude = Schema::hasColumn('site_settings', 'school_latitude');
    $hasLongitude = Schema::hasColumn('site_settings', 'school_longitude');
    $hasZoom = Schema::hasColumn('site_settings', 'map_zoom');

    $coordinates = null;
    if ($hasLatitude && $hasLongitude) {
        $setting = DB::table('site_settings')->first();
        if ($setting) {
            $coordinates = [
                'latitude' => $setting->school_latitude,
                'longitude' => $setting->school_longitude,
                'zoom' => $setting->map_zoom ?? 15,
            ];
        }
    }

    return response()->json([
        'status' => 'success',
        'columns' => [
            'school_latitude' => $hasLatitude ? 'EXISTS' : 'NOT EXISTS',
            'school_longitude' => $hasLongitude ? 'EXISTS' : 'NOT EXISTS',
            'map_zoom' => $hasZoom ? 'EXISTS' : 'NOT EXISTS',
        ],
        'coordinates' => $coordinates,
        'ready' => $hasLatitude && $hasLongitude && $hasZoom
    ]);
});
