<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            if (! Schema::hasColumn('fasilitas', 'icon')) {
                $table->string('icon')->default('')->after('deskripsi');
            }

            if (! Schema::hasColumn('fasilitas', 'warna')) {
                $table->string('warna')->default('blue')->after('icon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            $dropColumns = [];

            if (Schema::hasColumn('fasilitas', 'icon')) {
                $dropColumns[] = 'icon';
            }

            if (Schema::hasColumn('fasilitas', 'warna')) {
                $dropColumns[] = 'warna';
            }

            if (! empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
