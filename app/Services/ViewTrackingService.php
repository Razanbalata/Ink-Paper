<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ViewTrackingService
{
    private const COOLDOWN_MINUTES = 30;

    /**
     * Track a post view.
     */
    public function track(Post $post): void
    {
        $query = $post->views()
            ->where('created_at', '>=', now()->subMinutes(self::COOLDOWN_MINUTES));

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', session()->getId());
        }

        if ($query->exists()) {
            return;
        }

        $post->views()->create([
            'user_id' => Auth::id(),
            'session_id' => Auth::check()
                ? null
                : session()->getId(),
        ]);
    }
}