<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Editor;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $editors = Editor::with(['user', 'journal'])->latest()->paginate(10);
        $journals = Journal::where('status', 'active')->get();
        return view('admin.editors.index', compact('editors', 'journals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $journals = Journal::where('status', 'active')->get();
        return view('admin.editors.create', compact('journals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'journal_id' => 'required|exists:journals,id',
            'status' => 'required|in:active,inactive'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'editor',
                'status' => $request->status
            ]);

            Editor::create([
                'user_id' => $user->id,
                'journal_id' => $request->journal_id,
                'status' => $request->status
            ]);

            DB::commit();

            return redirect()->route('admin.editors.index')
                ->with('success', 'Editor created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error creating editor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Editor $editor)
    {
        $editor->load(['user', 'journal']);
        return view('admin.editors.show', compact('editor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Editor $editor)
    {
        $editor->load(['user', 'journal']);
        $journals = Journal::where('status', 'active')->get();
        return view('admin.editors.edit', compact('editor', 'journals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Editor $editor)
    {
        $editor->load('user');
        $user = $editor->user;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'journal_id' => 'required|exists:journals,id',
            'status' => 'required|in:active,inactive'
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'status' => $request->status,
            ];

            if ($request->password) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $editor->update([
                'journal_id' => $request->journal_id,
                'status' => $request->status
            ]);

            DB::commit();

            return redirect()->route('admin.editors.index')
                ->with('success', 'Editor updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error updating editor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Editor $editor)
    {
        DB::beginTransaction();
        try {
            $user = $editor->user;
            $editor->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('admin.editors.index')
                ->with('success', 'Editor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error deleting editor: ' . $e->getMessage());
        }
    }
}
