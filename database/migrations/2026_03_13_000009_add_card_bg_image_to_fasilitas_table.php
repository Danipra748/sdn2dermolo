<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            if (! Schema::hasColumn('fasilitas', 'card_bg_image')) {
                $table->string('card_bg_image')->nullable()->after('icon_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            if (Schema::hasColumn('fasilitas', 'card_bg_image')) {
                $table->dropColumn('card_bg_image');
            }
        });
    }
};
