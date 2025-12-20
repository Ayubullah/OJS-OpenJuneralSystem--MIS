<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $editors = User::where('role', 'editor')->latest()->paginate(10);
        return view('admin.editors.index', compact('editors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.editors.create');
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
            'status' => 'required|in:active,inactive'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'editor',
            'status' => $request->status
        ]);

        return redirect()->route('admin.editors.index')
            ->with('success', 'Editor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $editor)
    {
        return view('admin.editors.show', compact('editor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $editor)
    {
        return view('admin.editors.edit', compact('editor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $editor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $editor->id,
            'username' => 'required|string|max:255|unique:users,username,' . $editor->id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive'
        ]);

        $editor->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'status' => $request->status,
            'password' => $request->password ? Hash::make($request->password) : $editor->password
        ]);

        return redirect()->route('admin.editors.index')
            ->with('success', 'Editor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $editor)
    {
        $editor->delete();

        return redirect()->route('admin.editors.index')
            ->with('success', 'Editor deleted successfully.');
    }
}
