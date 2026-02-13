<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reviewer;
use App\Models\User;
use App\Models\Review;
use App\Models\Submission;
use App\Models\Journal;
use App\Models\Notification;
use App\Models\EditorMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviewers = Reviewer::with(['user', 'journal'])->withCount('reviews')->latest()->paginate(10);
        $journals = Journal::where('status', 'active')->get();
        return view('admin.reviewers.index', compact('reviewers', 'journals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'reviewer')->get();
        $journals = Journal::where('status', 'active')->get();
        return view('admin.reviewers.create', compact('users', 'journals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:reviewers,user_id',
            'journal_id' => 'required|exists:journals,id',
            'email' => 'required|email|max:100',
            'expertise' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'review_format_file' => 'nullable|file|mimes:doc,docx,pdf|max:10240'
        ]);

        DB::beginTransaction();
        try {
            // Update user with website if provided
            if ($request->filled('website')) {
                $user = User::findOrFail($request->user_id);
                $user->update(['website' => $request->website]);
            }

            // Handle review format file upload
            $reviewFormatFile = null;
            if ($request->hasFile('review_format_file')) {
                $file = $request->file('review_format_file');
                $fileName = 'review_format_' . time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('review_formats', $fileName, 'public');
                $reviewFormatFile = $filePath;
            }

            // Create reviewer record
            Reviewer::create([
                'user_id' => $request->user_id,
                'journal_id' => $request->journal_id,
                'email' => $request->email,
                'expertise' => $request->expertise,
                'specialization' => $request->specialization,
                'status' => $request->status,
                'review_format_file' => $reviewFormatFile
            ]);

            DB::commit();

            return redirect()->route('admin.reviewers.index')
                ->with('success', 'Reviewer created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error creating reviewer: ' . $e->getMessage())
                ->withInput();
        }
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
        $reviewer->load('user', 'journal');
        $users = User::where('role', 'reviewer')->get();
        $journals = Journal::where('status', 'active')->get();
        return view('admin.reviewers.edit', compact('reviewer', 'users', 'journals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reviewer $reviewer)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:reviewers,user_id,' . $reviewer->id,
            'journal_id' => 'required|exists:journals,id',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $reviewer->user_id,
            'email' => 'required|email|max:255|unique:users,email,' . $reviewer->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
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
            if ($request->filled('website')) {
                $userData['website'] = $request->website;
            } else {
                $userData['website'] = null;
            }

            // Update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Handle review format file upload
            $reviewFormatFile = $reviewer->review_format_file; // Keep existing file by default
            if ($request->hasFile('review_format_file')) {
                // Delete old file if exists
                if ($reviewer->review_format_file && Storage::disk('public')->exists($reviewer->review_format_file)) {
                    Storage::disk('public')->delete($reviewer->review_format_file);
                }
                
                // Upload new file
                $file = $request->file('review_format_file');
                $fileName = 'review_format_' . time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('review_formats', $fileName, 'public');
                $reviewFormatFile = $filePath;
            }

            // Update reviewer information
            $reviewer->update([
                'user_id' => $request->user_id,
                'journal_id' => $request->journal_id,
                'email' => $request->reviewer_email,
                'expertise' => $request->expertise,
                'specialization' => $request->specialization,
                'status' => $request->status,
                'review_format_file' => $reviewFormatFile
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

    /**
     * Send reminder to reviewer about their review assignment (Admin)
     */
    public function sendReminderToReviewer(Request $request, Review $review)
    {
        $request->validate([
            'message' => 'required|string|min:10|max:2000'
        ]);

        DB::beginTransaction();
        try {
            $review->load(['submission', 'reviewer.user']);
            $adminName = Auth::user()->name ?? 'Admin';

            // Store message for reviewer
            EditorMessage::create([
                'article_id' => $review->submission->article_id,
                'submission_id' => $review->submission_id,
                'editor_id' => Auth::id(),
                'sender_type' => 'admin',
                'reviewer_id' => $review->reviewer_id,
                'message' => $request->message,
                'recipient_type' => 'reviewer',
            ]);

            // Create notification for reviewer if they have a user account
            if ($review->reviewer->user) {
                Notification::create([
                    'user_id' => $review->reviewer->user->id,
                    'type' => 'reminder',
                    'message' => "New message from {$adminName} about your review assignment: \"{$review->submission->article->title}\"",
                    'status' => 'unread',
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Message sent successfully to the reviewer!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error sending message: ' . $e->getMessage());
        }
    }

    /**
     * Send reminder to author about their article (Admin)
     */
    public function sendReminderToAuthor(Request $request, Submission $submission)
    {
        $request->validate([
            'message' => 'required|string|min:10|max:2000'
        ]);

        DB::beginTransaction();
        try {
            $submission->load(['article', 'author']);
            $adminName = Auth::user()->name ?? 'Admin';

            // Store message for author
            EditorMessage::create([
                'article_id' => $submission->article_id,
                'submission_id' => $submission->id,
                'editor_id' => Auth::id(),
                'sender_type' => 'admin',
                'author_id' => $submission->author_id,
                'message' => $request->message,
                'recipient_type' => 'author',
            ]);

            // Create notification for author if they have a user account
            $authorUser = User::where('email', $submission->author->email)->first();
            if ($authorUser) {
                Notification::create([
                    'user_id' => $authorUser->id,
                    'type' => 'reminder',
                    'message' => "New message from {$adminName} about your article: \"{$submission->article->title}\"",
                    'status' => 'unread',
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Message sent successfully to the author!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error sending message: ' . $e->getMessage());
        }
    }
}

