<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Submission;
use App\Models\Review;
use App\Models\Notification;
use App\Models\EditorMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Get or create the author profile for the authenticated user.
     */
    private function getOrCreateAuthor()
    {
        $author = Author::where('email', Auth::user()->email)->first();
        
        // Auto-create author profile if it doesn't exist
        if (!$author) {
            $author = Author::create([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'affiliation' => '',
                'specialization' => '',
                'orcid_id' => '',
                'author_contributions' => ''
            ]);
        }
        
        return $author;
    }

    /**
     * Display the dashboard.
     */
    public function index()
    {
        $author = $this->getOrCreateAuthor();
        
        // Statistics
        $stats = [
            'total_articles' => Article::where('author_id', $author->id)->count(),
            'submitted' => Article::where('author_id', $author->id)
                ->where('status', 'submitted')->count(),
            'under_review' => Article::where('author_id', $author->id)
                ->where('status', 'under_review')->count(),
            'revision_required' => Article::where('author_id', $author->id)
                ->where('status', 'revision_required')->count(),
            'accepted' => Article::where('author_id', $author->id)
                ->where('status', 'accepted')->count(),
            'published' => Article::where('author_id', $author->id)
                ->where('status', 'published')->count(),
            'rejected' => Article::where('author_id', $author->id)
                ->where('status', 'rejected')->count(),
        ];

        // Recent articles
        $recent_articles = Article::where('author_id', $author->id)
            ->with(['journal', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        // Recent submissions
        $recent_submissions = Submission::where('author_id', $author->id)
            ->with(['article.journal', 'reviews'])
            ->latest()
            ->limit(5)
            ->get();

        // Unread notifications count
        $unread_notifications_count = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        // Recent reviews (approved reviews on author's submissions)
        $recent_reviews = Review::whereHas('submission', function($q) use ($author) {
                $q->where('author_id', $author->id);
            })
            ->where('editor_approved', true)
            ->with(['reviewer.user', 'submission.article'])
            ->latest()
            ->limit(5)
            ->get();

        // Articles by status (for potential future use in charts)
        $articles_by_status = Article::select('status', DB::raw('count(*) as total'))
            ->where('author_id', $author->id)
            ->groupBy('status')
            ->get();

        // Get all messages for this author
        $allMessages = EditorMessage::where(function($query) use ($author) {
                $query->where(function($q) use ($author) {
                    $q->where('author_id', $author->id)
                      ->where(function($q2) {
                          $q2->where('recipient_type', 'author')
                            ->orWhere('recipient_type', 'both');
                      });
                })
                ->orWhere(function($q) use ($author) {
                    // Admin messages sent to this specific author
                    $q->where('sender_type', 'admin')
                      ->where('recipient_type', 'author')
                      ->where('author_id', $author->id);
                });
            })
            ->with(['editor', 'editorRecipient', 'article'])
            ->latest()
            ->get();

        return view('author.dashboard', compact(
            'stats',
            'recent_articles',
            'recent_submissions',
            'recent_reviews',
            'articles_by_status',
            'unread_notifications_count',
            'author',
            'allMessages'
        ));
    }
}
