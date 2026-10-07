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
    {{-- Cover Image --}}
    <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-ink">
            Cover Image
        </label>

        <div class="mt-2">

            {{-- Hidden File Input --}}
            <input id="cover_image" type="file" name="cover_image" accept="image/png,image/jpeg,image/jpg,image/webp"
                class="hidden">

            {{-- Image Preview / Upload Area --}}
            <label for="cover_image"
                class="group relative block cursor-pointer overflow-hidden rounded-2xl border border-border bg-paper">
                <img id="image-preview" src="{{ $post?->cover_image ? asset('storage/' . $post->cover_image) : '' }}"
                    alt="Cover preview"
                    class="{{ $post?->cover_image ? '' : 'hidden' }} h-72 w-full object-cover transition duration-300 group-hover:scale-[1.02]">

                {{-- Empty State --}}
                <div id="image-placeholder"
                    class="{{ $post?->cover_image ? 'hidden' : '' }} flex h-72 flex-col items-center justify-center">
                    <svg class="h-10 w-10 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>

                    <p class="mt-3 text-sm font-semibold text-ink">
                        Choose a cover image
                    </p>

                    <p class="mt-1 text-xs text-muted">
                        PNG, JPG, JPEG or WEBP
                    </p>
                </div>

                {{-- Hover Overlay --}}
                <div id="image-overlay"
                    class="{{ $post?->cover_image ? '' : 'hidden' }} absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition duration-200 group-hover:opacity-100">
                    <span class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-ink shadow-sm">
                        Change cover image
                    </span>
                </div>
            </label>

            {{-- Selected File --}}
            <p id="selected-file-name" class="mt-2 hidden text-xs text-muted"></p>

        </div>

        @error('cover_image')
            <p class="mt-1.5 text-xs font-medium text-rose-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    <!-- Content -->
    <div>
        <!-- Ink AI -->
        <x-ai.writing-assistant />
        <div class="mt-2">
            <x-editor.rich-editor name="content" :value="old('content', $post?->content)" />
        </div>
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


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('cover_image');
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');
        const overlay = document.getElementById('image-overlay');
        const fileName = document.getElementById('selected-file-name');

        if (!input) return;

        input.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                // Replace old preview with new image
                preview.src = e.target.result;

                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                overlay.classList.remove('hidden');

                fileName.textContent = `Selected: ${file.name}`;
                fileName.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        });
    });
</script>
