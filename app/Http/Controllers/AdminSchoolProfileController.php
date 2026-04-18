<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSchoolProfileController extends Controller
{
    /**
     * Display school profile edit page
     */
    public function edit()
    {
        $profile = SchoolProfile::getOrCreate();
        return view('admin.school-profile.edit', compact('profile'));
    }

    /**
     * Update school profile
     */
    public function update(Request $request)
    {
        try {
            $profile = SchoolProfile::getOrCreate();

            $validated = $request->validate([
                // Basic Info
                'school_name' => 'nullable|string|max:255',
                'npsn' => 'nullable|string|max:20',
                'school_status' => 'nullable|string|max:50',
                'accreditation' => 'nullable|string|max:10',

                // Address
                'address' => 'nullable|string',
                'village' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'province' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:10',

                // Contact
                'phone' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'website' => 'nullable|url|max:255',

                // History & Stats
                'history_content' => 'nullable|string',
                'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
                'land_area' => 'nullable|string|max:50',
                'total_classes' => 'nullable|integer|min:0',

                // Vision & Mission
                'vision' => 'nullable|string',
                'missions' => 'nullable|array',
                'mission_items' => 'nullable|array',

                // Logo inputs
                'logo_raw' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
                'crop_x' => 'nullable|numeric',
                'crop_y' => 'nullable|numeric',
                'crop_w' => 'nullable|numeric',
                'crop_h' => 'nullable|numeric',
            ]);

            // Handle logo upload - only process if file is present
            if ($request->hasFile('logo_raw')) {
                $file = $request->file('logo_raw');

                if (!$file->isValid()) {
                    return redirect()->back()
                        ->with('error', 'File upload gagal. File tidak valid.');
                }

                // Delete old logo if exists
                if ($profile->logo) {
                    $this->deletePhysicalFile($profile->logo, 'public');
                }

                // Process and save logo
                $cropData = [
                    'x' => $request->input('crop_x'),
                    'y' => $request->input('crop_y'),
                    'w' => $request->input('crop_w'),
                    'h' => $request->input('crop_h'),
                ];

                $logoPath = $this->processLogo($file, $cropData);
                if ($logoPath) {
                    $validated['logo'] = $logoPath;
                }
            }

            // Handle missions (from mission_items array)
            if ($request->has('mission_items')) {
                $missions = array_filter($request->input('mission_items'), function($item) {
                    return !empty(trim($item));
                });
                $validated['missions'] = array_values($missions);
            }

            // Update profile - only update fields that were sent
            $profile->update($validated);

            return redirect()->route('admin.school-profile.edit')
                ->with('success', 'Profil sekolah berhasil diperbarui!');

        } catch (\Exception $e) {
            \Log::error('School profile update error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    public function deleteLogo()
    {
        $profile = SchoolProfile::getOrCreate();

        if ($profile->logo) {
            // Delete file from storage (using base controller method)
            $this->deletePhysicalFile($profile->logo, 'public');

            // Set logo to null (DON'T delete row)
            $profile->update(['logo' => null]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Process logo: crop and convert to WebP and ICO
     */
    private function processLogo($file, $cropData): ?string
    {
        try {
            $extension = $file->getClientOriginalExtension();
            $path = $file->getRealPath();

            // Load image based on extension
            switch (strtolower($extension)) {
                case 'jpeg':
                case 'jpg':
                    $src = imagecreatefromjpeg($path);
                    break;
                case 'png':
                    $src = imagecreatefrompng($path);
                    break;
                case 'webp':
                    $src = imagecreatefromwebp($path);
                    break;
                default:
                    return null;
            }

            if (!$src) return null;

            // Perform crop
            $cropped = imagecreatetruecolor($cropData['w'], $cropData['h']);
            
            // Handle transparency for PNG/WebP
            imagealphablending($cropped, false);
            imagesavealpha($cropped, true);
            $transparent = imagecolorallocatealpha($cropped, 255, 255, 255, 127);
            imagefilledrectangle($cropped, 0, 0, $cropData['w'], $cropData['h'], $transparent);

            imagecopyresampled(
                $cropped, $src,
                0, 0,
                $cropData['x'], $cropData['y'],
                $cropData['w'], $cropData['h'],
                $cropData['w'], $cropData['h']
            );

            // Resize to standard logo size (512x512)
            $finalSize = 512;
            $finalLogo = imagecreatetruecolor($finalSize, $finalSize);
            imagealphablending($finalLogo, false);
            imagesavealpha($finalLogo, true);
            imagecopyresampled(
                $finalLogo, $cropped,
                0, 0, 0, 0,
                $finalSize, $finalSize,
                $cropData['w'], $cropData['h']
            );

            // Ensure directory exists
            $directory = 'school-profile';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Save as WebP
            $filename = 'logo_' . time() . '.webp';
            $fullPath = storage_path('app/public/' . $directory . '/' . $filename);
            imagewebp($finalLogo, $fullPath, 90);

            // Save as ICO (favicon replacement)
            // For favicon, we resize to 48x48
            $favSize = 48;
            $favicon = imagecreatetruecolor($favSize, $favSize);
            imagealphablending($favicon, false);
            imagesavealpha($favicon, true);
            imagecopyresampled(
                $favicon, $finalLogo,
                0, 0, 0, 0,
                $favSize, $favSize,
                $finalSize, $finalSize
            );
            
            // Save as PNG in the school-profile directory
            $favFilename = 'favicon_' . time() . '.png';
            $favPath = storage_path('app/public/' . $directory . '/' . $favFilename);
            imagepng($favicon, $favPath);

            // Clean up
            imagedestroy($src);
            imagedestroy($cropped);
            imagedestroy($finalLogo);
            imagedestroy($favicon);

            // Return the logo path, but we also need to store the favicon path.
            // Since SchoolProfile only has one 'logo' column, let's store 
            // the favicon path in a SiteSetting or update the model if needed.
            // However, to keep it simple, we can derive the favicon from the logo 
            // if we use a consistent naming convention, OR we just update 
            // the favicon.png in a fixed location.
            
            // Let's use a fixed location in storage for favicon to make it easy for the blade:
            $fixedFavPath = storage_path('app/public/school-profile/favicon-dynamic.png');
            if (file_exists($favPath)) {
                copy($favPath, $fixedFavPath);
            }

            return $directory . '/' . $filename;

        } catch (\Exception $e) {
            \Log::error('Logo processing error: ' . $e->getMessage());
            return null;
        }
    }
}
