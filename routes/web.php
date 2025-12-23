<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\EditorController;
use App\Http\Controllers\Admin\ReviewerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Author\Author_ArticleSubmissionController;
use App\Http\Controllers\Author\AuthorProfileController;
use App\Http\Controllers\Editor\EditorController as EditorEditorController;
use App\Http\Controllers\Editor\Editor_SubmissionController;
use App\Http\Controllers\Editor\EditorProfileController;
use App\Http\Controllers\Reviewer\ReviewerController as ReviewerReviewerController;
use App\Http\Controllers\Reviewer\ReviewerProfileController;
use App\Http\Controllers\Reviewer\Reviewer_ReviewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/review-articles/index',[ReviewerController::class,'reviewerArticles'])->name('review-articles.submit');
// Tailwind CSS Test Route
Route::get('/tailwind-test', function () { return view('tailwind-test');})->name('tailwind.test');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Locale switcher for UI translations
Route::post('/locale', function (Request $request) {
    $validated = $request->validate([
        'locale' => ['required', 'in:en,fa,ps'],
    ]);

    session(['locale' => $validated['locale']]);

    return back();
})->name('locale.switch');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Start Admin Role
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Profile Settings
        Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/image', [AdminProfileController::class, 'updateImage'])->name('profile.image.update');
        Route::delete('profile/image', [AdminProfileController::class, 'removeImage'])->name('profile.image.remove');
        Route::put('profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
        
        // Categories Management
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        
        // Journals Management
        Route::resource('journals', JournalController::class);
        
        // Authors Management
        Route::resource('authors', \App\Http\Controllers\Admin\AuthorController::class);
        
        // Reviewers Management
        Route::resource('reviewers', \App\Http\Controllers\Admin\ReviewerController::class);
        Route::get('reviewers/articles', [\App\Http\Controllers\Admin\ReviewerController::class, 'articles'])->name('reviewers.articles');
        Route::get('reviewers/{reviewer}/articles', [\App\Http\Controllers\Admin\ReviewerController::class, 'reviewerArticles'])->name('reviewers.articles.show');
        
        // Articles Management
        Route::resource('articles', ArticleController::class);
        
        // Users Management
        Route::resource('users', UserController::class);
        
        // Editors Management
        Route::resource('editors', \App\Http\Controllers\Admin\EditorController::class);
        
        // Submissions Management
        Route::get('submissions/status/published', [SubmissionController::class, 'published'])->name('submissions.published');
        Route::get('submissions/status/accepted', [SubmissionController::class, 'accepted'])->name('submissions.accepted');
        Route::get('submissions/status/submitted', [SubmissionController::class, 'submitted'])->name('submissions.submitted');
        Route::get('submissions/status/under-review', [SubmissionController::class, 'underReview'])->name('submissions.under-review');
        Route::get('submissions/status/revision-required', [SubmissionController::class, 'revisionRequired'])->name('submissions.revision-required');
        Route::get('submissions/status/rejected', [SubmissionController::class, 'rejected'])->name('submissions.rejected');
        // Assign reviewer routes (must be before resource routes)
        Route::get('submissions/{submission}/assign-reviewer', [SubmissionController::class, 'assignReviewer'])->name('submissions.assign-reviewer');
        Route::post('submissions/{submission}/assign-reviewer', [SubmissionController::class, 'storeReviewerAssignment'])->name('submissions.assign-reviewer.store');
        Route::resource('submissions', SubmissionController::class);
    });
// End Admin Role

// Start Editor Role
    Route::middleware(['auth', 'role:editor'])->prefix('editor')->name('editor.')->group(function () {
        // Dashboard
        Route::get('/', [EditorEditorController::class, 'index'])->name('dashboard');
        
        // Profile Settings
        Route::get('profile', [EditorProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [EditorProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/image', [EditorProfileController::class, 'updateImage'])->name('profile.image.update');
        Route::delete('profile/image', [EditorProfileController::class, 'removeImage'])->name('profile.image.remove');
        Route::put('profile/password', [EditorProfileController::class, 'updatePassword'])->name('profile.password.update');
        
         // Submissions Management
         Route::get('submissions/status/published', [Editor_SubmissionController::class, 'published'])->name('submissions.published');
         Route::get('submissions/status/accepted', [Editor_SubmissionController::class, 'accepted'])->name('submissions.accepted');
         Route::get('submissions/status/submitted', [Editor_SubmissionController::class, 'submitted'])->name('submissions.submitted');
         Route::get('submissions/status/under-review', [Editor_SubmissionController::class, 'underReview'])->name('submissions.under-review');
         Route::get('submissions/status/revision-required', [Editor_SubmissionController::class, 'revisionRequired'])->name('submissions.revision-required');
         Route::get('submissions/status/rejected', [Editor_SubmissionController::class, 'rejected'])->name('submissions.rejected');
         // Assign reviewer routes (must be before resource routes)
         Route::get('submissions/{submission}/assign-reviewer', [Editor_SubmissionController::class, 'assignReviewer'])->name('submissions.assign-reviewer');
         Route::post('submissions/{submission}/assign-reviewer', [Editor_SubmissionController::class, 'storeReviewerAssignment'])->name('submissions.assign-reviewer.store');
        Route::resource('submissions', Editor_SubmissionController::class);
    });
// End Editor Role

// Start Reviewer Role
    Route::middleware(['auth', 'role:reviewer'])->prefix('reviewer')->name('reviewer.')->group(function () {
        // Dashboard
        Route::get('/', [ReviewerReviewerController::class, 'index'])->name('dashboard');
        
        // Profile Settings
        Route::get('profile', [ReviewerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ReviewerProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/image', [ReviewerProfileController::class, 'updateImage'])->name('profile.image.update');
        Route::delete('profile/image', [ReviewerProfileController::class, 'removeImage'])->name('profile.image.remove');
        Route::put('profile/password', [ReviewerProfileController::class, 'updatePassword'])->name('profile.password.update');
        
        // Reviews Management
        Route::get('reviews/status/pending', [Reviewer_ReviewController::class, 'pending'])->name('reviews.pending');
        Route::get('reviews/status/in-progress', [Reviewer_ReviewController::class, 'inProgress'])->name('reviews.in-progress');
        Route::get('reviews/status/completed', [Reviewer_ReviewController::class, 'completed'])->name('reviews.completed');
        Route::resource('reviews', Reviewer_ReviewController::class);
    });
// End Reviewer Role

// Start Author Role
    Route::middleware(['auth', 'role:author'])->prefix('author')->name('author.')->group(function () {
       
        // Redirect dashboard to articles index
        Route::get('/', function () {
            return redirect()->route('author.articles.index');
        })->name('dashboard');
        
        // Profile Settings
        Route::get('profile', [AuthorProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [AuthorProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/image', [AuthorProfileController::class, 'updateImage'])->name('profile.image.update');
        Route::delete('profile/image', [AuthorProfileController::class, 'removeImage'])->name('profile.image.remove');
        Route::put('profile/password', [AuthorProfileController::class, 'updatePassword'])->name('profile.password.update');
        
        // Resubmit routes (must be before resource routes)
        Route::get('/articles/{article}/resubmit', [Author_ArticleSubmissionController::class, 'resubmit'])->name('articles.resubmit');
        Route::post('/articles/{article}/resubmit', [Author_ArticleSubmissionController::class, 'storeResubmission'])->name('articles.storeResubmission');
        
        // Article Submissions - Full CRUD
        Route::resource('articles', Author_ArticleSubmissionController::class)->names('articles');
    });
// End Author Role

require __DIR__.'/auth.php';
