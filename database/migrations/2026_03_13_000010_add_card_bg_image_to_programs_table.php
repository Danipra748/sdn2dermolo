<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            if (! Schema::hasColumn('programs', 'card_bg_image')) {
                $table->string('card_bg_image')->nullable()->after('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            if (Schema::hasColumn('programs', 'card_bg_image')) {
                $table->dropColumn('card_bg_image');
            }
        });
    }
};
