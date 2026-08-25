<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPost = Post::published()
            ->with([
                'user',
                'category',
            ])
            ->latest('published_at')
            ->first();
       // dd($featuredPost);
        $posts = Post::published()
            ->with([
                'user',
                'category',
                'tags',
            ])
            ->when(
                $featuredPost,
                fn($query) =>
                    $query->where(
                        'id',
                        '!=',
                        $featuredPost->id
                    )
            )
            ->latest('published_at')
            ->paginate(10);

        $categories = Category::query()
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->take(6)
            ->get();

        return view('pages.home', compact(
            'featuredPost',
            'posts',
            'categories'
        ));
    }
}
