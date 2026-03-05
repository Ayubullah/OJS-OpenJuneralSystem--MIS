<?php

namespace App\Http\Controllers\ChiefEditor;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;

class ChiefEditorController extends Controller
{
    /**
     * Display the Chief Editor dashboard.
     */
    public function index()
    {
        $articlesQuery = Article::where('status', 'chief_editor_review');
        $submissionsQuery = Submission::where('status', 'chief_editor_review');

        $stats = [
            'total_pending' => (clone $articlesQuery)->count(),
            'recent_pending' => (clone $articlesQuery)
                ->where('updated_at', '>=', now()->subDays(7))
                ->count(),
        ];

        $recent_articles = (clone $articlesQuery)
            ->with(['journal', 'author', 'category'])
            ->latest()
            ->limit(10)
            ->get();

        return view('chief_editor.dashboard', compact('stats', 'recent_articles'));
    }

    /**
     * List articles for Chief Editor review.
     */
    public function articles(\Illuminate\Http\Request $request)
    {
        $query = Article::where('status', 'chief_editor_review')
            ->with(['journal', 'author', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abstract', 'like', "%{$search}%")
                    ->orWhereHas('author', fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                    ->orWhereHas('journal', fn ($q) => $q->where('name', 'like', "%{$search}%"));
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

        return view('chief_editor.articles.index', compact('articles', 'journals', 'categories'));
    }

    /**
     * Show article for Chief Editor review (Accept/Reject).
     */
    public function show(Article $article)
    {
        if ($article->status !== 'chief_editor_review') {
            return redirect()->route('chief_editor.dashboard')
                ->with('error', __('This article is not pending Chief Editor review.'));
        }

        $article->load(['journal', 'author', 'category', 'keywords', 'submissions']);

        $submission = Submission::where('article_id', $article->id)
            ->orderBy('version_number', 'desc')
            ->with(['article.journal', 'author', 'reviews.reviewer.user'])
            ->first();

        $allSubmissions = Submission::where('article_id', $article->id)
            ->orderBy('version_number', 'desc')
            ->with(['reviews.reviewer.user'])
            ->get();

        $editorMessages = \App\Models\EditorMessage::where('article_id', $article->id)
            ->where(function ($q) {
                $q->where('recipient_type', 'author')
                    ->orWhere('recipient_type', 'both');
            })
            ->with(['editor', 'editorRecipient'])
            ->latest()
            ->get();

        return view('chief_editor.articles.show', compact('article', 'submission', 'allSubmissions', 'editorMessages'));
    }

    /**
     * Chief Editor accepts - set status to approved_chief_editor.
     */
    public function accept(\Illuminate\Http\Request $request, Article $article)
    {
        if ($article->status !== 'chief_editor_review') {
            return redirect()->back()->with('error', __('This article is not pending review.'));
        }

        $submission = Submission::where('article_id', $article->id)->orderBy('version_number', 'desc')->first();
        if (!$submission) {
            return redirect()->back()->with('error', __('No submission found.'));
        }

        $submission->update([
            'status' => 'approved_chief_editor',
            'chief_editor_comment' => $request->input('comment'),
        ]);
        $article->update(['status' => 'approved_chief_editor']);

        return redirect()->route('chief_editor.articles')
            ->with('success', __('Article approved successfully.'));
    }

    /**
     * Chief Editor rejects - keep status accepted, save comment for Editor.
     */
    public function reject(\Illuminate\Http\Request $request, Article $article)
    {
        if ($article->status !== 'chief_editor_review') {
            return redirect()->back()->with('error', __('This article is not pending review.'));
        }

        $request->validate(['comment' => 'required|string|max:2000']);

        $submission = Submission::where('article_id', $article->id)->orderBy('version_number', 'desc')->first();
        if (!$submission) {
            return redirect()->back()->with('error', __('No submission found.'));
        }

        $submission->update([
            'status' => 'accepted',
            'chief_editor_comment' => $request->input('comment'),
        ]);
        $article->update(['status' => 'accepted']);

        return redirect()->route('chief_editor.articles')
            ->with('success', __('Article rejected with comment. Editor has been notified.'));
    }
}
