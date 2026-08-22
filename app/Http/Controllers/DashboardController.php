<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total' => $user->posts()->count(),

            'published' => $user->posts()
                ->published()
                ->count(),

            'drafts' => $user->posts()
                ->draft()
                ->count(),

            'archived' => $user->posts()
                ->archived()
                ->count(),
        ];

        $recentPosts = $user->posts()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentPosts'
        ));
    }
}