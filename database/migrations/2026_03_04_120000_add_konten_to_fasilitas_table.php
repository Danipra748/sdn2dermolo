<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            if (! Schema::hasColumn('fasilitas', 'konten')) {
                $table->json('konten')->nullable()->after('warna');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            if (Schema::hasColumn('fasilitas', 'konten')) {
                $table->dropColumn('konten');
            }
        });
    }
};
