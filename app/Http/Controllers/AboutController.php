<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use App\Support\SchoolConfig;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display about page
     */
    public function index()
    {
        $profile = SchoolProfile::getOrCreate();
        
        // Get contact info from static config
        $kontak = SchoolConfig::contact();
        $alamatLines = SchoolConfig::addressLines();
        $mapsEmbed = SchoolConfig::mapsEmbed();
        $mapsOpen = SchoolConfig::mapsOpen();

        return view('about.index', compact('profile', 'mapsEmbed', 'mapsOpen', 'alamatLines'));
    }
}
