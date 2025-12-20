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

        $pendingCount = Review::where('reviewer_id', $reviewer->id)
            ->whereNull('rating')
            ->whereNull('comments')
            ->count();

        $inProgressCount = Review::where('reviewer_id', $reviewer->id)
            ->whereNotNull('comments')
            ->whereNull('rating')
            ->count();

        $completedCount = Review::where('reviewer_id', $reviewer->id)
            ->whereNotNull('rating')
            ->count();

        $totalCount = Review::where('reviewer_id', $reviewer->id)->count();

        $recentReviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category'
        ])
        ->where('reviewer_id', $reviewer->id)
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







