@props(['post' => null, 'categories' => [], 'tags' => []])

<div class="space-y-6">
    <!-- Title -->
    <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-ink">Title</label>
        <input type="text" name="title" value="{{ old('title', $post?->title) }}"
            placeholder="Enter a captivating title..."
            class="mt-2 w-full rounded-xl border border-border bg-paper px-4 py-3 text-sm text-ink placeholder-muted transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary">
        @error('title')
            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category & Status Grid -->
    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-ink">Category</label>
            <select name="category_id"
                class="mt-2 w-full rounded-xl border border-border bg-paper px-4 py-3 text-sm text-ink transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $post?->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-ink">Status</label>
            <select name="status"
                class="mt-2 w-full rounded-xl border border-border bg-paper px-4 py-3 text-sm text-ink transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary">
                @foreach (['draft', 'published', 'archived'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $post?->status ?? 'draft') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Excerpt -->
    <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-ink">Excerpt</label>
        <textarea name="excerpt" rows="3" placeholder="A brief summary of your article..."
            class="mt-2 w-full rounded-xl border border-border bg-paper p-4 text-sm text-ink placeholder-muted transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary">{{ old('excerpt', $post?->excerpt) }}</textarea>
        @error('excerpt')
            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content -->
    <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-ink">Content</label>
        <textarea name="content" rows="8" placeholder="Write your story here..."
            class="mt-2 w-full rounded-xl border border-border bg-paper p-4 text-sm text-ink placeholder-muted transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary">{{ old('content', $post?->content) }}</textarea>
        @error('content')
            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tags Selection -->
    @if (count($tags) > 0)
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-ink mb-3">Tags</label>
            <div class="flex flex-wrap gap-2 rounded-xl border border-border bg-paper p-4">
                @foreach ($tags as $tag)
                    <label
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-border bg-white px-3 py-1.5 text-xs font-medium text-ink transition hover:border-primary has-[:checked]:border-primary has-[:checked]:bg-primary/10 has-[:checked]:text-primary">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            class="rounded border-border text-primary focus:ring-primary" @checked(in_array($tag->id, old('tags', $post?->tags?->pluck('id')->toArray() ?? [])))>
                        <span>#{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('tags')
                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    @endif
</div>
