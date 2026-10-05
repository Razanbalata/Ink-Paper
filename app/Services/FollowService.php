<?php

namespace App\Services;

use App\Models\User;
use LogicException;

class FollowService
{
    /**
     * Follow a user.
     */
    public function follow(User $follower, User $following): void
    {
        if ($follower->is($following)) {
            throw new LogicException('You cannot follow yourself.');
        }

        if ($this->isFollowing($follower, $following)) {
            return;
        }

        $follower->following()->attach($following->id);
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $follower, User $following): void
    {
        $follower->following()->detach($following->id);
    }

    /**
     * Check whether a user follows another user.
     */
    public function isFollowing(User $follower, User $following): bool
    {
        return $follower->following()
            ->where('users.id', $following->id)
            ->exists();
    }
}
