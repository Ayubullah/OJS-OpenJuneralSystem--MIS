<?php

namespace App\Http\Controllers\EditorialAssistant;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;

class EditorialAssistantController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Build query for accepted articles - all accepted and approved_chief_editor articles visible to editorial assistants
        $articlesQuery = Article::whereIn('status', ['accepted', 'approved_chief_editor']);
        $submissionsQuery = Submission::whereIn('status', ['accepted', 'approved_chief_editor']);

        // Statistics for accepted articles
        $stats = [
            'total_accepted' => (clone $articlesQuery)->count(),
            'total_accepted_submissions' => (clone $submissionsQuery)->count(),
            'recent_accepted' => (clone $articlesQuery)
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
        ];

        // Recent accepted articles
        $recent_accepted_articles = (clone $articlesQuery)
            ->with(['journal', 'author', 'category'])
            ->latest()
            ->limit(10)
            ->get();

        // Recent accepted submissions
        $recent_accepted_submissions = (clone $submissionsQuery)
            ->with(['article.journal', 'article.author', 'author'])
            ->latest()
            ->limit(10)
            ->get();

        // Monthly accepted articles trend (last 6 months)
        $monthly_accepted = Article::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->whereIn('status', ['accepted', 'approved_chief_editor'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Accepted articles by journal
        $accepted_by_journal = Article::select('journal_id', DB::raw('count(*) as total'))
            ->whereIn('status', ['accepted', 'approved_chief_editor'])
            ->with('journal:id,name')
            ->groupBy('journal_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // All journals - editorial assistants see all accepted articles
        $journalNames = ['All Journals'];

        return view('editorial_assistant.dashboard', compact(
            'stats',
            'recent_accepted_articles',
            'recent_accepted_submissions',
            'monthly_accepted',
            'accepted_by_journal',
            'journalNames'
        ));
    }
}

