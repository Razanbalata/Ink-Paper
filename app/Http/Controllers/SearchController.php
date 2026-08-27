<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));

        $posts = Post::published()
            ->with([
                'user',
                'category',
                'tags',
            ])
            ->when($query, function ($builder) use ($query) {
                $builder->where(function ($builder) use ($query) {
                    $builder
                        ->where('title', 'like', "%{$query}%")
                        ->orWhere('excerpt', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                });
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('search.index', compact(
            'posts',
            'query'
        ));
    }
}
