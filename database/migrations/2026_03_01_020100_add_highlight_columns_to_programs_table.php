<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            if (! Schema::hasColumn('programs', 'highlight_1')) {
                $table->text('highlight_1')->nullable()->after('desc');
            }
            if (! Schema::hasColumn('programs', 'highlight_2')) {
                $table->text('highlight_2')->nullable()->after('highlight_1');
            }
            if (! Schema::hasColumn('programs', 'highlight_3')) {
                $table->text('highlight_3')->nullable()->after('highlight_2');
            }
        });

        DB::table('programs')->where('slug', 'pramuka')->update([
            'highlight_1' => 'Latihan rutin baris-berbaris, tali-temali, dan penjelajahan.',
            'highlight_2' => 'Pembentukan nilai disiplin, tanggung jawab, dan kerja sama.',
            'highlight_3' => 'Kegiatan perkemahan untuk melatih kemandirian siswa.',
        ]);

        DB::table('programs')->where('slug', 'seni-ukir')->update([
            'highlight_1' => 'Pengenalan motif ukir lokal dan unsur seni rupa dasar.',
            'highlight_2' => 'Praktik teknik ukir sederhana sesuai usia siswa.',
            'highlight_3' => 'Pembiasaan ketelitian, kesabaran, dan estetika karya.',
        ]);

        DB::table('programs')->where('slug', 'drumband')->update([
            'highlight_1' => 'Latihan rutin ritme, tempo, dan formasi baris-berbaris.',
            'highlight_2' => 'Pembagian peran alat musik untuk melatih koordinasi tim.',
            'highlight_3' => 'Persiapan tampil pada kegiatan sekolah dan acara resmi.',
        ]);
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $drops = [];
            if (Schema::hasColumn('programs', 'highlight_1')) {
                $drops[] = 'highlight_1';
            }
            if (Schema::hasColumn('programs', 'highlight_2')) {
                $drops[] = 'highlight_2';
            }
            if (Schema::hasColumn('programs', 'highlight_3')) {
                $drops[] = 'highlight_3';
            }

            if (! empty($drops)) {
                $table->dropColumn($drops);
            }
        });
    }
};
