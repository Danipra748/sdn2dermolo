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

            \Log::info('=== LOGO UPLOAD DEBUG START ===');
            \Log::info('Profile ID: ' . $profile->id);
            \Log::info('Has file: ' . ($request->hasFile('logo') ? 'YES' : 'NO'));

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

                // Logo
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            ]);

            // Handle logo upload with production-ready error handling
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                
                \Log::info('File details:');
                \Log::info('- Name: ' . $file->getClientOriginalName());
                \Log::info('- Size: ' . $file->getSize());
                \Log::info('- MIME: ' . $file->getMimeType());
                \Log::info('- Valid: ' . ($file->isValid() ? 'YES' : 'NO'));
                
                if (!$file->isValid()) {
                    \Log::error('File upload failed - file is not valid');
                    return redirect()->back()
                        ->with('error', 'File upload gagal. File tidak valid.');
                }
                
                // Delete old logo
                if ($profile->logo) {
                    $oldPath = storage_path('app/public/' . $profile->logo);
                    \Log::info('Old logo path: ' . $oldPath);
                    \Log::info('Old logo exists: ' . (file_exists($oldPath) ? 'YES' : 'NO'));
                    
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                        \Log::info('Old logo deleted successfully');
                    } else {
                        \Log::warning('Old logo file does not exist: ' . $oldPath);
                    }
                }
                
                // Ensure directory exists (important for production)
                $directory = storage_path('app/public/school-profile');
                \Log::info('Target directory: ' . $directory);
                \Log::info('Directory exists: ' . (is_dir($directory) ? 'YES' : 'NO'));
                
                if (!is_dir($directory)) {
                    mkdir($directory, 0775, true);
                    \Log::info('Directory created: ' . $directory);
                }
                
                // Upload new logo
                $path = $file->store('school-profile', 'public');
                \Log::info('New logo stored at: ' . $path);
                
                // Verify file was saved successfully
                $fullPath = storage_path('app/public/' . $path);
                \Log::info('Full path: ' . $fullPath);
                \Log::info('File exists after upload: ' . (file_exists($fullPath) ? 'YES' : 'NO'));
                \Log::info('File size: ' . (file_exists($fullPath) ? filesize($fullPath) : 'N/A'));
                
                if (!file_exists($fullPath)) {
                    \Log::error('File does not exist after upload! Path: ' . $fullPath);
                    return redirect()->back()
                        ->with('error', 'Gagal menyimpan file. Periksa permission folder storage.');
                }
                
                // Set correct permissions for Linux production servers
                chmod($fullPath, 0664);
                \Log::info('File permissions set to 0664');
                
                $validated['logo'] = $path;
            }

            // Handle missions (from mission_items array)
            if ($request->has('mission_items')) {
                // Filter out empty mission items
                $missions = array_filter($request->input('mission_items'), function($item) {
                    return !empty(trim($item));
                });
                $validated['missions'] = array_values($missions);
            }

            // Update profile
            \Log::info('Updating profile with data:');
            \Log::info(json_encode($validated));
            
            $updated = $profile->update($validated);
            
            \Log::info('Update result: ' . ($updated ? 'SUCCESS' : 'FAILED'));
            \Log::info('=== LOGO UPLOAD DEBUG END ===');

            if (!$updated) {
                \Log::error('Database update failed');
                return redirect()->back()
                    ->with('error', 'Gagal menyimpan ke database. Pastikan kolom logo ada di tabel.');
            }

            return redirect()->route('admin.school-profile.edit')
                ->with('success', 'Profil sekolah berhasil diperbarui!');
                
        } catch (\Exception $e) {
            \Log::error('=== EXCEPTION CAUGHT ===');
            \Log::error('Message: ' . $e->getMessage());
            \Log::error('File: ' . $e->getFile());
            \Log::error('Line: ' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());
            \Log::error('=== EXCEPTION END ===');
            
            return redirect()->back()
                ->with('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    /**
     * Delete logo
     */
    public function deleteLogo()
    {
        $profile = SchoolProfile::getOrCreate();

        if ($profile->logo) {
            // Delete file from storage
            $path = storage_path('app/public/' . $profile->logo);
            if (file_exists($path)) {
                @unlink($path);
            }
            
            $profile->update(['logo' => null]);
        }

        return response()->json(['success' => true]);
    }
}
