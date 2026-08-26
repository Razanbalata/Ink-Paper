<?php

use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\PublicTagController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Public Routes
 * |--------------------------------------------------------------------------
 */

Route::get('/', [
    HomeController::class,
    'index'
])->name('home');

Route::view('/about', 'pages.about')
    ->name('about');

Route::view('/contact', 'pages.contact')
    ->name('contact');

// Public Article
Route::get('/posts/{post:slug}', [
    PostController::class,
    'show'
])->name('posts.show');

/*
 * |--------------------------------------------------------------------------
 * | Authenticated Routes
 * |--------------------------------------------------------------------------
 */

Route::middleware('auth')->group(function () {
    /*
     * |--------------------------------------------------------------------------
     * | Dashboard
     * |--------------------------------------------------------------------------
     */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    /*
     * |--------------------------------------------------------------------------
     * | Dashboard Posts
     * |--------------------------------------------------------------------------
     */

    Route::get('/dashboard/posts', [
        DashboardPostController::class,
        'index'
    ])->name('dashboard.posts');

    Route::get('/dashboard/posts/{post}', [
        DashboardPostController::class,
        'show'
    ])->name('dashboard.posts.show');

    /*
     * |--------------------------------------------------------------------------
     * | Post Management
     * |--------------------------------------------------------------------------
     */

    Route::resource('posts', PostController::class)
        ->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);

    /*
     * |--------------------------------------------------------------------------
     * | Profile
     * |--------------------------------------------------------------------------
     */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

    /*
     * |--------------------------------------------------------------------------
     * | Dashboard Categories
     * |--------------------------------------------------------------------------
     */

    Route::resource(
        'dashboard/categories',
        CategoryController::class
    )->names('dashboard.categories');

    /*
     * |--------------------------------------------------------------------------
     * | Dashboard Tags
     * |--------------------------------------------------------------------------
     */

    Route::prefix('dashboard')
        ->name('dashboard.')
        ->group(function () {
            Route::resource('tags', TagController::class);
        });
});

Route::get('/categories/{category:slug}', [
    PublicCategoryController::class,
    'show'
])->name('categories.show');

Route::get('/tags/{tag:slug}', [
    PublicTagController::class,
    'show'
])->name('tags.show');

require __DIR__ . '/auth.php';
