<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::withCount(['articles', 'submissions'])->latest()->paginate(10);
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:authors,email',
            'affiliation' => 'nullable|string|max:200',
            'specialization' => 'nullable|string|max:100',
            'orcid_id' => 'nullable|string|max:50',
            'author_contributions' => 'nullable|string'
        ]);

        Author::create($request->all());

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author->load(['articles.journal', 'submissions']);
        return view('admin.authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:authors,email,' . $author->id,
            'affiliation' => 'nullable|string|max:200',
            'specialization' => 'nullable|string|max:100',
            'orcid_id' => 'nullable|string|max:50',
            'author_contributions' => 'nullable|string'
        ]);

        $author->update($request->all());

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('admin.authors.index')
            ->with('success', 'Author deleted successfully.');
    }
}

