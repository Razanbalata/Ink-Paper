<?php

namespace App\Http\Controllers;

use App\Models\Post;
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

    public function show(Post $post)
    {
        abort_unless(
            $post->user_id === auth()->id(),
            403
        );

        $post->load([
            'user',
            'category',
            'tags',
            'comments.user',
        ]);

        return view(
            'dashboard.posts.show',
            compact('post')
        );
    }
}
