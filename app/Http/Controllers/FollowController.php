<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FollowService;
use Illuminate\Http\RedirectResponse;

class FollowController extends Controller
{
    public function __construct(
        private FollowService $followService
    ) {}

    public function store(User $user): RedirectResponse
    {
        $this->followService->follow(
            auth()->user(),
            $user
        );

        return back();
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->followService->unfollow(
            auth()->user(),
            $user
        );

        return back();
    }
}
