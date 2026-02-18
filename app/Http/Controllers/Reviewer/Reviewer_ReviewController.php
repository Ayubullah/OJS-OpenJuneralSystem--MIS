<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        // Filter reviews by reviewer's journal
        $reviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category',
            'submission.author'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->whereHas('submission.article', function($q) use ($reviewer) {
            if ($reviewer->journal_id) {
                $q->where('journal_id', $reviewer->journal_id);
            }
        })
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
        ->whereHas('submission.article', function($q) use ($reviewer) {
            if ($reviewer->journal_id) {
                $q->where('journal_id', $reviewer->journal_id);
            }
        })
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
        ->whereHas('submission.article', function($q) use ($reviewer) {
            if ($reviewer->journal_id) {
                $q->where('journal_id', $reviewer->journal_id);
            }
        })
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
            'submission.author',
            'reviewer'
        ])
        ->where('reviewer_id', $reviewer->id)
        ->findOrFail($id);

        // Get previous reviews by the same reviewer for the same article (different submissions/versions)
        $previousReviews = Review::with([
                'submission' => function($query) {
                    $query->select('id', 'article_id', 'version_number', 'submission_date', 'status');
                }
            ])
            ->where('reviewer_id', $reviewer->id)
            ->where('submission_id', '!=', $review->submission_id)
            ->whereHas('submission', function($query) use ($review) {
                $query->where('article_id', $review->submission->article_id);
            })
            ->whereNotNull('comments')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get current review's author reply if exists
        $review->load('submission.article');
        
        // Load editor and admin messages for this article (for reviewer)
        $editorMessages = \App\Models\EditorMessage::where('article_id', $review->submission->article_id)
            ->where(function($query) use ($reviewer) {
                $query->where(function($q) use ($reviewer) {
                    $q->where('reviewer_id', $reviewer->id)
                      ->where(function($q2) {
                          $q2->where('recipient_type', 'reviewer')
                            ->orWhere('recipient_type', 'both');
                      });
                })
                ->orWhere(function($q) {
                    // Admin messages sent to all reviewers
                    $q->where('sender_type', 'admin')
                      ->where('recipient_type', 'reviewer');
                });
            })
            ->with(['editor', 'editorRecipient'])
            ->latest()
            ->get();

        return view('reviewer.reviews.show', compact('review', 'previousReviews', 'editorMessages'));
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

        $review = Review::with(['submission.author', 'submission.article', 'reviewer.user'])
            ->where('reviewer_id', $reviewer->id)
            ->findOrFail($id);

        $request->validate([
            'rating' => 'nullable|numeric|min:0|max:10',
            'comments' => 'nullable|string|min:10',
            'review_file' => 'nullable|file|mimes:pdf,doc,docx,txt,rtf|max:10240', // 10MB max
            // General Comments - 6 Questions
            'originality_comment' => 'nullable|string',
            'relationship_to_literature_comment' => 'nullable|string',
            'methodology_comment' => 'nullable|string',
            'results_comment' => 'nullable|string',
            'implications_comment' => 'nullable|string',
            'quality_of_communication_comment' => 'nullable|string',
            // Strengths and Weaknesses
            'strengths' => 'nullable|string',
            'weaknesses' => 'nullable|string',
            // Suggestions for Improvement
            'suggestions_for_improvement' => 'nullable|string',
            // Paper Score
            'relevance_score' => 'nullable|numeric|min:0|max:5',
            'originality_score' => 'nullable|numeric|min:0|max:10',
            'significance_score' => 'nullable|numeric|min:0|max:15',
            'technical_soundness_score' => 'nullable|numeric|min:0|max:15',
            'clarity_score' => 'nullable|numeric|min:0|max:10',
            'documentation_score' => 'nullable|numeric|min:0|max:5',
            'total_score' => 'nullable|numeric|min:0|max:60',
            // Final Evaluation
            'final_evaluation' => 'nullable|in:excellent,very_good,fair,poor',
            // Recommendation
            'recommendation' => 'nullable|in:acceptance,minor_revision,major_revision,rejection',
        ]);

        DB::beginTransaction();
        try {
            // Handle file upload
            $reviewFilePath = $review->review_file; // Keep existing file if no new file uploaded
            if ($request->hasFile('review_file')) {
                // Delete old file if exists
                if ($review->review_file && Storage::disk('public')->exists($review->review_file)) {
                    Storage::disk('public')->delete($review->review_file);
                }
                
                // Store new file
                $file = $request->file('review_file');
                $fileName = 'review_' . time() . '_' . $review->id . '_' . $file->getClientOriginalName();
                $reviewFilePath = $file->storeAs('review_files', $fileName, 'public');
            }

            // Calculate total score if individual scores are provided
            $totalScore = null;
            if ($request->filled('relevance_score') || $request->filled('originality_score') || 
                $request->filled('significance_score') || $request->filled('technical_soundness_score') ||
                $request->filled('clarity_score') || $request->filled('documentation_score')) {
                $totalScore = ($request->relevance_score ?? 0) + 
                             ($request->originality_score ?? 0) + 
                             ($request->significance_score ?? 0) + 
                             ($request->technical_soundness_score ?? 0) + 
                             ($request->clarity_score ?? 0) + 
                             ($request->documentation_score ?? 0);
            }

            // Update review
            $review->update([
                'review_file' => $reviewFilePath,
                'rating' => $request->rating,
                'comments' => $request->comments,
                // General Comments - 6 Questions
                'originality_comment' => $request->originality_comment,
                'relationship_to_literature_comment' => $request->relationship_to_literature_comment,
                'methodology_comment' => $request->methodology_comment,
                'results_comment' => $request->results_comment,
                'implications_comment' => $request->implications_comment,
                'quality_of_communication_comment' => $request->quality_of_communication_comment,
                // Strengths and Weaknesses
                'strengths' => $request->strengths,
                'weaknesses' => $request->weaknesses,
                // Suggestions for Improvement
                'suggestions_for_improvement' => $request->suggestions_for_improvement,
                // Paper Score
                'relevance_score' => $request->relevance_score,
                'originality_score' => $request->originality_score,
                'significance_score' => $request->significance_score,
                'technical_soundness_score' => $request->technical_soundness_score,
                'clarity_score' => $request->clarity_score,
                'documentation_score' => $request->documentation_score,
                'total_score' => $request->total_score ?? $totalScore,
                // Final Evaluation
                'final_evaluation' => $request->final_evaluation,
                // Recommendation
                'recommendation' => $request->recommendation,
            ]);

            // Get submission and reload to get fresh reviews data
            $submission = $review->submission;
            $submission->load('reviews'); // Reload reviews to get latest data
            $allReviews = $submission->reviews;
            
            // Check if all reviews have been completed (have ratings or total_score)
            $completedReviews = $allReviews->filter(function($review) {
                return $review->rating !== null || $review->total_score !== null;
            });
            $totalReviews = $allReviews->count();
            
            // Check if all reviewers have given a perfect score
            // Perfect score = rating of 10/10 OR total_score of 10.0/60 (treated as 10/10 equivalent)
            $allRatedTen = $completedReviews->count() > 0 
                && $completedReviews->count() === $totalReviews 
                && $completedReviews->every(function($review) {
                    $hasPerfectRating = (float)$review->rating == 10.0;
                    $hasPerfectTotalScore = (float)$review->total_score == 10.0; // 10.0/60 treated as 10/10
                    return $hasPerfectRating || $hasPerfectTotalScore;
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

            // Create notification for editors (not authors) - review needs editor approval
            $editors = User::where('role', 'editor')->get();
            if ($editors->count() > 0) {
                $articleTitle = $article ? $article->title : 'An article';
                $reviewerName = Auth::user()->name ?? 'A reviewer';
                
                foreach ($editors as $editor) {
                    Notification::create([
                        'user_id' => $editor->id,
                        'type' => 'review',
                        'message' => "{$reviewerName} has submitted a review comment for \"{$articleTitle}\". Please review and approve.",
                        'status' => 'unread',
                    ]);
                }
            }

            DB::commit();

            $successMessage = $allRatedTen 
                ? 'Review submitted successfully! All reviewers have given a perfect score (10/10 or 10.0/60). The article status has been automatically updated to "Accepted".'
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







