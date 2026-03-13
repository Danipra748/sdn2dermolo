<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('no')->nullable();
            $table->string('nama')->nullable();
            $table->string('nip')->nullable();
            $table->string('karpeg')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('gender', 5)->nullable();
            $table->string('jabatan')->nullable();
            $table->string('tempat_tgl_lahir')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('mulai_bekerja_permulaan')->nullable();
            $table->string('mulai_bekerja_di_sini')->nullable();
            $table->string('masa_kerja_th')->nullable();
            $table->string('masa_kerja_bl')->nullable();
            $table->string('gol')->nullable();
            $table->string('tmt')->nullable();
            $table->string('gaji_pokok')->nullable();
            $table->string('gr_kls_mp')->nullable();
            $table->string('absen_s')->nullable();
            $table->string('absen_i')->nullable();
            $table->string('absen_a')->nullable();
            $table->string('sk_akhir_tanggal')->nullable();
            $table->string('sertifikasi_nmr_psrt')->nullable();
            $table->string('sertifikasi_tahun')->nullable();
            $table->string('sertifikasi_nrg')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
