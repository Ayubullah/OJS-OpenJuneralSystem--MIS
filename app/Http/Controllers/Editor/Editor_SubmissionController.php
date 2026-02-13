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
use App\Models\EditorMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        $journalIds = $this->getEditorJournalIds();
        
        // Get unique articles (one per article_id) with their latest submission
        $latestSubmissionIds = DB::table('submissions')
            ->join('articles', 'submissions.article_id', '=', 'articles.id')
            ->whereIn('articles.journal_id', $journalIds ?: [0])
            ->select(DB::raw('MAX(submissions.id) as id'))
            ->groupBy('submissions.article_id')
            ->pluck('id');
        
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->whereIn('submissions.id', $latestSubmissionIds)
            ->latest()
            ->paginate(10);
        
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
     * Display pending verification submissions (files uploaded by authors for verification).
     */
    public function pendingVerify()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('approval_status', 'pending')
                ->whereNotNull('approval_pending_file')
        )->latest()->paginate(10);
        $statusFilter = 'pending_verify';
        return view('editor.submissions.pending-verify', compact('submissions', 'statusFilter'));
    }

    /**
     * Display verified submissions (articles that have been verified through the verification workflow).
     */
    public function verified()
    {
        $submissions = $this->filterByEditorJournals(
            Submission::with(['article.journal', 'author', 'reviews.reviewer'])
                ->where('approval_status', 'verified')
                ->whereNotNull('approval_pending_file')
        )->latest()->paginate(10);
        $statusFilter = 'verified';
        return view('editor.submissions.verified', compact('submissions', 'statusFilter'));
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
            'status' => 'required|in:submitted,under_review,revision_required,pending_verify,verified,accepted,published,rejected',
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
            'status' => 'required|in:submitted,under_review,revision_required,pending_verify,verified,accepted,published,rejected',
            'version_number' => 'required|integer|min:1',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
            'approval_status' => 'nullable|in:pending,verified,rejected'
        ]);

        $updateData = [
            'article_id' => $request->article_id,
            'author_id' => $request->author_id,
            'status' => $request->status,
            'version_number' => $request->version_number
        ];

        // Handle approval_status if provided
        if ($request->has('approval_status')) {
            $updateData['approval_status'] = $request->approval_status ?: null;
        }

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

        // Check if article or submission is rejected
        $submission->load('article');
        if ($submission->article->status === 'rejected' || $submission->status === 'rejected') {
            return redirect()->route('editor.submissions.show', $submission)
                ->with('error', 'Cannot assign reviewers to a rejected article. The author has rejected this article.');
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
        // Check if article or submission is rejected
        if ($submission->article->status === 'rejected' || $submission->status === 'rejected') {
            return redirect()->back()
                ->with('error', 'Cannot assign reviewers to a rejected article. The author has rejected this article.');
        }

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

    /**
     * Send message to author and/or reviewer about an article
     */
    public function sendMessage(Request $request, Submission $submission)
    {
        // Check if submission belongs to editor's journal
        $journalIds = $this->getEditorJournalIds();
        if (!empty($journalIds) && !in_array($submission->article->journal_id, $journalIds)) {
            abort(403, 'You do not have access to this submission.');
        }

        $request->validate([
            'message' => 'required|string|min:10|max:2000',
            'recipient_type' => 'required|in:author,reviewer,both',
            'send_for_approval' => 'nullable|boolean'
        ]);

        // Validate approval request
        $sendForApproval = $request->has('send_for_approval') && $request->send_for_approval;
        if ($sendForApproval) {
            // Check if approval is already pending or approved
            if ($submission->approval_status === 'pending') {
                return redirect()->back()
                    ->with('error', 'A verification request is already pending. Please wait for the author to upload a file.');
            }
            if ($submission->approval_status === 'verified') {
                return redirect()->back()
                    ->with('error', 'This article has already been verified.');
            }
            // Approval requests can only be sent to authors
            if ($request->recipient_type !== 'author' && $request->recipient_type !== 'both') {
                return redirect()->back()
                    ->with('error', 'Verification requests can only be sent to authors.');
            }
        }

        DB::beginTransaction();
        try {
            $submission->load(['article', 'author', 'reviews.reviewer.user']);
            $editorName = Auth::user()->name ?? 'Editor';

            // Store message for author if recipient is author or both
            if ($request->recipient_type === 'author' || $request->recipient_type === 'both') {
                $messageData = [
                    'article_id' => $submission->article_id,
                    'submission_id' => $submission->id,
                    'editor_id' => Auth::id(),
                    'author_id' => $submission->author_id,
                    'message' => $request->message,
                    'recipient_type' => 'author',
                    'is_approval_request' => $sendForApproval,
                ];

                EditorMessage::create($messageData);

                // If sending for approval, update article and submission status
                if ($sendForApproval) {
                    $submission->article->update(['status' => 'pending_verify']);
                    $submission->update(['status' => 'pending_verify']);
                }

                // Create notification for author if they have a user account
                $authorUser = User::where('email', $submission->author->email)->first();
                if ($authorUser) {
                        $notificationMessage = $sendForApproval 
                        ? "Verification request from {$editorName} for your article: \"{$submission->article->title}\". Please upload a revised file."
                        : "New message from {$editorName} about your article: \"{$submission->article->title}\"";
                    
                    Notification::create([
                        'user_id' => $authorUser->id,
                        'type' => $sendForApproval ? 'reminder' : 'reminder',
                        'message' => $notificationMessage,
                        'status' => 'unread',
                    ]);
                }
            }

            // Store message for reviewers if recipient is reviewer or both
            if ($request->recipient_type === 'reviewer' || $request->recipient_type === 'both') {
                // Get all reviewers assigned to this submission
                $reviewers = $submission->reviews()->with('reviewer.user')->get();
                
                if ($reviewers->isEmpty() && $request->recipient_type === 'reviewer') {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'No reviewers are assigned to this article. Please assign reviewers first.');
                }
                
                foreach ($reviewers as $review) {
                    EditorMessage::create([
                        'article_id' => $submission->article_id,
                        'submission_id' => $submission->id,
                        'editor_id' => Auth::id(),
                        'reviewer_id' => $review->reviewer_id,
                        'message' => $request->message,
                        'recipient_type' => 'reviewer',
                    ]);

                    // Create notification for reviewer if they have a user account
                    if ($review->reviewer->user) {
                        Notification::create([
                            'user_id' => $review->reviewer->user->id,
                            'type' => 'reminder',
                            'message' => "New message from {$editorName} about your review assignment: \"{$submission->article->title}\"",
                            'status' => 'unread',
                        ]);
                    }
                }
            }

            DB::commit();

            $recipientText = $request->recipient_type === 'both' ? 'author and reviewers' : ($request->recipient_type === 'author' ? 'author' : 'reviewers');
            
            // Redirect to reminders page if requested, otherwise redirect back
            if ($request->has('redirect_to') && $request->redirect_to === 'reminders') {
                return redirect()->route('editor.reminders.index')
                    ->with('success', "Message sent successfully to {$recipientText}!");
            }
            
            return redirect()->back()
                ->with('success', "Message sent successfully to {$recipientText}!");

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Redirect to reminders page if requested, otherwise redirect back
            if ($request->has('redirect_to') && $request->redirect_to === 'reminders') {
                return redirect()->route('editor.reminders.index')
                    ->with('error', 'Error sending message: ' . $e->getMessage());
            }
            
            return redirect()->back()
                ->with('error', 'Error sending message: ' . $e->getMessage());
        }
    }

    /**
     * Send reminder to author about their article (kept for backward compatibility)
     */
    public function sendReminderToAuthor(Request $request, Submission $submission)
    {
        $request->merge(['recipient_type' => 'author']);
        return $this->sendMessage($request, $submission);
    }

    /**
     * Send reminder to reviewer about their review assignment (kept for backward compatibility)
     */
    public function sendReminderToReviewer(Request $request, Review $review)
    {
        // Check if review belongs to editor's journal
        $journalIds = $this->getEditorJournalIds();
        $review->load('submission.article');
        
        if (!empty($journalIds) && !in_array($review->submission->article->journal_id, $journalIds)) {
            abort(403, 'You do not have access to this review.');
        }

        $request->validate([
            'message' => 'required|string|min:10|max:2000'
        ]);

        DB::beginTransaction();
        try {
            $review->load(['submission', 'reviewer.user']);
            $editorName = Auth::user()->name ?? 'Editor';

            // Store message for reviewer
            EditorMessage::create([
                'article_id' => $review->submission->article_id,
                'submission_id' => $review->submission_id,
                'editor_id' => Auth::id(),
                'reviewer_id' => $review->reviewer_id,
                'message' => $request->message ?? 'This is a reminder about your pending review assignment.',
                'recipient_type' => 'reviewer',
            ]);

            // Create notification for reviewer if they have a user account
            if ($review->reviewer->user) {
                Notification::create([
                    'user_id' => $review->reviewer->user->id,
                    'type' => 'reminder',
                    'message' => "New message from {$editorName} about your review assignment: \"{$review->submission->article->title}\"",
                    'status' => 'unread',
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Message sent successfully to the reviewer!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error sending message: ' . $e->getMessage());
        }
    }

    /**
     * Display reminders/messages management page
     */
    public function remindersIndex()
    {
        $journalIds = $this->getEditorJournalIds();
        
        // Get unique articles (one per article_id) with their latest submission, sorted by article ID
        $latestSubmissionIds = DB::table('submissions')
            ->join('articles', 'submissions.article_id', '=', 'articles.id')
            ->whereIn('articles.journal_id', $journalIds ?: [0])
            ->select(DB::raw('MAX(submissions.id) as id'))
            ->groupBy('submissions.article_id')
            ->pluck('id');
        
        $submissions = Submission::with([
            'article.journal',
            'article.author',
            'article.category',
            'author',
            'reviews.reviewer.user'
        ])
        ->whereIn('submissions.id', $latestSubmissionIds)
        ->join('articles', 'submissions.article_id', '=', 'articles.id')
        ->select('submissions.*')
        ->orderBy('articles.id', 'asc')
        ->paginate(15);

        // Get all editor messages sent by this editor, sorted by article ID
        // Check if table exists before querying
        try {
            // First check if table exists
            if (!Schema::hasTable('editor_messages')) {
                $authorMessages = collect([]);
                $reviewerMessages = collect([]);
                $adminMessages = collect([]);
                $messages = collect([]);
            } else {
                // Get all messages (sent by editor and received from admin)
                $allMessages = EditorMessage::with([
                    'article.journal',
                    'article.author',
                    'author',
                    'reviewer.user',
                    'editor',
                    'editorRecipient'
                ])
                ->where(function($query) {
                    // Messages sent by this editor
                    $query->where('editor_id', Auth::id())
                    // OR admin messages sent to this editor
                    ->orWhere(function($q) {
                        $q->where('sender_type', 'admin')
                          ->where('recipient_type', 'editor')
                          ->where('editor_recipient_id', Auth::id());
                    });
                })
                ->orderBy('article_id', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
                
                // Separate messages into categories
                $authorMessages = $allMessages->filter(function($msg) {
                    return $msg->recipient_type === 'author' && $msg->sender_type !== 'admin';
                });
                
                $reviewerMessages = $allMessages->filter(function($msg) {
                    return $msg->recipient_type === 'reviewer' && $msg->sender_type !== 'admin';
                });
                
                $adminMessages = $allMessages->filter(function($msg) {
                    return $msg->sender_type === 'admin';
                });
                
                // Keep all messages for backward compatibility
                $messages = $allMessages;
            }
        } catch (\Exception $e) {
            // If table doesn't exist or any error, return empty collections
            $authorMessages = collect([]);
            $reviewerMessages = collect([]);
            $adminMessages = collect([]);
            $messages = collect([]);
        }

        return view('editor.reminders.index', compact('submissions', 'messages', 'authorMessages', 'reviewerMessages', 'adminMessages'));
    }

    /**
     * Update an existing editor message
     */
    public function updateMessage(Request $request, EditorMessage $message)
    {
        // Check if message belongs to this editor
        if ($message->editor_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit this message.');
        }

        $request->validate([
            'message' => 'required|string|min:10|max:2000'
        ]);

        try {
            $message->update([
                'message' => $request->message
            ]);

            return redirect()->route('editor.reminders.index')
                ->with('success', 'Message updated successfully!');

        } catch (\Exception $e) {
            return redirect()->route('editor.reminders.index')
                ->with('error', 'Error updating message: ' . $e->getMessage());
        }
    }

    /**
     * Delete an existing editor message
     */
    public function deleteMessage(EditorMessage $message)
    {
        // Check if message belongs to this editor
        if ($message->editor_id !== Auth::id()) {
            abort(403, 'You do not have permission to delete this message.');
        }

        try {
            $message->delete();

            return redirect()->route('editor.reminders.index')
                ->with('success', 'Message deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('editor.reminders.index')
                ->with('error', 'Error deleting message: ' . $e->getMessage());
        }
    }

    /**
     * Approve article after reviewing uploaded file
     */
    public function approveArticle(Submission $submission)
    {
        // Check if submission belongs to editor's journal
        $journalIds = $this->getEditorJournalIds();
        if (!empty($journalIds) && !in_array($submission->article->journal_id, $journalIds)) {
            abort(403, 'You do not have access to this submission.');
        }

        // Check if there's a pending approval file
        if ($submission->approval_status !== 'pending' || !$submission->approval_pending_file) {
            return redirect()->back()
                ->with('error', 'No pending verification file found.');
        }

        DB::beginTransaction();
        try {
            // Update approval status and submission status
            $submission->update([
                'approval_status' => 'verified',
                'status' => 'verified' // Set submission status to verified when verified
            ]);

            // Optionally move approval file to main file_path if this is the final verified version
            // For now, we'll keep both files separate
            // $submission->update(['file_path' => $submission->approval_pending_file]);

            // Update article status to verified
            $submission->article->update(['status' => 'verified']);

            // Create notification for author
            $authorUser = User::where('email', $submission->author->email)->first();
            if ($authorUser) {
                Notification::create([
                    'user_id' => $authorUser->id,
                    'type' => 'reminder',
                    'message' => "Your article \"{$submission->article->title}\" has been verified!",
                    'status' => 'unread',
                ]);
            }

            DB::commit();

            // Redirect to edit page to show the updated status
            return redirect()->route('editor.submissions.edit', $submission)
                ->with('success', 'Article verified successfully! Status has been updated to "Verified" and Approval Status to "Verified". The author has been notified.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error verifying article: ' . $e->getMessage());
        }
    }

    /**
     * Reject approval request and request changes
     */
    public function rejectApproval(Submission $submission)
    {
        // Check if submission belongs to editor's journal
        $journalIds = $this->getEditorJournalIds();
        if (!empty($journalIds) && !in_array($submission->article->journal_id, $journalIds)) {
            abort(403, 'You do not have access to this submission.');
        }

        // Check if there's a pending approval file
        if ($submission->approval_status !== 'pending' || !$submission->approval_pending_file) {
            return redirect()->back()
                ->with('error', 'No pending verification file found.');
        }

        DB::beginTransaction();
        try {
            // Update approval status to rejected
            $submission->update([
                'approval_status' => 'rejected'
            ]);

            // Optionally delete the rejected file
            // if ($submission->approval_pending_file && Storage::disk('public')->exists($submission->approval_pending_file)) {
            //     Storage::disk('public')->delete($submission->approval_pending_file);
            //     $submission->update(['approval_pending_file' => null]);
            // }

            // Change status back to revision_required
            $submission->article->update(['status' => 'revision_required']);
            $submission->update(['status' => 'revision_required']);

            // Create notification for author
            $authorUser = User::where('email', $submission->author->email)->first();
            if ($authorUser) {
                Notification::create([
                    'user_id' => $authorUser->id,
                    'type' => 'reminder',
                    'message' => "Your verification request for article \"{$submission->article->title}\" has been rejected. Please review and resubmit.",
                    'status' => 'unread',
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Verification request rejected. The author has been notified to make changes.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error rejecting verification: ' . $e->getMessage());
        }
    }
}
