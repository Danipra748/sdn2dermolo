<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (! Schema::hasColumn('articles', 'type')) {
                $table->string('type', 20)->default('artikel')->after('status');
            }
        });

        if (Schema::hasColumn('articles', 'type')) {
            DB::table('articles')->whereNull('type')->update(['type' => 'artikel']);
        }
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
