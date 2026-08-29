<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\ReactionReceived;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * Toggle a reaction on a post.
     */
    public function toggle(Request $request, Post $post)
    {
        $user = $request->user();

        $reaction = $post
            ->reactions()
            ->where('user_id', $user->id)
            ->first();

        if ($reaction) {
            $reaction->delete();

            $reacted = false;
        } else {
            $post->reactions()->create([
                'user_id' => $user->id,
            ]);

            $reacted = true;

            // Send notification to the post owner
            if ($post->user_id !== $user->id) {
                $post->user->notify(
                    new ReactionReceived($user, $post)
                );
            }
        }

        return response()->json([
            'reacted' => $reacted,
            'count' => $post->reactions()->count(),
        ]);
    }

    public function users(Post $post)
    {
        $users = $post
            ->reactions()
            ->with('user:id,name')
            ->latest()
            ->get()
            ->map(function ($reaction) {
                return [
                    'id' => $reaction->user->id,
                    'name' => $reaction->user->name,
                ];
            });

        return response()->json([
            'users' => $users,
        ]);
    }
}
