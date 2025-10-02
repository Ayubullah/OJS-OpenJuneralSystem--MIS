<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->latest()
            ->paginate(10);
        return view('admin.submissions.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::with('journal')->get();
        $authors = Author::all();
        
        return view('admin.submissions.create', compact('articles', 'authors'));
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

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        $submission->load(['article.journal', 'author', 'reviews.reviewer']);
        return view('admin.submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        $articles = Article::with('journal')->get();
        $authors = Author::all();
        
        return view('admin.submissions.edit', compact('submission', 'articles', 'authors'));
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
            'version_number' => 'required|integer|min:1'
        ]);

        $submission->update($request->all());

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission deleted successfully.');
    }
}
