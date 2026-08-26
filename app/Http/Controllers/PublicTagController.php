<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class PublicTagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag
            ->posts()
            ->published()
            ->with([
                'user',
                'category',
                'tags',
            ])
            ->latest('published_at')
            ->paginate(9);

        return view('tags.show', compact(
            'tag',
            'posts'
        ));
    }
}
