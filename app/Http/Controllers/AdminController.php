<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Support\SchoolData;
use App\Models\Guru;
use App\Models\Program;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Basic Stats
        $fasilitasCount = Schema::hasTable('fasilitas') ? Fasilitas::count() : 0;
        $guruCount = Schema::hasTable('gurus') ? Guru::count() : 0;
        $programCount = Schema::hasTable('programs') ? Program::count() : 0;
        
        $stats = [
            'total_fasilitas' => $fasilitasCount,
            'total_guru' => $guruCount,
            'total_program' => $programCount,
        ];

        // Article Stats
        if (Schema::hasTable('articles')) {
            $stats['total_articles'] = Article::count();
            $stats['published_articles'] = Article::where('status', 'published')->count();
            $stats['draft_articles'] = $stats['total_articles'] - $stats['published_articles'];
            
            // Recent Articles
            $recentArticles = Article::latest()->take(5)->get();
        } else {
            $recentArticles = collect();
        }

        // Message Stats
        if (Schema::hasTable('contact_messages')) {
            $stats['total_messages'] = ContactMessage::count();
            $stats['unread_messages'] = ContactMessage::where('is_read', false)->count();
        }

        // Chart Data: News Views (Last 7 Days)
        $chartData = $this->getChartData();

        return view('admin.dashboard', compact('stats', 'recentArticles', 'chartData'));
    }

    private function getChartData(): array
    {
        if (!Schema::hasTable('article_views')) {
            return [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'data' => [0, 0, 0, 0, 0, 0, 0]
            ];
        }

        $days = collect();
        $views = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days->push($date->format('D'));
            
            $count = ArticleView::whereDate('created_at', $date->toDateString())->count();
            $views->push($count);
        }

        return [
            'labels' => $days->all(),
            'data' => $views->all()
        ];
    }
}
