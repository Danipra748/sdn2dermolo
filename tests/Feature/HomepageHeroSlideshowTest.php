<?php

namespace Tests\Feature;

use App\Models\HomepageSection;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HomepageHeroSlideshowTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('homepage_sections');
        Schema::dropIfExists('gurus');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('gurus', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('no')->nullable();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->decimal('school_latitude', 10, 8)->nullable();
            $table->decimal('school_longitude', 11, 8)->nullable();
            $table->unsignedSmallInteger('map_zoom')->nullable();
            $table->timestamps();
        });

        Schema::create('homepage_sections', function (Blueprint $table): void {
            $table->id();
            $table->string('section_key', 50)->unique();
            $table->string('section_name', 100);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('background_image')->nullable();
            $table->decimal('background_overlay_opacity', 3, 2)->default(0.40);
            $table->json('extra_data')->nullable();
            $table->timestamps();
        });
    }

    public function test_save_selected_images_sets_primary_and_slideshow_images(): void
    {
        $this->actingAs(User::factory()->create());

        $hero = $this->createHeroSection();

        $response = $this->postJson(route('admin.homepage.media.save-selected', [
            'sectionKey' => $hero->section_key,
        ]), [
            'selected_images' => [
                'homepage-backgrounds/hero-1.jpg',
                'homepage-backgrounds/hero-2.jpg',
                'homepage-backgrounds/hero-3.jpg',
            ],
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'count' => 3,
            ]);

        $hero->refresh();

        $this->assertSame('homepage-backgrounds/hero-1.jpg', $hero->background_image);
        $this->assertSame([
            'homepage-backgrounds/hero-2.jpg',
            'homepage-backgrounds/hero-3.jpg',
        ], $hero->extra_data['slideshow_images']);
    }

    public function test_update_preserves_existing_slideshow_images_when_extra_data_json_omits_them(): void
    {
        $this->actingAs(User::factory()->create());

        $hero = $this->createHeroSection([
            'background_image' => 'homepage-backgrounds/hero-1.jpg',
            'extra_data' => [
                'badge_text' => 'Badge Lama',
                'slideshow_images' => [
                    'homepage-backgrounds/hero-2.jpg',
                    'homepage-backgrounds/hero-3.jpg',
                ],
            ],
        ]);

        $response = $this->put(route('admin.homepage.update', [
            'sectionKey' => $hero->section_key,
        ]), [
            'title' => 'Judul Baru',
            'subtitle' => 'Subtitle Baru',
            'description' => 'Deskripsi baru untuk hero.',
            'background_overlay_opacity' => 0.55,
            'extra_data' => json_encode([
                'badge_text' => 'Badge Baru',
            ]),
        ]);

        $response->assertRedirect(route('admin.homepage.index'));

        $hero->refresh();

        $this->assertSame('Judul Baru', $hero->title);
        $this->assertSame('Subtitle Baru', $hero->subtitle);
        $this->assertSame('Deskripsi baru untuk hero.', $hero->description);
        $this->assertSame('Badge Baru', $hero->extra_data['badge_text']);
        $this->assertSame([
            'homepage-backgrounds/hero-2.jpg',
            'homepage-backgrounds/hero-3.jpg',
        ], $hero->extra_data['slideshow_images']);
    }

    public function test_homepage_renders_a_slide_for_each_saved_hero_image(): void
    {
        $this->createHeroSection([
            'background_image' => 'homepage-backgrounds/hero-1.jpg',
            'extra_data' => [
                'slideshow_images' => [
                    'homepage-backgrounds/hero-2.jpg',
                    'homepage-backgrounds/hero-3.jpg',
                ],
            ],
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('data-slide-index="0"', false);
        $response->assertSee('data-slide-index="1"', false);
        $response->assertSee('data-slide-index="2"', false);
        $response->assertSee('storage/homepage-backgrounds/hero-1.jpg', false);
        $response->assertSee('storage/homepage-backgrounds/hero-2.jpg', false);
        $response->assertSee('storage/homepage-backgrounds/hero-3.jpg', false);

        $this->assertSame(3, substr_count($response->getContent(), 'class="hero-slide '));
    }

    private function createHeroSection(array $overrides = []): HomepageSection
    {
        return HomepageSection::create(array_merge([
            'section_key' => 'hero',
            'section_name' => 'Hero Section',
            'is_active' => true,
            'display_order' => 1,
            'title' => 'SD N 2 Dermolo',
            'subtitle' => 'Unggul dan Berkarakter',
            'description' => 'Sekolah dasar yang berkomitmen memberikan pendidikan terbaik.',
            'background_image' => null,
            'background_overlay_opacity' => 0.40,
            'extra_data' => [],
        ], $overrides));
    }
}
