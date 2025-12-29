<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Author;
use App\Models\Article;
use App\Models\Submission;
use App\Models\Keyword;
use App\Models\Journal;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $journals = Journal::where('status', 'active')->get();
        $categories = Category::all();
        $keywords = Keyword::all();
        
        return view('auth.register', compact('journals', 'categories', 'keywords'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // User/Author fields
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'affiliation' => ['nullable', 'string', 'max:200'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'orcid_id' => ['nullable', 'string', 'max:50'],
            'author_contributions' => ['nullable', 'string'],
            
            // Article fields
            'title' => ['required', 'string', 'max:300'],
            'journal_id' => ['required', 'exists:journals,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'manuscript_type' => ['required', 'string', 'max:100'],
            'abstract' => ['required', 'string'],
            'word_count' => ['required', 'integer', 'min:0'],
            'number_of_tables' => ['nullable', 'integer', 'min:0'],
            'number_of_figures' => ['nullable', 'integer', 'min:0'],
            'previously_submitted' => ['required', 'in:Yes,No'],
            'funded_by_outside_source' => ['required', 'in:Yes,No'],
            'confirm_not_published_elsewhere' => ['required', 'in:Yes,No'],
            'confirm_prepared_as_per_guidelines' => ['required', 'in:Yes,No'],
            'manuscript_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['exists:keywords,id'],
            'new_keywords' => ['nullable', 'string']
        ]);

        DB::beginTransaction();
        try {
            // Create User account
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'author',
                'status' => 'active',
            ]);

            // Auto-create author record with all information
            $author = Author::create([
                'name' => $request->name,
                'email' => $request->email,
                'affiliation' => $request->affiliation,
                'specialization' => $request->specialization,
                'orcid_id' => $request->orcid_id,
                'author_contributions' => $request->author_contributions,
            ]);

            // Handle manuscript file upload
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

            // Create submission record
            Submission::create([
                'article_id' => $article->id,
                'author_id' => $author->id,
                'submission_date' => now(),
                'status' => 'submitted',
                'version_number' => 1,
                'file_path' => $manuscriptPath
            ]);

            // Create notification for the author
            Notification::create([
                'user_id' => $user->id,
                'type' => 'registration',
                'message' => 'Welcome to OJS! Your author account has been created successfully and your article "' . $article->title . '" has been submitted. Please go to the login page and login with your email (' . $user->email . ') and password to access your dashboard and view your submission status.',
                'status' => 'unread',
            ]);

            DB::commit();

            event(new Registered($user));

            // Don't auto-login, redirect to login page with success message
            return redirect()->route('login')
                ->with('success', 'Registration and article submission successful! Please login with your email and password to access your dashboard and view your submission status.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }
}
