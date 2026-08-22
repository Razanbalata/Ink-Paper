<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPostController extends Controller
{
    public function index(Request $request)
    {
        $query = $request
            ->user()
            ->posts()
            ->latest();

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->string('status')
            );
        }

        $posts = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'dashboard.posts.index',
            compact('posts')
        );
    }
}
