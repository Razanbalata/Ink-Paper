<?php

namespace App\Http\Controllers;

use App\Models\Category;

class PublicCategoryController extends Controller
{
    public function show(Category $category)
    {
        $posts = $category
            ->posts()
            ->published()
            ->with([
                'user',
                'category',
                'tags',
            ])
            ->latest('published_at')
            ->paginate(9);

        return view('categories.show', compact(
            'category',
            'posts'
        ));
    }
}
