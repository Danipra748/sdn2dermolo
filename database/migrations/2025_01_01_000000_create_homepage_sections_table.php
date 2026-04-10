<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 50)->unique();
            $table->string('section_name', 100);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            
            // Content Fields
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->text('description')->nullable();
            
            // Media
            $table->string('background_image')->nullable();
            $table->decimal('background_overlay_opacity', 3, 2)->default(0.40);
            
            // Flexible Data
            $table->json('extra_data')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_sections');
    }
};
