<?php

namespace App\Http\Controllers;

use App\Models\HomepageSection;
use Illuminate\Http\Request;

class AdminHomepageController extends Controller
{
    /**
     * Show homepage settings dashboard - Read-only static info
     */
    public function index()
    {
        // Get hero section from database (if table exists)
        $hero = null;
        if (\Illuminate\Support\Facades\Schema::hasTable('homepage_sections')) {
            $hero = HomepageSection::getHero();
        }

        // Get static config data
        $staticHero = \App\Support\SchoolConfig::hero();

        return view('admin.homepage.index', compact('hero', 'staticHero'));
    }
}
