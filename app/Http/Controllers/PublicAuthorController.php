<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FollowService;
use Illuminate\View\View;

class PublicAuthorController extends Controller
{
    public function __construct(
        private FollowService $followService
    ) {}

    public function show(User $user): View
    {
        $user->loadCount([
            'followers',
            'following',
        ]);

        $isFollowing = auth()->check()
            && auth()->id() !== $user->id
            && $this->followService->isFollowing(
                auth()->user(),
                $user
            );

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
            'posts',
            'isFollowing'
        ));
    }

    public function followers(User $user): View
    {
        $followers = $user
            ->followers()
            ->latest('user_follows.created_at')
            ->paginate(20);

        return view('authors.partials.followers', compact(
            'user',
            'followers'
        ));
    }

    public function following(User $user): View
    {
        $following = $user
            ->following()
            ->latest('user_follows.created_at')
            ->paginate(20);

        return view('authors.partials.following', compact(
            'user',
            'following'
        ));
    }
}
