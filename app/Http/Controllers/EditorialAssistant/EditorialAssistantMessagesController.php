<?php

namespace App\Http\Controllers\EditorialAssistant;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\EditorMessage;
use Illuminate\Support\Facades\Auth;

class EditorialAssistantMessagesController extends Controller
{
    /**
     * Display messages page with tabs (Articles to send from, Author Messages).
     */
    public function index()
    {
        // Articles that editorial assistant can send messages for (accepted, approved_chief_editor, pending_verify)
        $articles = Article::with(['journal', 'author', 'category'])
            ->whereIn('status', ['accepted', 'approved_chief_editor', 'pending_verify'])
            ->latest()
            ->paginate(15);

        // Messages: sent by this EA + received from admin + received from editor
        $allMessages = EditorMessage::with([
            'article.journal',
            'article.author',
            'author',
            'editor',
            'editorRecipient'
        ])
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('editor_id', Auth::id())
                        ->where('sender_type', 'editorial_assistant');
                })
                ->orWhere(function ($q) {
                    $q->where('editor_recipient_id', Auth::id())
                        ->whereIn('sender_type', ['admin', 'editor']);
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $authorMessages = $allMessages->filter(fn ($msg) => $msg->recipient_type === 'author' && $msg->sender_type !== 'admin');
        $editorMessages = $allMessages->filter(fn ($msg) => $msg->sender_type === 'editor');
        $adminMessages = $allMessages->filter(fn ($msg) => $msg->sender_type === 'admin');

        return view('editorial_assistant.messages.index', compact('articles', 'authorMessages', 'editorMessages', 'adminMessages'));
    }
}
