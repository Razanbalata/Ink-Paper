<?php

use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicAuthorController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\PublicTagController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Public Posts List
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Posts
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/posts', [DashboardPostController::class, 'index'])->name('dashboard.posts');
    Route::get('/dashboard/posts/{post}', [DashboardPostController::class, 'show'])->name('dashboard.posts.show');

    /*
    |--------------------------------------------------------------------------
    | Post Management (Create, Edit, Delete)
    |--------------------------------------------------------------------------
    */
    Route::resource('posts', PostController::class)->only([
        'create',
        'store',
        'edit',
        'update',
        'destroy',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Dashboard Categories & Tags
    |--------------------------------------------------------------------------
    */
    Route::resource('dashboard/categories', CategoryController::class)->names('dashboard.categories');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::resource('tags', TagController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Wildcard Routes (يجب أن تكون في الأسفل لتجنب التضارب)
|--------------------------------------------------------------------------
*/
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories/{category:slug}', [PublicCategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{tag:slug}', [PublicTagController::class, 'show'])->name('tags.show');
Route::get('/authors/{user}', [PublicAuthorController::class, 'show'])->name('authors.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

require __DIR__ . '/auth.php';