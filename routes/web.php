<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Tailwind CSS Test Route
Route::get('/tailwind-test', function () { return view('tailwind-test');})->name('tailwind.test');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Start Admin Role
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Route::get('/admin', function () {
        //     return "Hello Admin";
        // })->name('admin.dashboard');

        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    });
// End Admin Role

// Start Editor Role
    Route::middleware(['auth', 'role:editor'])->group(function () {
        Route::get('/editor', function () {
            return "Hello Editor";
        })->name('editor.dashboard');
    });
// End Editor Role

// Start Reviewer Role
    Route::middleware(['auth', 'role:reviewer'])->group(function () {
        Route::get('/reviewer', function () {
            return "Hello reviewer";
        })->name('reviewer.dashboard');
    });
// End Reviewer Role

// Start Author Role
    Route::middleware(['auth', 'role:author'])->group(function () {
        Route::get('/author', function () {
            return "Hello author";
        })->name('author.dashboard');
    });
// End Author Role

require __DIR__.'/auth.php';
