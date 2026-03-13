<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('desc')->nullable();
            $table->string('emoji', 10)->nullable();
            $table->string('hero_color')->nullable();
            $table->timestamps();
        });

        DB::table('programs')->insert([
            [
                'slug' => 'pramuka',
                'title' => 'Ekstra Pramuka',
                'desc' => 'Program pembinaan karakter, kemandirian, kepemimpinan, dan kerja sama tim melalui kegiatan kepramukaan rutin.',
                'emoji' => 'P',
                'hero_color' => 'from-blue-600 to-sky-600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'seni-ukir',
                'title' => 'Seni Ukir',
                'desc' => 'Program pengembangan kreativitas siswa melalui keterampilan seni ukir dengan mengenalkan motif lokal dan teknik dasar.',
                'emoji' => 'U',
                'hero_color' => 'from-emerald-600 to-green-700',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'drumband',
                'title' => 'Drumband',
                'desc' => 'Program ekstrakurikuler musik baris-berbaris untuk melatih disiplin, kekompakan, ritme, dan kepercayaan diri siswa.',
                'emoji' => 'D',
                'hero_color' => 'from-amber-500 to-orange-600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
