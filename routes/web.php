<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')
    ->name('home');

Route::view('/about', 'pages.about')
    ->name('about');

Route::view('/contact', 'pages.contact')
    ->name('contact');

// Route::get('/', function () {
//     return redirect()->route('posts.index');
// });

Route::resource('posts', PostController::class);
