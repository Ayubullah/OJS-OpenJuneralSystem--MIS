<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Author;
use App\Models\Category;
use App\Models\Editor;
use App\Models\EditorMessage;
use App\Models\Notification;
use App\Models\User;
use App\Models\Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with([
            'journal', 
            'author', 
            'category', 
            'submissions.reviews.reviewer'
        ])->latest()->paginate(10);
        $journals = Journal::where('status', 'active')->get();
        $categories = Category::all();
        return view('admin.articles.index', compact('articles', 'journals', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $journals = Journal::where('status', 'active')->get();
        $authors = Author::all();
        $categories = Category::all();
        
        return view('admin.articles.create', compact('journals', 'authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:300',
            'journal_id' => 'required|exists:journals,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:submitted,under_review,revision_required,accepted,published,rejected'
        ]);

        Article::create($request->all());

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load([
            'journal', 
            'author', 
            'category', 
            'keywords',
            'submissions' => function($query) {
                $query->with([
                    'reviews' => function($reviewQuery) {
                        $reviewQuery->with([
                            'reviewer.user',
                            'reviewer.journal'
                        ])->orderBy('created_at', 'desc');
                    }
                ])->orderBy('version_number', 'desc');
            }
        ]);
        
        // Get all active editors for the reminder form
        $editors = Editor::with('user')
            ->where('status', 'active')
            ->get();
        
        return view('admin.articles.show', compact('article', 'editors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $journals = Journal::where('status', 'active')->get();
        $authors = Author::all();
        $categories = Category::all();
        
        return view('admin.articles.edit', compact('article', 'journals', 'authors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:300',
            'journal_id' => 'required|exists:journals,id',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:submitted,under_review,revision_required,accepted,published,rejected',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date'
        ]);

        // Prepare update data
        $updateData = [
            'title' => $request->title,
            'journal_id' => $request->journal_id,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ];

        // Handle date fields if provided
        $hasManualTimestamps = false;
        if ($request->filled('created_at')) {
            $updateData['created_at'] = $request->created_at;
            $hasManualTimestamps = true;
        }
        if ($request->filled('updated_at')) {
            $updateData['updated_at'] = $request->updated_at;
            $hasManualTimestamps = true;
        }

        // Update article record
        if ($hasManualTimestamps) {
            // Temporarily disable automatic timestamps when manually setting them
            Article::withoutTimestamps(function () use ($article, $updateData) {
                $article->update($updateData);
            });
        } else {
            $article->update($updateData);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    /**
     * Send reminder message from article detail page
     */
    public function sendReminder(Request $request, Article $article)
    {
        $request->validate([
            'message' => 'required|string|min:10|max:2000',
            'recipient_type' => 'required|string',
            'submission_id' => 'nullable|exists:submissions,id',
        ]);

        DB::beginTransaction();
        try {
            $adminName = Auth::user()->name ?? 'Admin';
            $submission = $article->submissions()->first();
            
            if (!$submission && $request->submission_id) {
                $submission = \App\Models\Submission::find($request->submission_id);
            }

            // Handle recipient type
            $recipientType = $request->recipient_type;
            $reviewerId = null;
            $editorId = null;

            // Check if it's a specific reviewer
            if (str_starts_with($recipientType, 'reviewer_')) {
                $reviewerId = str_replace('reviewer_', '', $recipientType);
                $recipientType = 'reviewer';
            }
            
            // Check if it's a specific editor
            if (str_starts_with($recipientType, 'editor_')) {
                $editorId = str_replace('editor_', '', $recipientType);
                $recipientType = 'editor';
            }

            // Send to author
            if ($recipientType === 'author') {
                if (!$submission) {
                    return redirect()->back()
                        ->with('error', 'No submission found for this article.');
                }

                EditorMessage::create([
                    'article_id' => $article->id,
                    'submission_id' => $submission->id,
                    'editor_id' => Auth::id(),
                    'sender_type' => 'admin',
                    'author_id' => $article->author_id,
                    'message' => $request->message,
                    'recipient_type' => 'author',
                ]);

                $authorUser = User::where('email', $article->author->email)->first();
                if ($authorUser) {
                    Notification::create([
                        'user_id' => $authorUser->id,
                        'type' => 'reminder',
                        'message' => "New message from {$adminName} about your article: \"{$article->title}\"",
                        'status' => 'unread',
                    ]);
                }
            }

            // Send to reviewer
            if ($recipientType === 'reviewer') {
                if (!$submission) {
                    return redirect()->back()
                        ->with('error', 'No submission found for this article.');
                }

                if ($reviewerId) {
                    // Send to specific reviewer
                    $review = $submission->reviews()->where('reviewer_id', $reviewerId)->first();
                    if ($review && $review->reviewer) {
                        EditorMessage::create([
                            'article_id' => $article->id,
                            'submission_id' => $submission->id,
                            'editor_id' => Auth::id(),
                            'sender_type' => 'admin',
                            'reviewer_id' => $review->reviewer_id,
                            'message' => $request->message,
                            'recipient_type' => 'reviewer',
                        ]);

                        if ($review->reviewer->user) {
                            Notification::create([
                                'user_id' => $review->reviewer->user->id,
                                'type' => 'reminder',
                                'message' => "New message from {$adminName} about your review assignment: \"{$article->title}\"",
                                'status' => 'unread',
                            ]);
                        }
                    } else {
                        return redirect()->back()
                            ->with('error', 'Reviewer not found for this article.');
                    }
                } else {
                    // Send to all reviewers
                    $reviews = $submission->reviews()->with('reviewer.user')->get();
                    if ($reviews->count() === 0) {
                        return redirect()->back()
                            ->with('error', 'No reviewers assigned to this article.');
                    }

                    foreach ($reviews as $review) {
                        if ($review->reviewer) {
                            EditorMessage::create([
                                'article_id' => $article->id,
                                'submission_id' => $submission->id,
                                'editor_id' => Auth::id(),
                                'sender_type' => 'admin',
                                'reviewer_id' => $review->reviewer_id,
                                'message' => $request->message,
                                'recipient_type' => 'reviewer',
                            ]);

                            if ($review->reviewer->user) {
                                Notification::create([
                                    'user_id' => $review->reviewer->user->id,
                                    'type' => 'reminder',
                                    'message' => "New message from {$adminName} about your review assignment: \"{$article->title}\"",
                                    'status' => 'unread',
                                ]);
                            }
                        }
                    }
                }
            }

            // Send to editor
            if ($recipientType === 'editor') {
                if (!$editorId) {
                    return redirect()->back()
                        ->with('error', 'Editor ID is required.');
                }

                $editor = Editor::with('user')->where('user_id', $editorId)->first();
                if (!$editor) {
                    return redirect()->back()
                        ->with('error', 'Editor not found.');
                }

                EditorMessage::create([
                    'article_id' => $article->id,
                    'submission_id' => $submission ? $submission->id : null,
                    'editor_id' => Auth::id(),
                    'sender_type' => 'admin',
                    'editor_recipient_id' => $editor->user_id,
                    'message' => $request->message,
                    'recipient_type' => 'editor',
                ]);

                if ($editor->user) {
                    Notification::create([
                        'user_id' => $editor->user->id,
                        'type' => 'reminder',
                        'message' => "New message from {$adminName} about article: \"{$article->title}\"",
                        'status' => 'unread',
                    ]);
                }
            }

            DB::commit();

            $recipientText = match($recipientType) {
                'author' => 'author',
                'reviewer' => $reviewerId ? 'reviewer' : 'reviewers',
                'editor' => 'editor',
                default => 'recipient'
            };

            return redirect()->back()
                ->with('success', "Reminder sent successfully to {$recipientText}!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error sending reminder: ' . $e->getMessage());
        }
    }
}
