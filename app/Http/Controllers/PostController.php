<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with([
            'user',
            'category',
            'tags',
            'comments.user',
        ])
            ->latest()
            ->paginate(10);

        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('dashboard.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $tags = $data['tags'] ?? [];

        unset($data['tags']);
        $data['slug'] = Str::slug($data['title']);

        // Upload cover image
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request
                ->file('cover_image')
                ->store('posts', 'public');
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        $post = $request
            ->user()
            ->posts()
            ->create($data);

        $post->tags()->sync($request->input('tags', []));

        return redirect()
            ->route('dashboard.posts.show', $post)
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        abort_unless(
            $post->status === 'published' && $post->published_at !== null,
            404
        );

        $post->load([
            'user',
            'category',
            'tags',
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        $post->load('tags');

        return view('dashboard.posts.edit', compact(
            'post',
            'categories',
            'tags'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
    UpdatePostRequest $request,
    Post $post
) {
    $this->authorize('update', $post);

    $data = $request->validated();

    $tags = $data['tags'] ?? [];
    unset($data['tags']);

    $data['slug'] = Str::slug($data['title']);

    /*
    |--------------------------------------------------------------------------
    | Cover Image
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('cover_image')) {

        // Delete old image
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        // Store new image
        $data['cover_image'] = $request
            ->file('cover_image')
            ->store('posts', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Publishing
    |--------------------------------------------------------------------------
    */

    if ($data['status'] === 'published') {
        $data['published_at'] ??= $post->published_at ?? now();
    } else {
        $data['published_at'] = null;
    }

    $post->update($data);

    $post->tags()->sync($tags);

    return redirect()
        ->route('dashboard.posts', $post)
        ->with('success', 'Post updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
