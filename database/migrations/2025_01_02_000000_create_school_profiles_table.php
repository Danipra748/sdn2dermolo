<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('school_profiles')) {
            return;
        }

        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->default('SD N 2 Dermolo');
            $table->string('npsn', 20)->nullable();
            $table->string('school_status')->default('Negeri');
            $table->string('accreditation')->default('B');
            $table->text('address')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->default('Jepara');
            $table->string('province')->default('Jawa Tengah');
            $table->string('postal_code', 10)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('history_content')->nullable();
            $table->integer('established_year')->nullable();
            $table->string('land_area')->nullable();
            $table->string('building_area')->nullable();
            $table->integer('total_classes')->nullable();
            $table->integer('total_students')->nullable();
            $table->integer('total_teachers')->nullable();
            $table->integer('total_staff')->nullable();
            $table->text('vision')->nullable();
            $table->json('missions')->nullable();
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->timestamps();
        });

        DB::table('school_profiles')->insert([
            'school_name' => 'SD N 2 Dermolo',
            'npsn' => '20318087',
            'school_status' => 'Negeri',
            'accreditation' => 'B',
            'address' => 'Desa Dermolo',
            'village' => 'Dermolo',
            'district' => 'Kembang',
            'city' => 'Jepara',
            'province' => 'Jawa Tengah',
            'postal_code' => '59453',
            'phone' => '(0291) 123-456',
            'email' => 'sdn2dermolo@gmail.com',
            'history_content' => "SD N 2 Dermolo adalah lembaga pendidikan dasar yang berkomitmen memberikan pendidikan berkualitas tinggi.\n\nKami terus berinovasi menghadirkan metode pembelajaran yang efektif dan menyenangkan.",
            'established_year' => 1975,
            'land_area' => '1.400 m2',
            'total_classes' => 12,
            'vision' => 'Terwujudnya peserta didik yang beriman, berakhlak mulia, berprestasi, berbudaya, dan berwawasan lingkungan.',
            'missions' => json_encode([
                'Menyelenggarakan pendidikan berkualitas dengan kurikulum terkini.',
                'Mengembangkan karakter siswa yang berakhlak mulia.',
                'Menciptakan lingkungan belajar yang nyaman dan inspiratif.',
                'Meningkatkan prestasi akademik dan non-akademik siswa.',
                'Membina kerja sama yang baik dengan orang tua dan masyarakat.',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
