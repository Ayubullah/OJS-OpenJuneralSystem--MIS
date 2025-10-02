<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Submission;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_journals' => Journal::count(),
            'total_articles' => Article::count(),
            'total_submissions' => Submission::count(),
            'pending_reviews' => Review::whereNull('rating')->count(),
            'published_articles' => Article::where('status', 'published')->count(),
        ];

        // Get recent submissions
        $recent_submissions = Submission::with(['article', 'author'])
            ->latest()
            ->limit(5)
            ->get();

        // Get articles by status
        $articles_by_status = Article::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Get monthly submission trends (last 6 months)
        $monthly_submissions = Submission::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get top journals by article count
        $top_journals = Journal::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_submissions',
            'articles_by_status',
            'monthly_submissions',
            'top_journals'
        ));
    }
}
