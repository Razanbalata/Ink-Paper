<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $bookmarks = $request
            ->user()
            ->bookmarkedPosts()
            ->published()
            ->latest('bookmarks.created_at')
            ->paginate(12);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Request $request, Post $post)
    {
        $user = $request->user();

        $bookmark = $post
            ->bookmarks()
            ->where('user_id', $user->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();

            $bookmarked = false;
        } else {
            $post->bookmarks()->create([
                'user_id' => $user->id,
            ]);

            $bookmarked = true;
        }

        return response()->json([
            'bookmarked' => $bookmarked,
        ]);
    }
}
