<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    /**
     * Display the reviewer dashboard.
     */
    public function index()
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return view('reviewer.dashboard', [
                'pendingCount' => 0,
                'inProgressCount' => 0,
                'completedCount' => 0,
                'totalCount' => 0,
                'recentReviews' => collect([])
            ]);
        }

        // Filter by reviewer's journal
        $journalFilter = function($query) use ($reviewer) {
            if ($reviewer->journal_id) {
                $query->whereHas('submission.article', function($q) use ($reviewer) {
                    $q->where('journal_id', $reviewer->journal_id);
                });
            }
        };

        $pendingCount = Review::where('reviewer_id', $reviewer->id)
            ->whereNull('rating')
            ->whereNull('comments')
            ->whereHas('submission.article', function($q) use ($reviewer) {
                if ($reviewer->journal_id) {
                    $q->where('journal_id', $reviewer->journal_id);
                }
            })
            ->count();

        $inProgressCount = Review::where('reviewer_id', $reviewer->id)
            ->whereNotNull('comments')
            ->whereNull('rating')
            ->whereHas('submission.article', function($q) use ($reviewer) {
                if ($reviewer->journal_id) {
                    $q->where('journal_id', $reviewer->journal_id);
                }
            })
            ->count();

        $completedCount = Review::where('reviewer_id', $reviewer->id)
            ->whereNotNull('rating')
            ->whereHas('submission.article', function($q) use ($reviewer) {
                if ($reviewer->journal_id) {
                    $q->where('journal_id', $reviewer->journal_id);
                }
            })
            ->count();

        $totalCount = Review::where('reviewer_id', $reviewer->id)
            ->whereHas('submission.article', function($q) use ($reviewer) {
                if ($reviewer->journal_id) {
                    $q->where('journal_id', $reviewer->journal_id);
                }
            })
            ->count();

        $recentReviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->whereHas('submission.article', function($q) use ($reviewer) {
            if ($reviewer->journal_id) {
                $q->where('journal_id', $reviewer->journal_id);
            }
        })
        ->latest()
        ->limit(5)
        ->get();

        return view('reviewer.dashboard', compact(
            'pendingCount',
            'inProgressCount',
            'completedCount',
            'totalCount',
            'recentReviews'
        ));
    }
}







