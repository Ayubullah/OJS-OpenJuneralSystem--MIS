<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Editor;
use App\Models\Reviewer;
use App\Models\Review;
use App\Models\Article;
use App\Models\Submission;
use App\Models\Journal;
use App\Models\User;
use App\Models\Category;
use App\Models\Keyword;
use App\Models\ArticleKeyword;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PreviousArticlesController extends Controller
{
    /**
     * Display the comprehensive author-editor-reviewer management page
     */
    public function index()
    {
        $editors = Editor::with(['user', 'journal'])->get();
        $journals = Journal::all();
        $reviewers = Reviewer::with(['user', 'journal'])->get();
        $categories = Category::all();
        $keywords = Keyword::all();
        $authors = Author::orderBy('name')->get();

        return view('admin.previous-articles.index', compact('editors', 'journals', 'reviewers', 'categories', 'keywords', 'authors'));
    }

    /**
     * Get reviewers for a specific editor's journal via AJAX
     */
    public function getReviewersByEditor(Editor $editor): JsonResponse
    {
        $editor->load('journal');

        if (!$editor->journal) {
            return response()->json(['reviewers' => []]);
        }

        $reviewers = Reviewer::with(['user', 'journal'])
            ->where('journal_id', $editor->journal->id)
            ->where('status', 'active')
            ->get();

        return response()->json([
            'reviewers' => $reviewers->map(function ($reviewer) {
                return [
                    'id' => $reviewer->id,
                    'name' => $reviewer->user->name,
                    'email' => $reviewer->email,
                    'expertise' => $reviewer->expertise,
                    'specialization' => $reviewer->specialization,
                    'status' => $reviewer->status
                ];
            })
        ]);
    }

    /**
     * Store comprehensive author registration and article submission
     */
    public function store(Request $request)
    {
        // Check if using existing author
        $useExistingAuthor = $request->has('use_existing_author') && $request->use_existing_author == '1';
        $existingAuthorId = $request->existing_author_id;

        $rules = [
            // Personal Information
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email',
            'existing_author_id' => 'nullable|exists:authors,id',
            'use_existing_author' => 'nullable|boolean',
        ];

        if (!$useExistingAuthor || !$existingAuthorId) {
            // Require username and password only for new authors
            $rules['username'] = 'required|string|max:255|unique:users,username';
            $rules['author_email'] = 'required|email|unique:users,email|unique:authors,email';
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            // Username and password are optional for existing authors
            $rules['username'] = 'nullable|string|max:255';
            // Password is only validated if provided and not empty
            $passwordValue = $request->input('password');
            if (!empty($passwordValue) && trim($passwordValue) !== '') {
                $rules['password'] = 'required|string|min:8|confirmed';
                $rules['password_confirmation'] = 'required|string';
            } else {
                $rules['password'] = 'nullable';
                $rules['password_confirmation'] = 'nullable';
            }
            
            // Get the existing author to check their current email and associated user
            $existingAuthor = Author::find($existingAuthorId);
            if ($existingAuthor) {
                $existingUser = User::where('email', $existingAuthor->email)->first();
                
                // Allow the existing author's email (exclude current author and associated user from unique check)
                $authorEmailRule = 'required|email|unique:authors,email,' . $existingAuthorId;
                if ($existingUser) {
                    // Exclude both the current author and the associated user
                    $rules['author_email'] = $authorEmailRule . '|unique:users,email,' . $existingUser->id;
                } else {
                    // Only exclude the current author, but check users table for uniqueness
                    $rules['author_email'] = $authorEmailRule . '|unique:users,email';
                }
            } else {
                // Fallback: if author not found, use standard validation
                $rules['author_email'] = 'required|email|unique:users,email|unique:authors,email';
            }
        }

        $rules = array_merge($rules, [
            'affiliation' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'orcid_id' => 'nullable|string|max:255',
            'author_contributions' => 'nullable|string',

            // Basic Information
            'title' => 'required|string|max:500',
            'journal_id' => 'required|exists:journals,id',
            'category_id' => 'required|exists:categories,id',
            'manuscript_type' => 'required|string|in:Research Article,Review Article,Case Study,Short Communication,Letter to Editor',

            // Abstract and Content Details
            'abstract' => 'required|string|max:5000',
            'word_count' => 'required|integer|min:100|max:50000',
            'number_of_tables' => 'nullable|integer|min:0',
            'number_of_figures' => 'nullable|integer|min:0',

            // Manuscript File
            'manuscript_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max

            // Keywords
            'existing_keywords' => 'nullable|array',
            'existing_keywords.*' => 'exists:keywords,id',
            'new_keywords' => 'nullable|string',

            // Submission Details
            'previously_submitted' => 'required|boolean',
            'funded_by_outside_source' => 'required|boolean',
            'confirm_not_published_elsewhere' => 'required|accepted',
            'confirm_prepared_as_per_guidelines' => 'required|accepted',

            // Article Status
            'article_status' => 'required|in:submitted,under_review,revision_required,disc_review,pending,pending_verify,verified,plagiarism,accepted,published,rejected',
            'status_comment' => 'nullable|string|max:1000',

            // Editor and Reviewers (optional for basic submission)
            'editor_id' => 'nullable|exists:editors,id',
            'reviewers' => 'nullable|array',
            'reviewers.*.id' => 'nullable|exists:reviewers,id',
            'reviewers.*.comments' => 'nullable|string',
            'reviewers.*.rating' => 'nullable|integer|min:1|max:10',
        ]);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Check if using existing author
            $useExistingAuthor = $request->has('use_existing_author') && $request->use_existing_author == '1';
            $existingAuthorId = $request->existing_author_id;

            if ($useExistingAuthor && $existingAuthorId) {
                // Use existing author - do not create new user
                $author = Author::findOrFail($existingAuthorId);
                
                // Update author information if provided
                $author->update([
                    'name' => $request->author_name ?? $author->name,
                    'email' => $request->author_email ?? $author->email,
                    'affiliation' => $request->affiliation ?? $author->affiliation,
                    'specialization' => $request->specialization ?? $author->specialization,
                    'orcid_id' => $request->orcid_id ?? $author->orcid_id,
                    'author_contributions' => $request->author_contributions ?? $author->author_contributions,
                ]);
                
                // Only find existing user account - do NOT create new user
                $user = User::where('email', $author->email)->first();
                if ($user) {
                    // Update existing user if password is provided
                    if ($request->filled('password') && !empty(trim($request->password))) {
                        $user->update([
                            'password' => Hash::make($request->password)
                        ]);
                    }
                    // Update username if provided
                    if ($request->filled('username') && !empty(trim($request->username))) {
                        $user->update([
                            'username' => $request->username
                        ]);
                    }
                }
                // If no user exists, that's fine - we'll use null for $user
            } else {
                // Create new user account
                $user = User::create([
                    'name' => $request->author_name,
                    'username' => $request->username,
                    'email' => $request->author_email,
                    'password' => Hash::make($request->password),
                    'role' => 'author',
                    'status' => 'active'
                ]);

                // Create new author
                $author = Author::create([
                    'name' => $request->author_name,
                    'email' => $request->author_email,
                    'affiliation' => $request->affiliation,
                    'specialization' => $request->specialization,
                    'orcid_id' => $request->orcid_id,
                    'author_contributions' => $request->author_contributions,
                ]);
            }

            // 3. Handle File Upload
            $manuscriptPath = null;
            if ($request->hasFile('manuscript_file')) {
                $file = $request->file('manuscript_file');
                $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
                $manuscriptPath = $file->storeAs('manuscripts', $filename, 'public');
            }

            // 4. Create Article
            // Convert form values to 'Yes'/'No' strings for ENUM columns
            // Radio buttons send "1" for Yes, "0" for No
            $previouslySubmitted = ($request->previously_submitted == '1' || $request->previously_submitted === 1) ? 'Yes' : 'No';
            $fundedByOutsideSource = ($request->funded_by_outside_source == '1' || $request->funded_by_outside_source === 1) ? 'Yes' : 'No';
            
            // Checkboxes send "1" when checked, null/empty when unchecked
            $confirmNotPublished = ($request->has('confirm_not_published_elsewhere') && ($request->confirm_not_published_elsewhere == '1' || $request->confirm_not_published_elsewhere === 1)) ? 'Yes' : 'No';
            $confirmGuidelines = ($request->has('confirm_prepared_as_per_guidelines') && ($request->confirm_prepared_as_per_guidelines == '1' || $request->confirm_prepared_as_per_guidelines === 1)) ? 'Yes' : 'No';
            
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
                'previously_submitted' => $previouslySubmitted,
                'funded_by_outside_source' => $fundedByOutsideSource,
                'confirm_not_published_elsewhere' => $confirmNotPublished,
                'confirm_prepared_as_per_guidelines' => $confirmGuidelines,
                'status' => $request->article_status ?? 'submitted',
                'manuscript_file' => $manuscriptPath,
            ]);

            // 5. Handle Keywords
            $this->handleKeywords($article, $request);

            // 6. Create Submission
            $submissionStatus = $request->article_status ?? 'submitted';
            $submission = Submission::create([
                'article_id' => $article->id,
                'author_id' => $author->id,
                'status' => $submissionStatus,
                'version_number' => 1,
                'file_path' => $manuscriptPath,
            ]);

            // Store status comment if provided
            if ($request->filled('status_comment')) {
                // You can store this in a comments table or as a note
                // For now, we'll add it to the submission as a note/comment field if available
                // If you have a comments/notes table, create a record here
            }

            // Notify editorial assistants when article is created with accepted status
            if ($submissionStatus === 'accepted') {
                $editorialAssistants = \App\Models\User::where('role', 'editorial_assistant')->get();
                if ($editorialAssistants->count() > 0) {
                    $articleTitle = $article->title ?? 'An article';
                    foreach ($editorialAssistants as $assistant) {
                        \App\Models\Notification::create([
                            'user_id' => $assistant->id,
                            'type' => 'article',
                            'message' => "A new article has been accepted: \"{$articleTitle}\". You can view it in your dashboard.",
                            'status' => 'unread',
                        ]);
                    }
                }
            }

            // 7. Handle Editor Assignment and Reviews (if provided)
            // Note: Status remains 'accepted' even when reviewers are assigned
            if ($request->filled('editor_id') && $request->has('reviewers') && !empty($request->reviewers)) {
                // Keep status as 'accepted' - do not change to 'under_review'
                // $submission->update(['status' => 'accepted']); // Already set to accepted above

                // Create reviews for selected reviewers
                foreach ($request->reviewers as $reviewerData) {
                    if (!empty($reviewerData['id'])) {
                        Review::create([
                            'submission_id' => $submission->id,
                            'reviewer_id' => $reviewerData['id'],
                            'rating' => $reviewerData['rating'] ?? null,
                            'comments' => $reviewerData['comments'] ?? '',
                            'review_date' => now(),
                            'editor_approved' => false,
                        ]);
                    }
                }
            }

            DB::commit();

            // Determine success message based on whether using existing author
            $message = ($useExistingAuthor && $existingAuthorId) 
                ? 'Article submitted successfully using existing author!'
                : 'Author account created and article submitted successfully!';

            // Return JSON response with redirect URL for AJAX handling
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('admin.previous-articles.index'),
                'data' => [
                    'user' => $user, // May be null if using existing author without user account
                    'author' => $author,
                    'article' => $article,
                    'submission' => $submission,
                    'reviewers_count' => $request->has('reviewers') ? count(array_filter($request->reviewers, fn($r) => !empty($r['id']))) : 0
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded file if transaction fails
            if (isset($manuscriptPath) && Storage::disk('public')->exists($manuscriptPath)) {
                Storage::disk('public')->delete($manuscriptPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle keywords for the article
     */
    private function handleKeywords(Article $article, Request $request)
    {
        // Attach existing keywords
        if ($request->has('existing_keywords') && is_array($request->existing_keywords)) {
            foreach ($request->existing_keywords as $keywordId) {
                ArticleKeyword::create([
                    'article_id' => $article->id,
                    'keyword_id' => $keywordId,
                ]);
            }
        }

        // Create and attach new keywords
        if ($request->filled('new_keywords')) {
            $newKeywords = array_map('trim', explode(',', $request->new_keywords));

            foreach ($newKeywords as $keywordText) {
                if (!empty($keywordText)) {
                    // Check if keyword already exists
                    $keyword = Keyword::firstOrCreate(
                        ['keyword' => $keywordText],
                        ['description' => null]
                    );

                    // Attach to article if not already attached
                    if (!$article->keywords()->where('keyword_id', $keyword->id)->exists()) {
                        ArticleKeyword::create([
                            'article_id' => $article->id,
                            'keyword_id' => $keyword->id,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Get editor details
     */
    public function getEditorDetails(Editor $editor): JsonResponse
    {
        $editor->load(['user', 'journal']);

        return response()->json([
            'editor' => [
                'id' => $editor->id,
                'name' => $editor->user->name,
                'email' => $editor->user->email,
                'journal' => $editor->journal->name ?? 'No Journal',
                'status' => $editor->status
            ]
        ]);
    }

    /**
     * Get editors for a specific journal via AJAX
     * Matches SQL: SELECT j.id, j.name, eu.username FROM journals j 
     * INNER JOIN editors ed ON ed.journal_id = j.id
     * INNER JOIN users eu ON ed.user_id = eu.id
     */
    public function getEditorsByJournal(Journal $journal): JsonResponse
    {
        try {
            $editors = Editor::with(['user', 'journal'])
                ->where('journal_id', $journal->id)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'success' => true,
                'editors' => $editors->map(function ($editor) {
                    return [
                        'id' => $editor->id,
                        'name' => $editor->user ? ($editor->user->name ?? $editor->user->username ?? 'N/A') : 'N/A',
                        'username' => $editor->user ? ($editor->user->username ?? '') : '',
                        'email' => $editor->user ? ($editor->user->email ?? '') : '',
                        'journal_id' => $editor->journal_id,
                        'journal_name' => $editor->journal ? ($editor->journal->name ?? 'No Journal') : 'No Journal',
                        'status' => $editor->status
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'editors' => []
            ], 500);
        }
    }

    /**
     * Get reviewers for a specific journal via AJAX
     * Matches SQL: SELECT j.id, j.name, ru.username FROM journals j 
     * INNER JOIN reviewers re ON re.journal_id = j.id
     * INNER JOIN users ru ON re.user_id = ru.id
     */
    public function getReviewersByJournal(Journal $journal): JsonResponse
    {
        try {
            $reviewers = Reviewer::with(['user', 'journal'])
                ->where('journal_id', $journal->id)
                ->where('status', 'active')
                ->get();

            return response()->json([
                'success' => true,
                'reviewers' => $reviewers->map(function ($reviewer) {
                    return [
                        'id' => $reviewer->id,
                        'name' => $reviewer->user ? ($reviewer->user->name ?? $reviewer->user->username ?? 'N/A') : 'N/A',
                        'username' => $reviewer->user ? ($reviewer->user->username ?? '') : '',
                        'email' => $reviewer->email ?? ($reviewer->user ? $reviewer->user->email : '') ?? '',
                        'expertise' => $reviewer->expertise,
                        'specialization' => $reviewer->specialization,
                        'status' => $reviewer->status
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'reviewers' => []
            ], 500);
        }
    }
}
