<?php

namespace App\Http\Controllers\EditorialAssistant;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\EditorMessage;
use App\Models\Notification;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditorialAssistantArticleController extends Controller
{
    /**
     * Display a listing of accepted articles.
     * All accepted articles are visible to editorial assistants.
     */
    public function index(Request $request)
    {
        $query = Article::whereIn('status', ['accepted', 'approved_chief_editor'])
            ->with(['journal', 'author', 'category']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('journal', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by journal
        if ($request->has('journal_id') && $request->journal_id) {
            $query->where('journal_id', $request->journal_id);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $articles = $query->latest()->paginate(15);

        // Get journals and categories for filters
        $journals = \App\Models\Journal::where('status', 'active')->get();
        $categories = \App\Models\Category::all();

        return view('editorial_assistant.articles.index', compact('articles', 'journals', 'categories'));
    }

    /**
     * Display a listing of verified articles.
     */
    public function verified(Request $request)
    {
        $query = Article::where('status', 'verified')
            ->with(['journal', 'author', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%")
                  ->orWhereHas('author', fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                  ->orWhereHas('journal', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('journal_id')) {
            $query->where('journal_id', $request->journal_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $articles = $query->latest()->paginate(15);
        $journals = \App\Models\Journal::where('status', 'active')->get();
        $categories = \App\Models\Category::all();

        return view('editorial_assistant.articles.verified', compact('articles', 'journals', 'categories'));
    }

    /**
     * Display the specified accepted article.
     */
    public function show(Article $article)
    {
        // Ensure the article is accepted, pending_verify, or verified (editorial assistant can view these)
        if (!in_array($article->status, ['accepted', 'approved_chief_editor', 'pending_verify', 'verified'])) {
            return redirect()->route('editorial_assistant.articles.index')
                ->with('error', __('You do not have access to this article.'));
        }

        $article->load(['journal', 'author', 'category', 'keywords', 'submissions']);
        
        // Get the latest submission for this article
        $submission = Submission::where('article_id', $article->id)
            ->orderBy('version_number', 'desc')
            ->with(['article.journal', 'author', 'reviews.reviewer.user'])
            ->first();
        
        // If no submission exists, still show article but without submission details
        if (!$submission) {
            return view('editorial_assistant.articles.show', compact('article', 'submission'));
        }
        
        // Load all submissions for this article (version history)
        $allSubmissions = Submission::where('article_id', $article->id)
            ->orderBy('version_number', 'desc')
            ->with(['reviews.reviewer.user'])
            ->get();
        
        // Load all messages between author and editorial assistant/editor for this article
        $editorMessages = \App\Models\EditorMessage::where('article_id', $article->id)
            ->where(function($q) {
                $q->where('recipient_type', 'author')
                  ->orWhere('recipient_type', 'both');
            })
            ->with(['editor', 'editorRecipient'])
            ->latest()
            ->get();

        // Build combined timeline: editor messages + author file uploads (when submission has approval_pending_file)
        $messageTimeline = $editorMessages->map(fn($m) => (object)[
            'type' => 'editor',
            'item' => $m,
            'date' => $m->created_at,
        ])->toArray();

        if ($submission->approval_pending_file) {
            $messageTimeline[] = (object)[
                'type' => 'author_upload',
                'submission' => $submission,
                'date' => $submission->updated_at,
            ];
        }
        usort($messageTimeline, fn($a, $b) => $b->date->timestamp <=> $a->date->timestamp);

        return view('editorial_assistant.articles.show', compact('article', 'submission', 'allSubmissions', 'editorMessages', 'messageTimeline'));
    }

    /**
     * Send message to author for verification.
     */
    public function sendMessage(Request $request, Article $article)
    {
        // Ensure the article is accepted, approved by chief editor, or pending_verify (editorial assistant can send messages/verification to all)
        if (!in_array($article->status, ['accepted', 'approved_chief_editor', 'pending_verify'])) {
            return redirect()->route('editorial_assistant.articles.index')
                ->with('error', __('This article is not accepted.'));
        }

        $submission = Submission::where('article_id', $article->id)
            ->orderBy('version_number', 'desc')
            ->first();

        if (!$submission) {
            return redirect()->back()
                ->with('error', __('No submission found for this article.'));
        }

        $request->validate([
            'message' => 'required|string|min:10|max:2000',
            'send_for_verification' => 'nullable|boolean'
        ]);

        $sendForVerification = $request->has('send_for_verification') && $request->send_for_verification;
        if ($sendForVerification) {
            if ($submission->approval_status === 'pending') {
                return redirect()->back()
                    ->with('error', __('A verification request is already pending. Please wait for the author to upload a file.'));
            }
            if ($submission->approval_status === 'verified') {
                return redirect()->back()
                    ->with('error', __('This article has already been verified.'));
            }
        }

        DB::beginTransaction();
        try {
            $submission->load(['article', 'author']);
            $assistantName = Auth::user()->name ?? __('Editorial Assistant');

            EditorMessage::create([
                'article_id' => $article->id,
                'submission_id' => $submission->id,
                'editor_id' => Auth::id(),
                'sender_type' => 'editorial_assistant',
                'author_id' => $submission->author_id,
                'message' => $request->message,
                'recipient_type' => 'author',
                'is_approval_request' => $sendForVerification,
            ]);

            if ($sendForVerification) {
                $submission->article->update(['status' => 'pending_verify']);
                $submission->update(['status' => 'pending_verify']);
            }

            $authorUser = User::where('email', $submission->author->email)->first();
            if ($authorUser) {
                $notificationMessage = $sendForVerification
                    ? __("Verification request from :name for your article: \":title\". Please upload a revised file.", ['name' => $assistantName, 'title' => $submission->article->title])
                    : __("New message from :name about your article: \":title\"", ['name' => $assistantName, 'title' => $submission->article->title]);

                Notification::create([
                    'user_id' => $authorUser->id,
                    'type' => 'reminder',
                    'message' => $notificationMessage,
                    'status' => 'unread',
                ]);
            }

            DB::commit();

            $successMsg = $sendForVerification
                ? __('Message and verification request sent successfully to the author!')
                : __('Message sent successfully to the author!');

            return redirect()->back()->with('success', $successMsg);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('Error sending message: ') . $e->getMessage());
        }
    }

    /**
     * Display all articles pending verification (with or without uploaded files).
     * Shows articles with status pending_verify; those with approval_pending_file can be verified/rejected.
     */
    public function pendingVerify(Request $request)
    {
        $articles = Article::where('status', 'pending_verify')
            ->with(['journal', 'author', 'category', 'submissions' => fn($q) => $q->orderBy('version_number', 'desc')->limit(1)])
            ->latest()
            ->paginate(10);

        // For each article, get the latest submission and whether it has a file to verify
        $items = [];
        foreach ($articles as $article) {
            $submission = $article->submissions->first();
            $hasFile = $submission && $submission->approval_pending_file && $submission->approval_status === 'pending';
            $items[] = (object)[
                'article' => $article,
                'submission' => $submission,
                'has_file_to_verify' => $hasFile,
            ];
        }

        // Load message counts for all article IDs
        $articleIds = $articles->pluck('id');
        $messageCounts = \App\Models\EditorMessage::whereIn('article_id', $articleIds)
            ->where(function($q) {
                $q->where('recipient_type', 'author')->orWhere('recipient_type', 'both');
            })
            ->selectRaw('article_id, count(*) as cnt')
            ->groupBy('article_id')
            ->pluck('cnt', 'article_id');

        return view('editorial_assistant.articles.pending-verify', compact('articles', 'items', 'messageCounts'));
    }

    /**
     * Simple list of articles pending verification (no verify/reject, no messages).
     */
    public function pendingVerifyList(Request $request)
    {
        $articles = Article::where('status', 'pending_verify')
            ->with(['journal', 'author', 'category'])
            ->latest()
            ->paginate(15);

        return view('editorial_assistant.articles.pending-verify-list', compact('articles'));
    }

    /**
     * Approve/verify article after reviewing uploaded file.
     */
    public function approveVerification(Article $article)
    {
        if ($article->status !== 'pending_verify') {
            return redirect()->back()->with('error', __('This article is not pending verification.'));
        }

        $submission = Submission::where('article_id', $article->id)->orderBy('version_number', 'desc')->first();
        if (!$submission || $submission->approval_status !== 'pending' || !$submission->approval_pending_file) {
            return redirect()->back()->with('error', __('No pending verification file found.'));
        }

        DB::beginTransaction();
        try {
            $submission->update(['approval_status' => 'verified', 'status' => 'verified']);
            $article->update(['status' => 'verified']);

            $authorUser = User::where('email', $submission->author->email)->first();
            if ($authorUser) {
                Notification::create([
                    'user_id' => $authorUser->id,
                    'type' => 'reminder',
                    'message' => __('Your article ":title" has been verified!', ['title' => $article->title]),
                    'status' => 'unread',
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', __('Article verified successfully! Status has been updated to "Verified".'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('Error verifying article: ') . $e->getMessage());
        }
    }

    /**
     * Reject verification with comment. Status stays pending_verify so author can upload again.
     */
    public function rejectVerification(Request $request, Article $article)
    {
        $request->validate([
            'rejection_comment' => 'required|string|min:10|max:2000',
        ]);

        if ($article->status !== 'pending_verify') {
            return redirect()->back()->with('error', __('This article is not pending verification.'));
        }

        $submission = Submission::where('article_id', $article->id)->orderBy('version_number', 'desc')->first();
        if (!$submission || $submission->approval_status !== 'pending' || !$submission->approval_pending_file) {
            return redirect()->back()->with('error', __('No pending verification file found.'));
        }

        DB::beginTransaction();
        try {
            $submission->update([
                'approval_status' => 'rejected',
            ]);
            // Keep article and submission status as pending_verify so author can resubmit

            EditorMessage::create([
                'article_id' => $article->id,
                'submission_id' => $submission->id,
                'editor_id' => Auth::id(),
                'sender_type' => 'editorial_assistant',
                'author_id' => $submission->author_id,
                'message' => $request->rejection_comment,
                'recipient_type' => 'author',
                'is_approval_request' => false,
                'is_rejection' => true,
            ]);

            $authorUser = User::where('email', $submission->author->email)->first();
            if ($authorUser) {
                Notification::create([
                    'user_id' => $authorUser->id,
                    'type' => 'reminder',
                    'message' => __('Your verification for ":title" was rejected. Please review the comments and upload a new file.', ['title' => $article->title]),
                    'status' => 'unread',
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', __('Verification rejected. The author has been notified and can upload a new file.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('Error rejecting verification: ') . $e->getMessage());
        }
    }
}

