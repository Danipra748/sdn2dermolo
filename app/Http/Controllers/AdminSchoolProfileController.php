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
            
            // Logo
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            
            $validated['logo'] = $request->file('logo')->store('school-profile', 'public');
        }

        // Handle missions (from mission_items array)
        if ($request->has('mission_items')) {
            // Filter out empty mission items
            $missions = array_filter($request->input('mission_items'), function($item) {
                return !empty(trim($item));
            });
            $validated['missions'] = array_values($missions);
        }

        $profile->update($validated);

        return redirect()->route('admin.school-profile.edit')
            ->with('success', 'Profil sekolah berhasil diperbarui!');
    }

    /**
     * Delete logo
     */
    public function deleteLogo()
    {
        $profile = SchoolProfile::getOrCreate();
        
        if ($profile->logo) {
            Storage::disk('public')->delete($profile->logo);
            $profile->update(['logo' => null]);
        }

        return response()->json(['success' => true]);
    }
}
