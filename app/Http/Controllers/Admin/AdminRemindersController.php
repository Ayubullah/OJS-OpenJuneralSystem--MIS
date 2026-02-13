<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\EditorMessage;
use App\Models\Editor;
use App\Models\Reviewer;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminRemindersController extends Controller
{
    /**
     * Display reminders/messages management page
     */
    public function index()
    {
        // Get all submissions with their articles
        $submissions = Submission::with([
            'article.journal',
            'article.author',
            'article.category',
            'author',
            'reviews.reviewer.user'
        ])
        ->latest()
        ->paginate(15);

        // Get all editors
        $editors = Editor::with('user')
            ->where('status', 'active')
            ->get();

        // Get all reviewers
        $reviewers = Reviewer::with('user')
            ->where('status', 'active')
            ->get();

        // Get all admin messages sent by this admin
        try {
            if (!Schema::hasTable('editor_messages')) {
                $authorMessages = collect([]);
                $reviewerMessages = collect([]);
                $editorMessages = collect([]);
            } else {
                $allMessages = EditorMessage::with([
                    'article.journal',
                    'article.author',
                    'author',
                    'reviewer.user',
                    'editorRecipient',
                    'editor'
                ])
                ->where('editor_id', Auth::id())
                ->where('sender_type', 'admin')
                ->orderBy('created_at', 'desc')
                ->get();
                
                // Separate messages into categories
                $authorMessages = $allMessages->filter(function($msg) {
                    return $msg->recipient_type === 'author';
                });
                
                $reviewerMessages = $allMessages->filter(function($msg) {
                    return $msg->recipient_type === 'reviewer';
                });
                
                $editorMessages = $allMessages->filter(function($msg) {
                    return $msg->recipient_type === 'editor';
                });
            }
        } catch (\Exception $e) {
            $authorMessages = collect([]);
            $reviewerMessages = collect([]);
            $editorMessages = collect([]);
        }

        return view('admin.reminders.index', compact('submissions', 'editors', 'reviewers', 'authorMessages', 'reviewerMessages', 'editorMessages'));
    }

    /**
     * Send message to authors, reviewers, or editors
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:10|max:2000',
            'recipient_type' => 'required|in:author,reviewer,editor,all',
            'submission_id' => 'required_if:recipient_type,author,reviewer,all|exists:submissions,id',
            'editor_id' => 'required_if:recipient_type,editor|exists:users,id',
            'reviewer_id' => 'required_if:recipient_type,reviewer|exists:reviewers,id',
        ]);

        DB::beginTransaction();
        try {
            $adminName = Auth::user()->name ?? 'Admin';

            // Send to author
            if ($request->recipient_type === 'author' || $request->recipient_type === 'all') {
                $submission = Submission::with(['article', 'author'])->findOrFail($request->submission_id);
                
                EditorMessage::create([
                    'article_id' => $submission->article_id,
                    'submission_id' => $submission->id,
                    'editor_id' => Auth::id(),
                    'sender_type' => 'admin',
                    'author_id' => $submission->author_id,
                    'message' => $request->message,
                    'recipient_type' => 'author',
                ]);

                $authorUser = User::where('email', $submission->author->email)->first();
                if ($authorUser) {
                    Notification::create([
                        'user_id' => $authorUser->id,
                        'type' => 'reminder',
                        'message' => "New message from {$adminName} about your article: \"{$submission->article->title}\"",
                        'status' => 'unread',
                    ]);
                }
            }

            // Send to reviewers
            if ($request->recipient_type === 'reviewer' || $request->recipient_type === 'all') {
                $submission = Submission::with(['reviews.reviewer.user'])->findOrFail($request->submission_id);
                $reviewers = $submission->reviews()->with('reviewer.user')->get();

                if ($request->has('reviewer_id')) {
                    // Send to specific reviewer
                    $review = $submission->reviews()->where('reviewer_id', $request->reviewer_id)->first();
                    if ($review) {
                        EditorMessage::create([
                            'article_id' => $submission->article_id,
                            'submission_id' => $submission->id,
                            'editor_id' => Auth::id(),
                            'sender_type' => 'admin',
                            'reviewer_id' => $review->reviewer_id,
                            'message' => $request->message,
                            'recipient_type' => 'reviewer',
                        ]);

                        if ($review->reviewer->user) {
                            Notification::create([
                                'user_id' => $review->reviewer->user->id,
                                'type' => 'reminder',
                                'message' => "New message from {$adminName} about your review assignment: \"{$submission->article->title}\"",
                                'status' => 'unread',
                            ]);
                        }
                    }
                } else {
                    // Send to all reviewers
                    foreach ($reviewers as $review) {
                        EditorMessage::create([
                            'article_id' => $submission->article_id,
                            'submission_id' => $submission->id,
                            'editor_id' => Auth::id(),
                            'sender_type' => 'admin',
                            'reviewer_id' => $review->reviewer_id,
                            'message' => $request->message,
                            'recipient_type' => 'reviewer',
                        ]);

                        if ($review->reviewer->user) {
                            Notification::create([
                                'user_id' => $review->reviewer->user->id,
                                'type' => 'reminder',
                                'message' => "New message from {$adminName} about your review assignment: \"{$submission->article->title}\"",
                                'status' => 'unread',
                            ]);
                        }
                    }
                }
            }

            // Send to editor
            if ($request->recipient_type === 'editor') {
                $editor = Editor::with('user')->where('user_id', $request->editor_id)->firstOrFail();
                
                EditorMessage::create([
                    'article_id' => $request->submission_id ? Submission::find($request->submission_id)->article_id : null,
                    'submission_id' => $request->submission_id,
                    'editor_id' => Auth::id(),
                    'sender_type' => 'admin',
                    'editor_recipient_id' => $editor->user_id,
                    'message' => $request->message,
                    'recipient_type' => 'editor',
                ]);

                if ($editor->user) {
                    Notification::create([
                        'user_id' => $editor->user->id,
                        'type' => 'reminder',
                        'message' => "New message from {$adminName}",
                        'status' => 'unread',
                    ]);
                }
            }

            DB::commit();

            $recipientText = match($request->recipient_type) {
                'all' => 'all recipients',
                'author' => 'author',
                'reviewer' => 'reviewer(s)',
                'editor' => 'editor',
                default => 'recipients'
            };

            return redirect()->route('admin.reminders.index')
                ->with('success', "Message sent successfully to {$recipientText}!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error sending message: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing admin message
     */
    public function updateMessage(Request $request, EditorMessage $message)
    {
        // Check if message belongs to this admin
        if ($message->editor_id !== Auth::id() || $message->sender_type !== 'admin') {
            abort(403, 'You do not have permission to edit this message.');
        }

        $request->validate([
            'message' => 'required|string|min:10|max:2000'
        ]);

        try {
            $message->update([
                'message' => $request->message
            ]);

            return redirect()->route('admin.reminders.index')
                ->with('success', 'Message updated successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.reminders.index')
                ->with('error', 'Error updating message: ' . $e->getMessage());
        }
    }

    /**
     * Delete an existing admin message
     */
    public function deleteMessage(EditorMessage $message)
    {
        // Check if message belongs to this admin
        if ($message->editor_id !== Auth::id() || $message->sender_type !== 'admin') {
            abort(403, 'You do not have permission to delete this message.');
        }

        try {
            $message->delete();

            return redirect()->route('admin.reminders.index')
                ->with('success', 'Message deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.reminders.index')
                ->with('error', 'Error deleting message: ' . $e->getMessage());
        }
    }
}
