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
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Author\AuthorProfileController;
use App\Http\Controllers\Author\NotificationController;
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
use Illuminate\Support\Facades\Storage;

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
        Route::post('reviews/{review}/remind-reviewer', [\App\Http\Controllers\Admin\ReviewerController::class, 'sendReminderToReviewer'])->name('admin.reviews.remind-reviewer');
        Route::post('submissions/{submission}/remind-author', [\App\Http\Controllers\Admin\ReviewerController::class, 'sendReminderToAuthor'])->name('admin.submissions.remind-author');
        
        // Admin Reminders Management
        Route::get('reminders', [\App\Http\Controllers\Admin\AdminRemindersController::class, 'index'])->name('reminders.index');
        Route::post('reminders/send-message', [\App\Http\Controllers\Admin\AdminRemindersController::class, 'sendMessage'])->name('reminders.send-message');
        Route::put('reminders/messages/{message}/update', [\App\Http\Controllers\Admin\AdminRemindersController::class, 'updateMessage'])->name('reminders.messages.update');
        Route::delete('reminders/messages/{message}/delete', [\App\Http\Controllers\Admin\AdminRemindersController::class, 'deleteMessage'])->name('reminders.messages.delete');
        
        // Articles Management
        Route::resource('articles', ArticleController::class);
        Route::post('articles/{article}/send-reminder', [ArticleController::class, 'sendReminder'])->name('articles.send-reminder');
        
        // Users Management
        Route::resource('users', UserController::class);
        Route::get('editorial-assistants', [UserController::class, 'editorialAssistants'])->name('editorial-assistants.index');
        
        // Editors Management
        Route::resource('editors', \App\Http\Controllers\Admin\EditorController::class);
        
        // Submissions Management
        Route::get('submissions/status/published', [SubmissionController::class, 'published'])->name('submissions.published');
        Route::get('submissions/status/accepted', [SubmissionController::class, 'accepted'])->name('submissions.accepted');
        Route::get('submissions/status/submitted', [SubmissionController::class, 'submitted'])->name('submissions.submitted');
        Route::get('submissions/status/under-review', [SubmissionController::class, 'underReview'])->name('submissions.under-review');
        Route::get('submissions/status/revision-required', [SubmissionController::class, 'revisionRequired'])->name('submissions.revision-required');
        Route::get('submissions/status/disc-review', [SubmissionController::class, 'discReview'])->name('submissions.disc-review');
        Route::get('submissions/status/plagiarism', [SubmissionController::class, 'plagiarism'])->name('submissions.plagiarism');
        Route::get('submissions/status/rejected', [SubmissionController::class, 'rejected'])->name('submissions.rejected');
        // Assign reviewer routes (must be before resource routes)
        Route::get('submissions/{submission}/assign-reviewer', [SubmissionController::class, 'assignReviewer'])->name('submissions.assign-reviewer');
        Route::post('submissions/{submission}/assign-reviewer', [SubmissionController::class, 'storeReviewerAssignment'])->name('submissions.assign-reviewer.store');
        Route::resource('submissions', SubmissionController::class);

        // Previous Articles Management
        Route::get('previous-articles', [\App\Http\Controllers\Admin\PreviousArticlesController::class, 'index'])->name('previous-articles.index');
        Route::post('previous-articles', [\App\Http\Controllers\Admin\PreviousArticlesController::class, 'store'])->name('previous-articles.store');
        Route::get('previous-articles/editors/{editor}/reviewers', [\App\Http\Controllers\Admin\PreviousArticlesController::class, 'getReviewersByEditor'])->name('previous-articles.editors.reviewers');
        Route::get('previous-articles/editors/{editor}', [\App\Http\Controllers\Admin\PreviousArticlesController::class, 'getEditorDetails'])->name('previous-articles.editors.details');
        Route::get('previous-articles/journals/{journal}/editors', [\App\Http\Controllers\Admin\PreviousArticlesController::class, 'getEditorsByJournal'])->name('previous-articles.journals.editors');
        Route::get('previous-articles/journals/{journal}/reviewers', [\App\Http\Controllers\Admin\PreviousArticlesController::class, 'getReviewersByJournal'])->name('previous-articles.journals.reviewers');
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
         Route::get('submissions/status/disc-review', [Editor_SubmissionController::class, 'discReview'])->name('submissions.disc-review');
         Route::get('submissions/status/plagiarism', [Editor_SubmissionController::class, 'plagiarism'])->name('submissions.plagiarism');
         Route::get('submissions/status/pending-verify', [Editor_SubmissionController::class, 'pendingVerify'])->name('submissions.pending-verify');
         Route::get('submissions/status/verified', [Editor_SubmissionController::class, 'verified'])->name('submissions.verified');
         Route::get('submissions/status/rejected', [Editor_SubmissionController::class, 'rejected'])->name('submissions.rejected');
         // Assign reviewer routes (must be before resource routes)
         Route::get('submissions/{submission}/assign-reviewer', [Editor_SubmissionController::class, 'assignReviewer'])->name('submissions.assign-reviewer');
         Route::post('submissions/{submission}/assign-reviewer', [Editor_SubmissionController::class, 'storeReviewerAssignment'])->name('submissions.assign-reviewer.store');
         // Review management routes
         Route::get('reviews/pending-approvals', [Editor_SubmissionController::class, 'pendingApprovals'])->name('reviews.pending-approvals');
         Route::get('reviews/{review}/edit', [Editor_SubmissionController::class, 'editReview'])->name('reviews.edit');
         Route::put('reviews/{review}', [Editor_SubmissionController::class, 'updateReview'])->name('reviews.update');
         Route::post('reviews/{review}/approve', [Editor_SubmissionController::class, 'approveReview'])->name('reviews.approve');
         // Message/Reminder routes
         Route::get('reminders', [Editor_SubmissionController::class, 'remindersIndex'])->name('reminders.index');
         Route::post('submissions/{submission}/send-message', [Editor_SubmissionController::class, 'sendMessage'])->name('submissions.send-message');
         Route::put('messages/{message}/update', [Editor_SubmissionController::class, 'updateMessage'])->name('messages.update');
         Route::delete('messages/{message}/delete', [Editor_SubmissionController::class, 'deleteMessage'])->name('messages.delete');
         Route::post('submissions/{submission}/remind-author', [Editor_SubmissionController::class, 'sendReminderToAuthor'])->name('submissions.remind-author');
         Route::post('reviews/{review}/remind-reviewer', [Editor_SubmissionController::class, 'sendReminderToReviewer'])->name('reviews.remind-reviewer');
         // Approval workflow routes
         Route::post('submissions/{submission}/approve-article', [Editor_SubmissionController::class, 'approveArticle'])->name('submissions.approve-article');
         Route::post('submissions/{submission}/reject-approval', [Editor_SubmissionController::class, 'rejectApproval'])->name('submissions.reject-approval');
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
        // Dashboard
        Route::get('/', [AuthorController::class, 'index'])->name('dashboard');
        
        // Profile Settings
        Route::get('profile', [AuthorProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [AuthorProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/image', [AuthorProfileController::class, 'updateImage'])->name('profile.image.update');
        Route::delete('profile/image', [AuthorProfileController::class, 'removeImage'])->name('profile.image.remove');
        Route::put('profile/password', [AuthorProfileController::class, 'updatePassword'])->name('profile.password.update');
        
        // Resubmit routes (must be before resource routes)
        Route::get('/articles/{article}/resubmit', [Author_ArticleSubmissionController::class, 'resubmit'])->name('articles.resubmit');
        Route::post('/articles/{article}/resubmit', [Author_ArticleSubmissionController::class, 'storeResubmission'])->name('articles.storeResubmission');
        Route::post('/articles/{article}/reject', [Author_ArticleSubmissionController::class, 'reject'])->name('articles.reject');
        Route::post('/reviews/{review}/reply', [Author_ArticleSubmissionController::class, 'replyToReview'])->name('reviews.reply');
        // Approval workflow routes
        Route::post('/articles/{article}/upload-approval-file', [Author_ArticleSubmissionController::class, 'uploadApprovalFile'])->name('articles.upload-approval-file');
        
        // Notifications
        Route::get('/notifications/recent', [NotificationController::class, 'recent'])->name('notifications.recent');
        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        
        // Article Submissions - Full CRUD
        Route::resource('articles', Author_ArticleSubmissionController::class)->names('articles');
    });
// End Author Role

// Start Editorial Assistant Role
    Route::middleware(['auth', 'role:editorial_assistant'])->prefix('editorial-assistant')->name('editorial_assistant.')->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\EditorialAssistant\EditorialAssistantController::class, 'index'])->name('dashboard');
        
        // Profile Settings
        Route::get('profile', [\App\Http\Controllers\EditorialAssistant\EditorialAssistantProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [\App\Http\Controllers\EditorialAssistant\EditorialAssistantProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/image', [\App\Http\Controllers\EditorialAssistant\EditorialAssistantProfileController::class, 'updateImage'])->name('profile.image.update');
        Route::delete('profile/image', [\App\Http\Controllers\EditorialAssistant\EditorialAssistantProfileController::class, 'removeImage'])->name('profile.image.remove');
        Route::put('profile/password', [\App\Http\Controllers\EditorialAssistant\EditorialAssistantProfileController::class, 'updatePassword'])->name('profile.password.update');
        
        // Accepted Articles Management
        Route::resource('articles', \App\Http\Controllers\EditorialAssistant\EditorialAssistantArticleController::class);
    });
// End Editorial Assistant Role

// Download route for review format files
Route::get('/download/review-format/{file}', function ($file) {
    // Decode URL-encoded filename
    $file = urldecode($file);
    $filePath = 'review_formats/' . $file;
    
    if (Storage::disk('public')->exists($filePath)) {
        return Storage::disk('public')->download($filePath);
    }
    
    abort(404, 'File not found');
})->name('review.format.download')->middleware('auth');

require __DIR__.'/auth.php';
