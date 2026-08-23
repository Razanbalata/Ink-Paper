<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')
            ->latest()
            ->paginate(15);

        return view(
            'dashboard.tags.index',
            compact('tags')
        );
    }

    public function create()
    {
        return view('dashboard.tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $data = $request->validated();
        //dd($data);
        $data['slug'] = Str::slug($data['name']);

        Tag::create($data);

        return redirect()
            ->route('dashboard.tags.index')
            ->with(
                'success',
                'Tag created successfully.'
            );
    }

    public function edit(Tag $tag)
    {
        return view(
            'dashboard.tags.edit',
            compact('tag')
        );
    }

    public function update(
        UpdateTagRequest $request,
        Tag $tag
    ) {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        $tag->update($data);

        return redirect()
            ->route('dashboard.tags.index')
            ->with(
                'success',
                'Tag updated successfully.'
            );
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()
            ->route('dashboard.tags.index')
            ->with(
                'success',
                'Tag deleted successfully.'
            );
    }
}
