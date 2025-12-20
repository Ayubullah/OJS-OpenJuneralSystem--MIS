<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reviewer;
use App\Models\User;
use App\Models\Review;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviewers = Reviewer::with('user')->withCount('reviews')->latest()->paginate(10);
        return view('admin.reviewers.index', compact('reviewers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'reviewer')->get();
        return view('admin.reviewers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:reviewers,user_id',
            'email' => 'required|email|max:100',
            'expertise' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive'
        ]);

        Reviewer::create($request->all());

        return redirect()->route('admin.reviewers.index')
            ->with('success', 'Reviewer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reviewer $reviewer)
    {
        $reviewer->load(['user', 'reviews.submission.article']);
        return view('admin.reviewers.show', compact('reviewer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reviewer $reviewer)
    {
        $reviewer->load('user');
        $users = User::where('role', 'reviewer')->get();
        return view('admin.reviewers.edit', compact('reviewer', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reviewer $reviewer)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:reviewers,user_id,' . $reviewer->id,
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $reviewer->user_id,
            'email' => 'required|email|max:255|unique:users,email,' . $reviewer->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'reviewer_email' => 'required|email|max:100',
            'expertise' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive'
        ]);

        DB::beginTransaction();
        try {
            // Get the user to update (use the selected user_id, not the current reviewer's user)
            $user = User::findOrFail($request->user_id);
            
            $userData = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ];

            // Add optional user fields if provided
            if ($request->filled('phone')) {
                $userData['phone'] = $request->phone;
            } else {
                $userData['phone'] = null;
            }
            if ($request->filled('bio')) {
                $userData['bio'] = $request->bio;
            } else {
                $userData['bio'] = null;
            }
            if ($request->filled('address')) {
                $userData['address'] = $request->address;
            } else {
                $userData['address'] = null;
            }
            if ($request->filled('city')) {
                $userData['city'] = $request->city;
            } else {
                $userData['city'] = null;
            }
            if ($request->filled('country')) {
                $userData['country'] = $request->country;
            } else {
                $userData['country'] = null;
            }

            // Update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Update reviewer information
            $reviewer->update([
                'user_id' => $request->user_id,
                'email' => $request->reviewer_email,
                'expertise' => $request->expertise,
                'specialization' => $request->specialization,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.reviewers.index')
                ->with('success', 'Reviewer updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error updating reviewer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reviewer $reviewer)
    {
        $reviewer->delete();

        return redirect()->route('admin.reviewers.index')
            ->with('success', 'Reviewer deleted successfully.');
    }

    /**
     * Display articles assigned to reviewers.
     */
    public function articles()
    {
        // Get all reviews with their related data
        $reviews = Review::with([
            'reviewer.user',
            'submission.article.journal',
            'submission.article.author',
            'submission.article.category'
        ])
        ->whereHas('reviewer', function($query) {
            $query->where('status', 'active');
        })
        ->latest()
        ->paginate(15);

        // Get unique reviewers for filter dropdown
        $reviewers = Reviewer::with('user')
            ->where('status', 'active')
            ->get();

        return view('admin.reviewers.articles', compact('reviews', 'reviewers'));
    }

    /**
     * Display articles assigned to a specific reviewer.
     */
    public function reviewerArticles(Reviewer $reviewer)
    {
        $reviews = $reviewer->reviews()
            ->with([
                'submission.article.journal',
                'submission.article.author',
                'submission.article.category'
            ])
            ->latest()
            ->paginate(15);

        return view('admin.reviewers.reviewer-articles', compact('reviews', 'reviewer'));
    }
}

