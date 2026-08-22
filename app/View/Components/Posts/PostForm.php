<?php

namespace App\View\Components\Posts;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class PostForm extends Component
{
    public function __construct(
    public ?Post $post,
    public Collection $categories,
    public Collection $tags,
) {}

    public function render(): View|Closure|string
    {
        return view('components.posts.post-form');
    }
}