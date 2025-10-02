<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journals = Journal::withCount('articles')->latest()->paginate(10);
        return view('admin.journals.index', compact('journals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.journals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'issn' => 'required|string|max:20|unique:journals,issn',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        Journal::create($request->all());

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        $journal->load(['articles.author', 'issues']);
        return view('admin.journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        return view('admin.journals.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journal $journal)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'issn' => 'required|string|max:20|unique:journals,issn,' . $journal->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $journal->update($request->all());

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        $journal->delete();

        return redirect()->route('admin.journals.index')
            ->with('success', 'Journal deleted successfully.');
    }
}
