<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')
    ->name('home');

Route::view('/about', 'pages.about')
    ->name('about');

Route::view('/contact', 'pages.contact')
    ->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    // Posts routes...
});
Route::get('/dashboard/posts', [
    DashboardPostController::class,
    'index'
])->name('dashboard.posts');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/posts', [
    PostController::class,
    'index'
])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)
        ->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);
});

Route::get('/posts/{post}', [
    PostController::class,
    'show'
])->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::resource(
        'dashboard/categories',
        CategoryController::class
    )->names('dashboard.categories');
});

require __DIR__ . '/auth.php';
