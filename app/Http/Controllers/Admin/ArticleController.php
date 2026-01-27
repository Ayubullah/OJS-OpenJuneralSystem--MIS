<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

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
        return view('admin.articles.show', compact('article'));
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
            'status' => 'required|in:submitted,under_review,revision_required,accepted,published,rejected'
        ]);

        $article->update($request->all());

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
}
