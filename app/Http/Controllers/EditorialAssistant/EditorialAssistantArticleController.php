<?php

namespace App\Http\Controllers\EditorialAssistant;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Submission;
use App\Models\EditorialAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorialAssistantArticleController extends Controller
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
     * Display a listing of accepted articles.
     */
    public function index(Request $request)
    {
        $journalIds = $this->getEditorialAssistantJournalIds();
        
        $query = Article::where('status', 'accepted')
            ->with(['journal', 'author', 'category']);
        
        // Filter by assigned journals
        if ($journalIds !== null) {
            $query->whereIn('journal_id', $journalIds);
        }

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
     * Display the specified accepted article.
     */
    public function show(Article $article)
    {
        // Ensure the article is accepted
        if ($article->status !== 'accepted') {
            return redirect()->route('editorial_assistant.articles.index')
                ->with('error', 'This article is not accepted.');
        }

        // Check if editorial assistant has access to this article's journal
        $journalIds = $this->getEditorialAssistantJournalIds();
        if ($journalIds !== null && !in_array($article->journal_id, $journalIds)) {
            return redirect()->route('editorial_assistant.articles.index')
                ->with('error', 'You do not have access to this article.');
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
        
        // Load editor messages for this article
        $editorMessages = \App\Models\EditorMessage::where('article_id', $article->id)
            ->where(function($query) use ($submission) {
                if ($submission) {
                    $query->where('submission_id', $submission->id)
                          ->orWhereNull('submission_id');
                } else {
                    $query->whereNull('submission_id');
                }
            })
            ->with(['editor', 'editorRecipient'])
            ->latest()
            ->get();

        return view('editorial_assistant.articles.show', compact('article', 'submission', 'allSubmissions', 'editorMessages'));
    }
}

