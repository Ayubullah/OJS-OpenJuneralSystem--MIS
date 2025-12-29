<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Article;
use App\Models\Author;
use App\Models\Reviewer;
use App\Models\Review;
use App\Models\Notification;
use App\Models\User;
use App\Models\Editor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Editor_SubmissionController extends Controller
{
    /**
     * Get journal IDs for the current editor
     */
    protected function getEditorJournalIds()
    {
        $editor = Editor::where('user_id', Auth::id())
            ->where('status', 'active')
            ->pluck('journal_id')
            ->toArray();
        
        return $editor ?: [];
    }

    /**
     * Filter submissions by editor's journals
     */
    protected function filterByEditorJournals($query)
    {
        $journalIds = $this->getEditorJournalIds();
        
        if (empty($journalIds)) {
            // If editor has no journals assigned, return empty results
            return $query->whereRaw('1 = 0');
        }
        
        return $query->whereHas('article', function($q) use ($journalIds) {
            $q->whereIn('journal_id', $journalIds);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
        )->latest()->paginate(10);
        return view('editor.submissions.index', compact('submissions'));
    }

    /**
     * Display published submissions.
     */
    public function published()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('status', 'published')
        )->latest()->paginate(10);
        $statusFilter = 'published';
        return view('editor.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display accepted submissions.
     */
    public function accepted()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('status', 'accepted')
        )->latest()->paginate(10);
        $statusFilter = 'accepted';
        return view('editor.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display submitted submissions.
     */
    public function submitted()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('status', 'submitted')
        )->latest()->paginate(10);
        $statusFilter = 'submitted';
        return view('editor.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display under review submissions.
     */
    public function underReview()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('status', 'under_review')
        )->latest()->paginate(10);
        $statusFilter = 'under_review';
        return view('editor.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display revision required submissions.
     */
    public function revisionRequired()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('status', 'revision_required')
        )->latest()->paginate(10);
        $statusFilter = 'revision_required';
        return view('editor.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display rejected submissions.
     */
    public function rejected()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('status', 'rejected')
        )->latest()->paginate(10);
        $statusFilter = 'rejected';
        return view('editor.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display pending reviews that need editor approval.
     */
    public function pendingApprovals()
    {
        $journalIds = $this->getEditorJournalIds();
        
        $pendingReviews = Review::with([
            'submission.article.journal',
            'submission.article.author',
            'submission.author',
            'reviewer.user'
        ])
        ->whereNotNull('comments')
        ->where('editor_approved', false)
        ->whereHas('submission.article', function($q) use ($journalIds) {
            if (!empty($journalIds)) {
                $q->whereIn('journal_id', $journalIds);
            } else {
                $q->whereRaw('1 = 0');
            }
        })
        ->latest()
        ->paginate(15);

        return view('editor.reviews.pending-approvals', compact('pendingReviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::with('journal')->get();
        $authors = Author::all();
        
        return view('editor.submissions.create', compact('articles', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:submitted,under_review,revision_required,accepted,published,rejected',
            'version_number' => 'required|integer|min:1'
        ]);

        Submission::create($request->all());

        return redirect()->route('editor.submissions.index')
            ->with('success', 'Submission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        // Check if submission belongs to editor's journal
        $journalIds = $this->getEditorJournalIds();
        if (!empty($journalIds) && !in_array($submission->article->journal_id, $journalIds)) {
            abort(403, 'You do not have access to this submission.');
        }
        
        $submission->load(['article.journal', 'author', 'reviews.reviewer']);
        return view('editor.submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        $articles = Article::with('journal')->get();
        $authors = Author::all();
        
        return view('editor.submissions.edit', compact('submission', 'articles', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:submitted,under_review,revision_required,accepted,published,rejected',
            'version_number' => 'required|integer|min:1',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240' // 10MB max
        ]);

        $updateData = [
            'article_id' => $request->article_id,
            'author_id' => $request->author_id,
            'status' => $request->status,
            'version_number' => $request->version_number
        ];

        // Handle file upload if new file provided
        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
            
            // Upload new file
            $file = $request->file('file_path');
            $fileName = time() . '_editor_' . $submission->author_id . '_' . $file->getClientOriginalName();
            $updateData['file_path'] = $file->storeAs('submissions', $fileName, 'public');
        }

        $submission->update($updateData);

        return redirect()->route('editor.submissions.show', $submission)
            ->with('success', 'Submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        $submission->delete();

        return redirect()->route('editor.submissions.index')
            ->with('success', 'Submission deleted successfully.');
    }

    /**
     * Show the form for assigning a reviewer to a submission.
     */
    public function assignReviewer(Submission $submission)
    {
        // Check if submission belongs to editor's journal
        $journalIds = $this->getEditorJournalIds();
        if (!empty($journalIds) && !in_array($submission->article->journal_id, $journalIds)) {
            abort(403, 'You do not have access to this submission.');
        }
        
        $submission->load(['article.journal', 'author', 'reviews.reviewer.user']);
        // Only show reviewers from the same journal
        $reviewers = Reviewer::with('user')
            ->where('status', 'active')
            ->whereIn('journal_id', $journalIds ?: [0])
            ->get();
        
        // Get all submissions for this article with their reviews, grouped by version
        $allSubmissions = Submission::where('article_id', $submission->article_id)
            ->with(['reviews.reviewer.user'])
            ->orderBy('version_number', 'desc')
            ->get();
        
        return view('editor.submissions.assign-reviewer', compact('submission', 'reviewers', 'allSubmissions'));
    }

    /**
     * Store the reviewer assignment for a submission.
     */
    public function storeReviewerAssignment(Request $request, Submission $submission)
    {
        $request->validate([
            'reviewer_ids' => 'required|array|min:1',
            'reviewer_ids.*' => 'exists:reviewers,id',
            'deadline' => 'nullable|date|after:today'
        ]);

        DB::beginTransaction();
        try {
            $assignedCount = 0;

            // Process each selected reviewer
            foreach ($request->reviewer_ids as $reviewerId) {
                // Create review assignment (allow multiple assignments for same reviewer)
                Review::create([
                    'submission_id' => $submission->id,
                    'reviewer_id' => $reviewerId,
                    'review_date' => $request->deadline ?? null,
                ]);
                $assignedCount++;
            }

            // Update submission status to 'under_review' if it's currently 'submitted' and at least one reviewer was assigned
            if ($assignedCount > 0 && $submission->status === 'submitted') {
                $submission->update(['status' => 'under_review']);
            }

            DB::commit();

            // Build success message
            $message = $assignedCount . ' reviewer(s) assigned successfully!';
            if ($assignedCount > 0 && $submission->status === 'under_review') {
                $message .= ' The submission status has been updated to "Under Review".';
            }

            return redirect()->route('editor.submissions.show', $submission)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error assigning reviewers: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Edit a review comment (editor can edit reviewer's comment before approval)
     */
    public function editReview(Review $review)
    {
        $review->load(['submission.article', 'reviewer.user']);
        return view('editor.reviews.edit', compact('review'));
    }

    /**
     * Update a review comment and optionally approve it
     */
    public function updateReview(Request $request, Review $review)
    {
        $request->validate([
            'editor_edited_comments' => 'required|string|min:10',
            'approve' => 'nullable|boolean'
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'editor_edited_comments' => $request->editor_edited_comments
            ];

            // If approve checkbox is checked, approve the review
            if ($request->has('approve') && $request->approve) {
                $updateData['editor_approved'] = true;

                // Notify the author that a review has been approved
                $submission = $review->submission;
                $author = $submission->author;
                if ($author) {
                    $authorUser = User::where('email', $author->email)->first();
                    if ($authorUser) {
                        $articleTitle = $submission->article ? $submission->article->title : 'Your article';
                        $reviewerName = $review->reviewer->user->name ?? 'A reviewer';
                        
                        Notification::create([
                            'user_id' => $authorUser->id,
                            'type' => 'review',
                            'message' => "A review comment from {$reviewerName} has been approved for your article: \"{$articleTitle}\"",
                            'status' => 'unread',
                        ]);
                    }
                }
            }

            $review->update($updateData);

            DB::commit();

            $message = $request->has('approve') && $request->approve 
                ? 'Review comment updated and approved successfully! The author has been notified.'
                : 'Review comment updated successfully!';

            return redirect()->route('editor.submissions.show', $review->submission)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error updating review: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Approve a review without editing
     */
    public function approveReview(Review $review)
    {
        DB::beginTransaction();
        try {
            $review->update(['editor_approved' => true]);

            // Notify the author
            $submission = $review->submission;
            $author = $submission->author;
            if ($author) {
                $authorUser = User::where('email', $author->email)->first();
                if ($authorUser) {
                    $articleTitle = $submission->article ? $submission->article->title : 'Your article';
                    $reviewerName = $review->reviewer->user->name ?? 'A reviewer';
                    
                    Notification::create([
                        'user_id' => $authorUser->id,
                        'type' => 'review',
                        'message' => "A review comment from {$reviewerName} has been approved for your article: \"{$articleTitle}\"",
                        'status' => 'unread',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('editor.submissions.show', $review->submission)
                ->with('success', 'Review approved successfully! The author has been notified.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error approving review: ' . $e->getMessage());
        }
    }
}
