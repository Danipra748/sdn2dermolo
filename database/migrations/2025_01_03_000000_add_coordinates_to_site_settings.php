<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $hasLatitude = Schema::hasColumn('site_settings', 'school_latitude');
        $hasLongitude = Schema::hasColumn('site_settings', 'school_longitude');
        $hasZoom = Schema::hasColumn('site_settings', 'map_zoom');

        Schema::table('site_settings', function (Blueprint $table) use ($hasLatitude, $hasLongitude, $hasZoom) {
            if (! $hasLatitude) {
                $table->decimal('school_latitude', 10, 8)->nullable()->after('value')
                    ->comment('School location latitude (decimal degrees)');
            }

            if (! $hasLongitude) {
                $table->decimal('school_longitude', 11, 8)->nullable()->after('school_latitude')
                    ->comment('School location longitude (decimal degrees)');
            }

            if (! $hasZoom) {
                $table->integer('map_zoom')->default(15)->after('school_longitude')
                    ->comment('Map zoom level (1-19)');
            }
        });

        if (Schema::hasColumn('site_settings', 'school_latitude')
            && Schema::hasColumn('site_settings', 'school_longitude')
            && Schema::hasColumn('site_settings', 'map_zoom')) {
            DB::table('site_settings')
                ->whereNull('school_latitude')
                ->update([
                    'school_latitude' => -6.82830000,
                    'school_longitude' => 110.65360000,
                    'map_zoom' => 15,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $columns = [];

            foreach (['school_latitude', 'school_longitude', 'map_zoom'] as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
