<?php

use App\Http\Controllers\AI\AITagController;
use App\Http\Controllers\AI\WritingAssistantController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicAuthorController;
use App\Http\Controllers\PublicCategoryController;
use App\Http\Controllers\PublicTagController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Public Routes
 * |--------------------------------------------------------------------------
 */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Public Posts List
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
     * |--------------------------------------------------------------------------
     * | Dashboard Posts
     * |--------------------------------------------------------------------------
     */
    Route::get('/dashboard/posts', [DashboardPostController::class, 'index'])->name('dashboard.posts');
    Route::get('/dashboard/posts/{post}', [DashboardPostController::class, 'show'])->name('dashboard.posts.show');

    /*
     * |--------------------------------------------------------------------------
     * | Post Management (Create, Edit, Delete)
     * |--------------------------------------------------------------------------
     */
    Route::resource('posts', PostController::class)->only([
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
     * |--------------------------------------------------------------------------
     * | Dashboard Categories & Tags
     * |--------------------------------------------------------------------------
     */
    Route::resource('dashboard/categories', CategoryController::class)->names('dashboard.categories');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::resource('tags', TagController::class);
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [
        CommentController::class,
        'store',
    ])->name('comments.store');

    Route::put('/comments/{comment}', [
        CommentController::class,
        'update',
    ])->name('comments.update');

    Route::delete('/comments/{comment}', [
        CommentController::class,
        'destroy',
    ])->name('comments.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/reaction', [ReactionController::class, 'toggle'])
        ->name('reactions.toggle');
});

Route::get('/posts/{post}/reactions/users', [ReactionController::class, 'users'])
    ->name('reactions.users');

Route::middleware('auth')->group(function () {
    Route::post('/notifications/{notification}/read', [
        NotificationController::class,
        'markAsRead',
    ])->name('notifications.read');

    Route::post('/notifications/read-all', [
        NotificationController::class,
        'markAllAsRead',
    ])->name('notifications.read-all');
});
Route::get('/notifications', [
    NotificationController::class,
    'index',
])->name('notifications.index');

Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/bookmark', [BookmarkController::class, 'toggle'])
        ->name('bookmarks.toggle');
    Route::get('/saved', [BookmarkController::class, 'index'])
        ->name('bookmarks.index');
});

Route::middleware('auth')->group(function () {
    Route::post('/ai/writing/improve', [WritingAssistantController::class, 'improve'])
        ->name('ai.writing.improve');
    Route::post('/ai/writing/title', [WritingAssistantController::class, 'title'])
        ->name('ai.writing.title');
    Route::post('/ai/writing/excerpt', [WritingAssistantController::class, 'excerpt'])
        ->name('ai.writing.excerpt');
    Route::post('/ai/writing/tags', [WritingAssistantController::class, 'tags'])
        ->name('ai.writing.tags');
        Route::post('/ai/writing/tags/add', [AITagController::class, 'store'])
    ->name('ai.writing.tags.add');
});

/*
 * |--------------------------------------------------------------------------
 * | Wildcard Routes (يجب أن تكون في الأسفل لتجنب التضارب)
 * |--------------------------------------------------------------------------
 */
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories/{category:slug}', [PublicCategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{tag:slug}', [PublicTagController::class, 'show'])->name('tags.show');
Route::get('/authors/{user}', [PublicAuthorController::class, 'show'])->name('authors.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

require __DIR__ . '/auth.php';
