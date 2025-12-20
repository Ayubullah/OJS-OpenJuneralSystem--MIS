<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Journal;
use App\Models\Keyword;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Author_ArticleSubmissionController extends Controller
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
     * Display a listing of the author's articles.
     */
    public function index()
    {
        $author = $this->getOrCreateAuthor();

        $articles = Article::where('author_id', $author->id)
            ->with(['journal', 'category', 'keywords'])
            ->latest()
            ->paginate(10);

        return view('author.articles.index', compact('articles', 'author'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $author = $this->getOrCreateAuthor();

        $journals = Journal::where('status', 'active')->get();
        $categories = Category::all();
        $keywords = Keyword::all();

        return view('author.articles.create', compact('journals', 'categories', 'keywords', 'author'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $author = $this->getOrCreateAuthor();

        $request->validate([
            'title' => 'required|string|max:300',
            'journal_id' => 'required|exists:journals,id',
            'category_id' => 'required|exists:categories,id',
            'manuscript_type' => 'required|string|max:100',
            'abstract' => 'required|string',
            'word_count' => 'required|integer|min:0',
            'number_of_tables' => 'nullable|integer|min:0',
            'number_of_figures' => 'nullable|integer|min:0',
            'previously_submitted' => 'required|in:Yes,No',
            'funded_by_outside_source' => 'required|in:Yes,No',
            'confirm_not_published_elsewhere' => 'required|in:Yes,No',
            'confirm_prepared_as_per_guidelines' => 'required|in:Yes,No',
            'manuscript_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
                'keywords' => 'nullable|array',
            'keywords.*' => 'exists:keywords,id',
            'new_keywords' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Handle file upload
            $manuscriptPath = null;
            if ($request->hasFile('manuscript_file')) {
                $file = $request->file('manuscript_file');
                $fileName = time() . '_' . $author->id . '_' . $file->getClientOriginalName();
                $manuscriptPath = $file->storeAs('manuscripts', $fileName, 'public');
            }

            // Create article
            $article = Article::create([
                'title' => $request->title,
                'journal_id' => $request->journal_id,
                'author_id' => $author->id,
                'category_id' => $request->category_id,
                'manuscript_type' => $request->manuscript_type,
                'abstract' => $request->abstract,
                'word_count' => $request->word_count,
                'number_of_tables' => $request->number_of_tables ?? 0,
                'number_of_figures' => $request->number_of_figures ?? 0,
                'previously_submitted' => $request->previously_submitted,
                'funded_by_outside_source' => $request->funded_by_outside_source,
                'confirm_not_published_elsewhere' => $request->confirm_not_published_elsewhere,
                'confirm_prepared_as_per_guidelines' => $request->confirm_prepared_as_per_guidelines,
                'manuscript_file' => $manuscriptPath,
                'status' => 'submitted'
            ]);

            // Attach existing keywords
            if ($request->keywords) {
                $article->keywords()->attach($request->keywords);
            }

            // Create and attach new keywords
            if ($request->new_keywords) {
                $newKeywords = array_map('trim', explode(',', $request->new_keywords));
                foreach ($newKeywords as $keywordText) {
                    if (!empty($keywordText)) {
                        $keyword = Keyword::firstOrCreate(['keyword' => $keywordText]);
                        $article->keywords()->attach($keyword->id);
                    }
                }
            }

            // Create submission record for editor/admin tracking
            Submission::create([
                'article_id' => $article->id,
                'author_id' => $author->id,
                'submission_date' => now(),
                'status' => 'submitted',
                'version_number' => 1,
                'file_path' => $manuscriptPath
            ]);

            DB::commit();

            return redirect()->route('author.articles.index')
                ->with('success', 'Article submitted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error submitting article: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        $author = $this->getOrCreateAuthor();
        
        // Check if article belongs to this author
        if ($article->author_id !== $author->id) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Unauthorized access.');
        }

        $article->load([
            'journal', 
            'category', 
            'keywords',
            'submissions.reviews.reviewer.user'
        ]);
        return view('author.articles.show', compact('article', 'author'));
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        $author = $this->getOrCreateAuthor();
        
        // Check if article belongs to this author
        if ($article->author_id !== $author->id) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Unauthorized access.');
        }

        // Only allow editing if status is submitted, under_review, or revision_required
        if (!in_array($article->status, ['submitted', 'under_review', 'revision_required'])) {
            return redirect()->route('author.articles.show', $article)
                ->with('error', 'Cannot edit article in current status.');
        }

        $journals = Journal::where('status', 'active')->get();
        $categories = Category::all();
        $keywords = Keyword::all();
        $article->load('keywords');

        return view('author.articles.edit', compact('article', 'journals', 'categories', 'keywords', 'author'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        $author = $this->getOrCreateAuthor();
        
        // Check if article belongs to this author
        if ($article->author_id !== $author->id) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Unauthorized access.');
        }

        // Only allow editing if status is submitted, under_review, or revision_required
        if (!in_array($article->status, ['submitted', 'under_review', 'revision_required'])) {
            return redirect()->route('author.articles.show', $article)
                ->with('error', 'Cannot edit article in current status.');
        }

        $request->validate([
            'title' => 'required|string|max:300',
            'journal_id' => 'required|exists:journals,id',
            'category_id' => 'required|exists:categories,id',
            'manuscript_type' => 'required|string|max:100',
            'abstract' => 'required|string',
            'word_count' => 'required|integer|min:0',
            'number_of_tables' => 'nullable|integer|min:0',
            'number_of_figures' => 'nullable|integer|min:0',
            'previously_submitted' => 'required|in:Yes,No',
            'funded_by_outside_source' => 'required|in:Yes,No',
            'confirm_not_published_elsewhere' => 'required|in:Yes,No',
            'confirm_prepared_as_per_guidelines' => 'required|in:Yes,No',
            'manuscript_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Optional on update
            'keywords' => 'nullable|array',
            'keywords.*' => 'exists:keywords,id',
            'new_keywords' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Handle file upload if new file provided
            $updateData = [
                'title' => $request->title,
                'journal_id' => $request->journal_id,
                'category_id' => $request->category_id,
                'manuscript_type' => $request->manuscript_type,
                'abstract' => $request->abstract,
                'word_count' => $request->word_count,
                'number_of_tables' => $request->number_of_tables ?? 0,
                'number_of_figures' => $request->number_of_figures ?? 0,
                'previously_submitted' => $request->previously_submitted,
                'funded_by_outside_source' => $request->funded_by_outside_source,
                'confirm_not_published_elsewhere' => $request->confirm_not_published_elsewhere,
                'confirm_prepared_as_per_guidelines' => $request->confirm_prepared_as_per_guidelines,
            ];

            if ($request->hasFile('manuscript_file')) {
                // Delete old file if exists
                if ($article->manuscript_file && Storage::disk('public')->exists($article->manuscript_file)) {
                    Storage::disk('public')->delete($article->manuscript_file);
                }
                
                // Upload new file
                $file = $request->file('manuscript_file');
                $fileName = time() . '_' . $author->id . '_' . $file->getClientOriginalName();
                $updateData['manuscript_file'] = $file->storeAs('manuscripts', $fileName, 'public');
            }

            $article->update($updateData);

            // Sync existing keywords
            $keywordIds = $request->keywords ?? [];

            // Create and attach new keywords
            if ($request->new_keywords) {
                $newKeywords = array_map('trim', explode(',', $request->new_keywords));
                foreach ($newKeywords as $keywordText) {
                    if (!empty($keywordText)) {
                        $keyword = Keyword::firstOrCreate(['keyword' => $keywordText]);
                        $keywordIds[] = $keyword->id;
                    }
                }
            }

            $article->keywords()->sync($keywordIds);

            DB::commit();

            return redirect()->route('author.articles.show', $article)
                ->with('success', 'Article updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error updating article: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show form to resubmit article with existing data
     */
    public function resubmit(Article $article)
    {
        $author = $this->getOrCreateAuthor();
        
        // Check if article belongs to this author
        if ($article->author_id !== $author->id) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Unauthorized access.');
        }

        // Only allow resubmission if status is submitted, under_review, or revision_required
        if (!in_array($article->status, ['submitted', 'under_review', 'revision_required'])) {
            return redirect()->route('author.articles.show', $article)
                ->with('error', 'Cannot resubmit article in current status. Only submitted, under review, or revision required articles can be resubmitted.');
        }

        // Get data needed for the form
        $journals = Journal::where('status', 'active')->get();
        $categories = Category::all();
        $keywords = Keyword::all();
        $article->load('keywords');

        return view('author.articles.resubmit', compact('article', 'journals', 'categories', 'keywords', 'author'));
    }

    /**
     * Store resubmitted article as new submission
     */
    public function storeResubmission(Request $request, Article $article)
    {
        $author = $this->getOrCreateAuthor();
        
        // Check if article belongs to this author
        if ($article->author_id !== $author->id) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Unauthorized access.');
        }

        // Only allow resubmission if status is submitted, under_review, or revision_required
        if (!in_array($article->status, ['submitted', 'under_review', 'revision_required'])) {
            return redirect()->route('author.articles.show', $article)
                ->with('error', 'Cannot resubmit article in current status. Only submitted, under review, or revision required articles can be resubmitted.');
        }

        $request->validate([
            'manuscript_file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Handle file upload
            $filePath = null;
            if ($request->hasFile('manuscript_file')) {
                $file = $request->file('manuscript_file');
                $fileName = time() . '_v' . '_' . $author->id . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('submissions', $fileName, 'public');
            }

            // Get the latest version number for this article
            $latestSubmission = Submission::where('article_id', $article->id)
                ->orderBy('version_number', 'desc')
                ->first();
            
            $newVersionNumber = $latestSubmission ? $latestSubmission->version_number + 1 : 1;

            // Create new submission record
            $submission = Submission::create([
                'article_id' => $article->id,
                'author_id' => $author->id,
                'submission_date' => now(),
                'status' => 'under_review',
                'version_number' => $newVersionNumber,
                'file_path' => $filePath
            ]);

            DB::commit();

            return redirect()->route('author.articles.show', $article)
                ->with('success', "Article resubmitted successfully as Version {$newVersionNumber}!");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Error resubmitting article: ' . $e->getMessage())
                ->withInput();
        }
    }
}

