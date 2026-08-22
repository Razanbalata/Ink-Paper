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
        ])
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('posts.create', compact('categories', 'tags'));
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
        $post = $request
            ->user()
            ->posts()
            ->create($data);

        $post->tags()->sync($tags);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load([
            'user',
            'category',
            'tags',
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

        return view('posts.edit', compact(
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

        $post->update($data);
        $post->tags()->sync($tags);

        return redirect()
            ->route('posts.show', $post)
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
