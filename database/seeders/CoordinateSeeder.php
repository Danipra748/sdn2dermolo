<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CoordinateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if columns exist
        if (!Schema::hasColumn('site_settings', 'school_latitude')) {
            // Add columns first
            DB::statement("
                ALTER TABLE `site_settings` 
                ADD COLUMN `school_latitude` DECIMAL(10, 8) NULL COMMENT 'School location latitude (decimal degrees)',
                ADD COLUMN `school_longitude` DECIMAL(11, 8) NULL COMMENT 'School location longitude (decimal degrees)',
                ADD COLUMN `map_zoom` INT NULL DEFAULT 15 COMMENT 'Map zoom level (1-19)'
            ");
            
            $this->command->info('✅ Added coordinate columns to site_settings table');
        }

        // Set default coordinates (Jepara center)
        $updated = DB::table('site_settings')
            ->whereNull('school_latitude')
            ->update([
                'school_latitude' => -6.82830000,
                'school_longitude' => 110.65360000,
                'map_zoom' => 15,
            ]);

        if ($updated > 0 || $updated === 0) {
            $this->command->info('✅ Coordinate seeder completed successfully!');
            $this->command->info('📍 Default coordinates set: -6.8283, 110.6536 (Jepara)');
            $this->command->info('🔍 Default zoom level: 15');
        }
    }
}
