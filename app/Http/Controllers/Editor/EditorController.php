<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Review;
use App\Models\Article;
use App\Models\Editor;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditorController extends Controller
{
    /**
     * Get journal IDs for the current editor
     */
    protected function getEditorJournalIds()
    {
        $editor = Editor::where('user_id', Auth::id())
            ->where('status', 'active')
            ->pluck('journal_id')
            ->toArray();
        
        return $editor ?: [];
    }


    /**
     * Display the dashboard.
     */
    public function index()
    {
        $journalIds = $this->getEditorJournalIds();
        
        // Statistics
        $stats = [
            'total_submissions' => Submission::whereHas('article', function($q) use ($journalIds) {
                if (!empty($journalIds)) {
                    $q->whereIn('journal_id', $journalIds);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })->count(),
            'pending_approvals' => Review::whereNotNull('comments')
                ->where('editor_approved', false)
                ->whereHas('submission.article', function($q) use ($journalIds) {
                    if (!empty($journalIds)) {
                        $q->whereIn('journal_id', $journalIds);
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })
                ->count(),
            'under_review' => Submission::where('status', 'under_review')
                ->whereHas('article', function($q) use ($journalIds) {
                    if (!empty($journalIds)) {
                        $q->whereIn('journal_id', $journalIds);
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })->count(),
            'revision_required' => Submission::where('status', 'revision_required')
                ->whereHas('article', function($q) use ($journalIds) {
                    if (!empty($journalIds)) {
                        $q->whereIn('journal_id', $journalIds);
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })->count(),
            'accepted' => Submission::where('status', 'accepted')
                ->whereHas('article', function($q) use ($journalIds) {
                    if (!empty($journalIds)) {
                        $q->whereIn('journal_id', $journalIds);
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })->count(),
            'published' => Submission::where('status', 'published')
                ->whereHas('article', function($q) use ($journalIds) {
                    if (!empty($journalIds)) {
                        $q->whereIn('journal_id', $journalIds);
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })->count(),
            'rejected' => Submission::where('status', 'rejected')
                ->whereHas('article', function($q) use ($journalIds) {
                    if (!empty($journalIds)) {
                        $q->whereIn('journal_id', $journalIds);
                    } else {
                        $q->whereRaw('1 = 0');
                    }
                })->count(),
        ];

        // Recent submissions
        $recent_submissions = Submission::with(['article.journal', 'author'])
            ->whereHas('article', function($q) use ($journalIds) {
                if (!empty($journalIds)) {
                    $q->whereIn('journal_id', $journalIds);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->latest()
            ->limit(5)
            ->get();

        // Recent reviews
        $recent_reviews = Review::whereHas('submission.article', function($q) use ($journalIds) {
                if (!empty($journalIds)) {
                    $q->whereIn('journal_id', $journalIds);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->with(['submission.article', 'reviewer.user'])
            ->whereNotNull('comments')
            ->latest()
            ->limit(5)
            ->get();

        // Submissions by status
        $submissions_by_status_query = Submission::select('status', DB::raw('count(*) as total'))
            ->whereHas('article', function($q) use ($journalIds) {
                if (!empty($journalIds)) {
                    $q->whereIn('journal_id', $journalIds);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->groupBy('status');
        $submissions_by_status = $submissions_by_status_query->get();

        // Monthly submission trends (last 6 months)
        $monthly_submissions_query = Submission::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->whereHas('article', function($q) use ($journalIds) {
                if (!empty($journalIds)) {
                    $q->whereIn('journal_id', $journalIds);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month');
        $monthly_submissions = $monthly_submissions_query->get();

        // Get journal names for the editor
        $journalNames = Journal::whereIn('id', $journalIds)
            ->where('status', 'active')
            ->pluck('name')
            ->toArray();

        return view('editor.dashboard', compact(
            'stats',
            'recent_submissions',
            'recent_reviews',
            'submissions_by_status',
            'monthly_submissions',
            'journalNames'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
