<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicAuthorController extends Controller
{
    public function show(User $user)
    {
        $posts = $user
            ->posts()
            ->published()
            ->with([
                'user',
                'category',
                'tags',
            ])
            ->latest('published_at')
            ->paginate(9);

        return view('authors.show', compact(
            'user',
            'posts'
        ));
    }
}
