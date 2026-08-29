<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentReceived;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a new comment.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => [
                'required',
                'string',
                'min:2',
                'max:1000',
            ],
        ]);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);
        // Send notification to the post owner
        if ($post->user_id !== $request->user()->id) {
            $post->user->notify(
                new CommentReceived(
                    $request->user(),
                    $post,
                    $comment
                )
            );
        }

        if ($request->input('redirect_to') === 'dashboard') {
            return redirect()
                ->to(route('dashboard.posts.show', $post) . '#comments')
                ->with('success', 'Comment added successfully.');
        }

        return redirect()
            ->to(route('posts.show', $post->slug) . '#comments')
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Update the comment.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'body' => [
                'required',
                'string',
                'min:2',
                'max:1000',
            ],
        ]);

        $comment->update([
            'body' => $validated['body'],
        ]);

        return redirect()
            ->to(route('posts.show', $comment->post) . '#comments')
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Delete the comment.
     */
    public function destroy(Request $request, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $post = $comment->post;

        $comment->delete();

        if ($request->input('redirect_to') === 'dashboard') {
            return redirect()
                ->to(route('dashboard.posts.show', $post) . '#comments')
                ->with('success', 'Comment deleted successfully.');
        }

        return redirect()
            ->to(route('posts.show', $post->slug) . '#comments')
            ->with('success', 'Comment deleted successfully.');
    }
}
