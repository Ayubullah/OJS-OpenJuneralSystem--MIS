<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            'email' => 'required|email|max:100|unique:users,email',
            'affiliation' => 'nullable|string|max:200',
            'specialization' => 'nullable|string|max:100',
            'orcid_id' => 'nullable|string|max:50',
            'author_contributions' => 'nullable|string',
            'website' => 'nullable|url|max:255'
        ]);

        DB::beginTransaction();
        try {
            // Create user account for the author
            $user = User::create([
                'name' => $request->name,
                'username' => $this->generateUsername($request->name),
                'email' => $request->email,
                'password' => Hash::make('password123'), // Default password
                'role' => 'author',
                'status' => 'active',
                'website' => $request->website,
            ]);

            // Create author record
            Author::create([
                'name' => $request->name,
                'email' => $request->email,
                'affiliation' => $request->affiliation,
                'specialization' => $request->specialization,
                'orcid_id' => $request->orcid_id,
                'author_contributions' => $request->author_contributions,
            ]);

            DB::commit();

            return redirect()->route('admin.authors.index')
                ->with('success', 'Author created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error creating author: ' . $e->getMessage())
                ->withInput();
        }
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
            'author_contributions' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'created_at' => 'nullable|date',
            'updated_at' => 'nullable|date'
        ]);

        DB::beginTransaction();
        try {
            // Prepare update data
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'affiliation' => $request->affiliation,
                'specialization' => $request->specialization,
                'orcid_id' => $request->orcid_id,
                'author_contributions' => $request->author_contributions,
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

            // Update author record
            if ($hasManualTimestamps) {
                // Temporarily disable automatic timestamps when manually setting them
                $author::withoutTimestamps(function () use ($author, $updateData) {
                    $author->update($updateData);
                });
            } else {
                $author->update($updateData);
            }

            // Find and update associated user record if it exists
            $user = User::where('email', $author->email)->first();
            if ($user && $request->filled('website')) {
                $user->update(['website' => $request->website]);
            }

            DB::commit();

            return redirect()->route('admin.authors.index')
                ->with('success', 'Author updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error updating author: ' . $e->getMessage())
                ->withInput();
        }
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

    /**
     * Generate a unique username from the author's name.
     */
    private function generateUsername($name)
    {
        $baseUsername = strtolower(str_replace(' ', '', $name));
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}

