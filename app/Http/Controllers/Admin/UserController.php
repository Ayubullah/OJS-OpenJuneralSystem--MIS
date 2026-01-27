<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Journal;
use App\Models\Editor;
use App\Models\Reviewer;
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
            'role' => 'required|in:admin,editor,reviewer,author',
            'status' => 'required|in:active,inactive'
        ];

        // Add website validation only for admin role
        if ($request->role === 'admin') {
            $rules['website'] = 'nullable|url|max:255';
        }

        // Add conditional validation for editor/reviewer roles
        if ($request->role === 'editor') {
            $rules['journal_id'] = 'required|exists:journals,id';
        } elseif ($request->role === 'reviewer') {
            $rules['journal_id'] = 'required|exists:journals,id';
            $rules['reviewer_email'] = 'required|email|max:100|unique:reviewers,email';
            $rules['expertise'] = 'nullable|string|max:100';
            $rules['specialization'] = 'nullable|string|max:100';
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
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,reviewer,author',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->only(['name', 'username', 'email', 'role', 'status']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
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
}
