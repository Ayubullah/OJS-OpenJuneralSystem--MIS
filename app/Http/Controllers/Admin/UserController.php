<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\Editor;
use App\Models\Reviewer;
use App\Models\EditorialAssistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('reviewer')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $journals = Journal::where('status', 'active')->get();
        return view('admin.users.create', compact('journals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,editorial_assistant,reviewer,author',
            'status' => 'required|in:active,inactive'
        ];

        // Add website validation only for admin role
        if ($request->role === 'admin') {
            $rules['website'] = 'nullable|url|max:255';
        }

        // Add conditional validation for editor/reviewer/editorial_assistant roles
        if ($request->role === 'editor') {
            $rules['journal_id'] = 'required|exists:journals,id';
        } elseif ($request->role === 'reviewer') {
            $rules['journal_id'] = 'required|exists:journals,id';
            $rules['reviewer_email'] = 'required|email|max:100|unique:reviewers,email';
            $rules['expertise'] = 'nullable|string|max:100';
            $rules['specialization'] = 'nullable|string|max:100';
        } elseif ($request->role === 'editorial_assistant') {
            // Journal is optional - null means all journals, or specific journal_id
            $rules['journal_id'] = 'nullable|exists:journals,id';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => $request->status,
            ];

            // Add website only for admin role
            if ($request->role === 'admin') {
                $userData['website'] = $request->website;
            }

            $user = User::create($userData);

            // Create editor record if role is editor
            if ($request->role === 'editor') {
                Editor::create([
                    'user_id' => $user->id,
                    'journal_id' => $request->journal_id,
                    'status' => $request->status
                ]);
            }
            // Create reviewer record if role is reviewer
            elseif ($request->role === 'reviewer') {
                Reviewer::create([
                    'user_id' => $user->id,
                    'journal_id' => $request->journal_id,
                    'email' => $request->reviewer_email,
                    'expertise' => $request->expertise,
                    'specialization' => $request->specialization,
                    'status' => $request->status
                ]);
            }
            // Create editorial assistant record if role is editorial_assistant
            elseif ($request->role === 'editorial_assistant') {
                // Handle empty string as null (all journals)
                $journalId = empty($request->journal_id) ? null : $request->journal_id;
                
                // If journal_id is null (all journals), delete any existing specific journal assignments first
                // If journal_id is set, delete any "all journals" record first
                if ($journalId === null) {
                    // All journals - delete any existing specific journal records
                    EditorialAssistant::where('user_id', $user->id)->whereNotNull('journal_id')->delete();
                } else {
                    // Specific journal - delete any "all journals" record
                    EditorialAssistant::where('user_id', $user->id)->whereNull('journal_id')->delete();
                }
                
                // Check if this exact assignment already exists
                $existing = EditorialAssistant::where('user_id', $user->id)
                    ->where('journal_id', $journalId)
                    ->first();
                
                if (!$existing) {
                    EditorialAssistant::create([
                        'user_id' => $user->id,
                        'journal_id' => $journalId,
                        'status' => $request->status
                    ]);
                } else {
                    // Update existing record
                    $existing->update(['status' => $request->status]);
                }
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error creating user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('reviewer');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $journals = Journal::where('status', 'active')->get();
        $editorialAssistant = $user->editorialAssistants()->first();
        return view('admin.users.edit', compact('user', 'journals', 'editorialAssistant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,editorial_assistant,reviewer,author',
            'status' => 'required|in:active,inactive'
        ];

        // Add conditional validation for editor/reviewer/editorial_assistant roles
        if ($request->role === 'editor') {
            $rules['journal_id'] = 'required|exists:journals,id';
        } elseif ($request->role === 'reviewer') {
            $rules['journal_id'] = 'required|exists:journals,id';
            $rules['reviewer_email'] = 'required|email|max:100|unique:reviewers,email,' . ($user->reviewer ? $user->reviewer->id : 'NULL');
            $rules['expertise'] = 'nullable|string|max:100';
            $rules['specialization'] = 'nullable|string|max:100';
        } elseif ($request->role === 'editorial_assistant') {
            // Journal is optional - null means all journals, or specific journal_id
            $rules['journal_id'] = 'nullable|exists:journals,id';
        }

        $request->validate($rules);

        $data = $request->only(['name', 'username', 'email', 'role', 'status']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::beginTransaction();
        try {
            $user->update($data);

            // Handle role-specific updates
            if ($request->role === 'editor') {
                // Update or create editor record
                $editor = $user->editors()->first();
                if ($editor) {
                    $editor->update([
                        'journal_id' => $request->journal_id,
                        'status' => $request->status
                    ]);
                } else {
                    Editor::create([
                        'user_id' => $user->id,
                        'journal_id' => $request->journal_id,
                        'status' => $request->status
                    ]);
                }
                // Remove other role records
                $user->reviewer()->delete();
                $user->editorialAssistants()->delete();
            } elseif ($request->role === 'reviewer') {
                // Update or create reviewer record
                $reviewer = $user->reviewer;
                if ($reviewer) {
                    $reviewer->update([
                        'journal_id' => $request->journal_id,
                        'email' => $request->reviewer_email,
                        'expertise' => $request->expertise,
                        'specialization' => $request->specialization,
                        'status' => $request->status
                    ]);
                } else {
                    Reviewer::create([
                        'user_id' => $user->id,
                        'journal_id' => $request->journal_id,
                        'email' => $request->reviewer_email,
                        'expertise' => $request->expertise,
                        'specialization' => $request->specialization,
                        'status' => $request->status
                    ]);
                }
                // Remove other role records
                $user->editors()->delete();
                $user->editorialAssistants()->delete();
            } elseif ($request->role === 'editorial_assistant') {
                // Handle empty string as null (all journals)
                $journalId = empty($request->journal_id) ? null : $request->journal_id;
                
                // If journal_id is null (all journals), delete any existing specific journal assignments
                // If journal_id is set, delete any "all journals" record
                if ($journalId === null) {
                    // All journals - delete any existing specific journal records
                    EditorialAssistant::where('user_id', $user->id)->whereNotNull('journal_id')->delete();
                } else {
                    // Specific journal - delete any "all journals" record
                    EditorialAssistant::where('user_id', $user->id)->whereNull('journal_id')->delete();
                }
                
                // Update or create editorial assistant record
                $editorialAssistant = EditorialAssistant::where('user_id', $user->id)
                    ->where('journal_id', $journalId)
                    ->first();
                    
                if ($editorialAssistant) {
                    $editorialAssistant->update([
                        'status' => $request->status
                    ]);
                } else {
                    EditorialAssistant::create([
                        'user_id' => $user->id,
                        'journal_id' => $journalId,
                        'status' => $request->status
                    ]);
                }
                
                // Remove other role records
                $user->editors()->delete();
                $user->reviewer()->delete();
            } else {
                // Remove role-specific records if role changed to admin/author
                $user->editors()->delete();
                $user->reviewer()->delete();
                $user->editorialAssistants()->delete();
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error updating user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Display a listing of editorial assistants.
     */
    public function editorialAssistants()
    {
        $users = User::where('role', 'editorial_assistant')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
}
