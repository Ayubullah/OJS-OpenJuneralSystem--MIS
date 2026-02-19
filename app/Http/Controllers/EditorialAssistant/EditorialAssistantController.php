<?php

namespace App\Http\Controllers\EditorialAssistant;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Submission;
use App\Models\EditorialAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditorialAssistantController extends Controller
{
    /**
     * Get journal IDs for the current editorial assistant
     */
    protected function getEditorialAssistantJournalIds()
    {
        $editorialAssistants = EditorialAssistant::where('user_id', Auth::id())
            ->where('status', 'active')
            ->get();
        
        // If any record has null journal_id, they have access to all journals
        $hasAllJournals = $editorialAssistants->contains(function($assistant) {
            return $assistant->journal_id === null;
        });
        
        if ($hasAllJournals) {
            return null; // null means all journals
        }
        
        // Otherwise, return array of specific journal IDs
        $journalIds = $editorialAssistants->pluck('journal_id')->filter()->toArray();
        return !empty($journalIds) ? $journalIds : null;
    }

    /**
     * Display the dashboard.
     */
    public function index()
    {
        $journalIds = $this->getEditorialAssistantJournalIds();
        
        // Build query for accepted articles
        $articlesQuery = Article::where('status', 'accepted');
        $submissionsQuery = Submission::where('status', 'accepted');
        
        // Filter by journal if assigned to specific journals
        if ($journalIds !== null) {
            $articlesQuery->whereIn('journal_id', $journalIds);
            $submissionsQuery->whereHas('article', function($q) use ($journalIds) {
                $q->whereIn('journal_id', $journalIds);
            });
        }

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
        $monthlyQuery = Article::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->where('status', 'accepted')
            ->where('created_at', '>=', now()->subMonths(6));
        
        if ($journalIds !== null) {
            $monthlyQuery->whereIn('journal_id', $journalIds);
        }
        
        $monthly_accepted = $monthlyQuery
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Accepted articles by journal
        $journalStatsQuery = Article::select('journal_id', DB::raw('count(*) as total'))
            ->where('status', 'accepted');
        
        if ($journalIds !== null) {
            $journalStatsQuery->whereIn('journal_id', $journalIds);
        }
        
        $accepted_by_journal = $journalStatsQuery
            ->with('journal:id,name')
            ->groupBy('journal_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Get journal names for the editorial assistant
        $journalNames = [];
        if ($journalIds === null) {
            $journalNames = ['All Journals'];
        } else {
            $journalNames = \App\Models\Journal::whereIn('id', $journalIds)
                ->where('status', 'active')
                ->pluck('name')
                ->toArray();
        }

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

