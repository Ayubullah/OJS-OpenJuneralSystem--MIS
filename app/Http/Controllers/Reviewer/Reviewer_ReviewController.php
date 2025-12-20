<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reviewer_ReviewController extends Controller
{
    /**
     * Display a listing of all reviews.
     */
    public function index()
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.dashboard')
                ->with('error', 'Reviewer profile not found.');
        }

        $reviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category',
            'submission.author'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->latest()
        ->paginate(15);

        return view('reviewer.reviews.index', compact('reviews'));
    }

    /**
     * Display pending reviews.
     */
    public function pending()
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.dashboard')
                ->with('error', 'Reviewer profile not found.');
        }

        $reviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category',
            'submission.author'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->whereNull('rating')
        ->whereNull('comments')
        ->latest()
        ->paginate(15);

        return view('reviewer.reviews.pending', compact('reviews'));
    }

    /**
     * Display in-progress reviews.
     */
    public function inProgress()
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.dashboard')
                ->with('error', 'Reviewer profile not found.');
        }

        $reviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category',
            'submission.author'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->whereNotNull('comments')
        ->whereNull('rating')
        ->latest()
        ->paginate(15);

        return view('reviewer.reviews.in-progress', compact('reviews'));
    }

    /**
     * Display completed reviews.
     */
    public function completed()
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.dashboard')
                ->with('error', 'Reviewer profile not found.');
        }

        $reviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category',
            'submission.author'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->whereNotNull('rating')
        ->latest()
        ->paginate(15);

        return view('reviewer.reviews.completed', compact('reviews'));
    }

    /**
     * Display the specified review.
     */
    public function show($id)
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.dashboard')
                ->with('error', 'Reviewer profile not found.');
        }

        $review = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category',
            'submission.author'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->findOrFail($id);

        return view('reviewer.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit($id)
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.dashboard')
                ->with('error', 'Reviewer profile not found.');
        }

        $review = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category',
            'submission.author'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->findOrFail($id);

        return view('reviewer.reviews.show', compact('review'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, $id)
    {
        $reviewer = Auth::user()->reviewer;
        
        if (!$reviewer) {
            return redirect()->route('reviewer.dashboard')
                ->with('error', 'Reviewer profile not found.');
        }

        $review = Review::where('reviewer_id', $reviewer->id)
            ->findOrFail($id);

        $request->validate([
            'rating' => 'nullable|numeric|min:0|max:10',
            'comments' => 'required|string|min:10',
        ]);

        DB::beginTransaction();
        try {
            // Update review
            $review->update([
                'rating' => $request->rating,
                'comments' => $request->comments,
            ]);

            // Get submission and reload to get fresh reviews data
            $submission = $review->submission;
            $submission->load('reviews'); // Reload reviews to get latest data
            $allReviews = $submission->reviews;
            
            // Check if all reviews have been completed (have ratings)
            $completedReviews = $allReviews->whereNotNull('rating');
            $totalReviews = $allReviews->count();
            
            // Check if all reviewers have given a rating of 10
            $allRatedTen = $completedReviews->count() > 0 
                && $completedReviews->count() === $totalReviews 
                && $completedReviews->every(function($review) {
                    return (float)$review->rating == 10.0;
                });

            // Update submission status
            if ($allRatedTen && $submission->status !== 'accepted' && $submission->status !== 'rejected') {
                // All reviewers gave 10/10 - auto-accept
                $submission->update(['status' => 'accepted']);
            } elseif ($submission->status !== 'under_review' && $submission->status !== 'accepted' && $submission->status !== 'rejected') {
                // Normal case - set to under_review
                $submission->update(['status' => 'under_review']);
            }

            // Update article status
            $article = $submission->article;
            if ($article) {
                if ($allRatedTen && $article->status !== 'accepted' && $article->status !== 'rejected' && $article->status !== 'published') {
                    // All reviewers gave 10/10 - auto-accept
                    $article->update(['status' => 'accepted']);
                } elseif ($article->status !== 'under_review' && $article->status !== 'accepted' && $article->status !== 'rejected' && $article->status !== 'published') {
                    // Normal case - set to under_review
                    $article->update(['status' => 'under_review']);
                }
            }

            DB::commit();

            $successMessage = $allRatedTen 
                ? 'Review submitted successfully! All reviewers have given a perfect score (10/10). The article status has been automatically updated to "Accepted".'
                : 'Review submitted successfully! The article status has been updated to "Under Review".';

            return redirect()->route('reviewer.reviews.show', $review->id)
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error submitting review: ' . $e->getMessage())
                ->withInput();
        }
    }
}







