<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('ppdb_settings', 'form_url')) {
            Schema::table('ppdb_settings', function ($table) {
                $table->renameColumn('form_url', 'registration_link');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('ppdb_settings', 'registration_link')) {
            Schema::table('ppdb_settings', function ($table) {
                $table->renameColumn('registration_link', 'form_url');
            });
        }
    }
};
