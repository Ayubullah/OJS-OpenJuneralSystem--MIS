<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Article;
use App\Models\Author;
use App\Models\Reviewer;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->latest()
            ->paginate(10);
        return view('admin.submissions.index', compact('submissions'));
    }

    /**
     * Display published submissions.
     */
    public function published()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->where('status', 'published')
            ->latest()
            ->paginate(10);
        $statusFilter = 'published';
        return view('admin.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display accepted submissions.
     */
    public function accepted()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->where('status', 'accepted')
            ->latest()
            ->paginate(10);
        $statusFilter = 'accepted';
        return view('admin.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display submitted submissions.
     */
    public function submitted()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->where('status', 'submitted')
            ->latest()
            ->paginate(10);
        $statusFilter = 'submitted';
        return view('admin.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display under review submissions.
     */
    public function underReview()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->where('status', 'under_review')
            ->latest()
            ->paginate(10);
        $statusFilter = 'under_review';
        return view('admin.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display revision required submissions.
     */
    public function revisionRequired()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->where('status', 'revision_required')
            ->latest()
            ->paginate(10);
        $statusFilter = 'revision_required';
        return view('admin.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Display rejected submissions.
     */
    public function rejected()
    {
        $submissions = Submission::with(['article.journal', 'author', 'reviews.reviewer'])
            ->where('status', 'rejected')
            ->latest()
            ->paginate(10);
        $statusFilter = 'rejected';
        return view('admin.submissions.index', compact('submissions', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::with('journal')->get();
        $authors = Author::all();
        
        return view('admin.submissions.create', compact('articles', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:submitted,under_review,revision_required,accepted,published,rejected',
            'version_number' => 'required|integer|min:1'
        ]);

        Submission::create($request->all());

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        $submission->load(['article.journal', 'author', 'reviews.reviewer']);
        return view('admin.submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        $articles = Article::with('journal')->get();
        $authors = Author::all();
        
        return view('admin.submissions.edit', compact('submission', 'articles', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:submitted,under_review,revision_required,accepted,published,rejected',
            'version_number' => 'required|integer|min:1'
        ]);

        $submission->update($request->all());

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        $submission->delete();

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Submission deleted successfully.');
    }

    /**
     * Show the form for assigning a reviewer to a submission.
     */
    public function assignReviewer(Submission $submission)
    {
        $submission->load(['article.journal', 'author', 'reviews.reviewer.user']);
        $reviewers = Reviewer::with('user')->where('status', 'active')->get();
        
        // Get all submissions for this article with their reviews, grouped by version
        $allSubmissions = Submission::where('article_id', $submission->article_id)
            ->with(['reviews.reviewer.user'])
            ->orderBy('version_number', 'desc')
            ->get();
        
        return view('admin.submissions.assign-reviewer', compact('submission', 'reviewers', 'allSubmissions'));
    }

    /**
     * Store the reviewer assignment for a submission.
     */
    public function storeReviewerAssignment(Request $request, Submission $submission)
    {
        $request->validate([
            'reviewer_ids' => 'required|array|min:1',
            'reviewer_ids.*' => 'exists:reviewers,id',
            'deadline' => 'nullable|date|after:today'
        ]);

        DB::beginTransaction();
        try {
            $assignedCount = 0;

            // Process each selected reviewer
            foreach ($request->reviewer_ids as $reviewerId) {
                // Create review assignment (allow multiple assignments for same reviewer)
                Review::create([
                    'submission_id' => $submission->id,
                    'reviewer_id' => $reviewerId,
                    'review_date' => $request->deadline ?? null,
                ]);
                $assignedCount++;
            }

            // Update submission status to 'under_review' if it's currently 'submitted' and at least one reviewer was assigned
            if ($assignedCount > 0 && $submission->status === 'submitted') {
                $submission->update(['status' => 'under_review']);
            }

            DB::commit();

            // Build success message
            $message = $assignedCount . ' reviewer(s) assigned successfully!';
            if ($assignedCount > 0 && $submission->status === 'under_review') {
                $message .= ' The submission status has been updated to "Under Review".';
            }

            return redirect()->route('admin.submissions.show', $submission)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error assigning reviewers: ' . $e->getMessage())
                ->withInput();
        }
    }
}
