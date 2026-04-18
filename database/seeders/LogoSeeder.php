<?php

namespace Database\Seeders;

use App\Models\SchoolProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profile = SchoolProfile::getOrCreate();

        // Path to the source image (tut wuri raw)
        $sourcePath = database_path('seeders/images/logo/tut-wuri-raw.png');

        // Fallback to the other file if tut-wuri-raw doesn't exist
        if (! File::exists($sourcePath)) {
            $sourcePath = database_path('seeders/images/logo/logo-tut-wuri-handayani.png');
        }

        if (File::exists($sourcePath)) {
            $directory = 'school-profile';
            if (! Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $filename = 'logo_default.png';
            $targetPath = $directory.'/'.$filename;

            // Always update logo_default.png from the raw source
            Storage::disk('public')->put($targetPath, File::get($sourcePath));

            if (! $profile->logo) {
                $profile->update([
                    'logo' => $targetPath,
                ]);
            }

            // Also copy to favicon-dynamic.png for consistency in the correct folder
            $dynamicFavPath = 'school-profile/favicon-dynamic.png';
            Storage::disk('public')->put($dynamicFavPath, File::get($sourcePath));

            $this->command->info('Logo and favicon successfully seeded.');
        } else {
            $this->command->info('Logo already exists or source image not found.');
        }
    }
}
