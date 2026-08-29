@extends('layouts.dashboard')

@section('title', $post->title . ' — Post Details')

@section('dashboard-content')
    <div class="mx-auto max-w-5xl space-y-8 py-8 px-4 sm:px-6">

        {{-- Top Navigation & Action Bar --}}
        <div class="flex flex-col gap-4 border-b border-slate-200/80 pb-6 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('dashboard.posts') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-slate-900 group">
                <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Posts
            </a>

            <div class="flex flex-wrap items-center gap-2.5">
                @if ($post->status === 'published')
                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        View Public
                    </a>
                @endif

                <a href="{{ route('posts.edit', $post) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                    onsubmit="return confirm('Are you sure you want to delete this article?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50/50 px-4 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100 hover:text-rose-700">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-2.5">
                @if ($post->category)
                    <x-badge variant="primary">
                        {{ $post->category->name }}
                    </x-badge>
                @endif

                @if ($post->status === 'published')
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-0.5 text-xs font-semibold text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Published
                    </span>
                @elseif ($post->status === 'draft')
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-3 py-0.5 text-xs font-semibold text-amber-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        Draft
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-3 py-0.5 text-xs font-semibold text-slate-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                        Archived
                    </span>
                @endif
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl leading-tight">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p class="text-lg leading-relaxed text-slate-600 max-w-3xl">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>

        {{-- Meta Stats Grid --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Created</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->created_at->format('M d, Y') }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">At {{ $post->created_at->format('h:i A') }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Published</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $post->published_at ? $post->published_at->format('h:i A') : 'Draft status' }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Reading Time</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->read_time }} min read
                </p>
                <p class="text-xs text-slate-500 mt-0.5">Estimated time</p>
            </div>
        </div>

        {{-- Featured Cover Image --}}
        @if ($post->cover_image)
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50 shadow-xs">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="max-h-[450px] w-full object-cover">
            </div>
        @endif

        {{-- Article Body --}}
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-xs">
            <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed text-base sm:text-lg">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        {{-- Tags Section --}}
        @if ($post->tags->isNotEmpty())
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tags</span>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span
                            class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-700 transition hover:bg-slate-100">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif


       
{{-- Comments Section --}}
<section id="comments" class="rounded-2xl border border-border/80 bg-white p-8 shadow-sm sm:p-10">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 border-b border-border/60 pb-5">

        <div>
            <span class="text-xs font-bold uppercase tracking-widest text-primary">
                Discussion
            </span>

            <h2 class="mt-1 font-serif text-2xl font-extrabold text-ink">
                Comments
            </h2>

            <p class="mt-1 text-sm text-muted">
                Manage the discussion around your article.
            </p>
        </div>

        <span class="rounded-full border border-border bg-paper px-3 py-1 text-xs font-semibold text-muted">
            {{ $post->comments->count() }}
            {{ Str::plural('comment', $post->comments->count()) }}
        </span>

    </div>


    {{-- Add Comment --}}
    @auth
        <div class="mt-6 rounded-2xl border border-border bg-paper/40 p-6">

            <div class="flex items-start gap-4">

                <x-avatar
                    :name="auth()->user()->name"
                    size="md"
                />

                <div class="min-w-0 flex-1">

                    <div class="mb-3">
                        <p class="text-sm font-semibold text-ink">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-muted">
                            Add your thoughts about this article.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('comments.store', $post) }}"
                    >
                        @csrf

                        <input
                            type="hidden"
                            name="redirect_to"
                            value="dashboard"
                        >

                        <textarea
                            name="body"
                            rows="3"
                            required
                            minlength="2"
                            maxlength="1000"
                            placeholder="Write a response..."
                            class="w-full resize-none rounded-xl border border-border bg-white p-4 text-sm text-ink placeholder-muted transition focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        >{{ old('body') }}</textarea>

                        @error('body')
                            <p class="mt-2 text-xs font-medium text-rose-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="mt-4 flex justify-end">
                            <x-button type="submit">
                                Post Comment
                            </x-button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    @endauth


    {{-- Comments List --}}
    <div class="mt-8 space-y-6">

        @forelse ($post->comments as $comment)

            <article
                class="border-b border-border/60 pb-6 last:border-0"
                x-data="{ editing: false }"
            >

                <div class="flex items-start gap-4">

                    {{-- Avatar --}}
                    <x-avatar
                        :name="$comment->user->name ?? 'Anonymous'"
                        size="md"
                    />

                    <div class="min-w-0 flex-1">

                        {{-- Comment Header --}}
                        <div class="flex flex-wrap items-start justify-between gap-3">

                            <div>
                                <p class="text-sm font-semibold text-ink">
                                    {{ $comment->user->name ?? 'Anonymous' }}
                                </p>

                                <p class="mt-0.5 text-xs text-muted">
                                    {{ $comment->created_at->diffForHumans() }}

                                    @if ($comment->updated_at->gt($comment->created_at))
                                        <span class="italic text-muted/70">
                                            · edited
                                        </span>
                                    @endif
                                </p>
                            </div>


                            {{-- Actions --}}
                            <div class="flex items-center gap-3">

                                {{-- Edit: Comment Owner ONLY --}}
                                @if (auth()->id() === $comment->user_id)

                                    <button
                                        type="button"
                                        @click="editing = true"
                                        x-show="!editing"
                                        class="text-xs font-medium text-muted transition hover:text-primary"
                                    >
                                        Edit
                                    </button>

                                @endif


                                {{-- Delete: Comment Owner OR Post Owner --}}
                                @if (
                                    auth()->id() === $comment->user_id ||
                                    auth()->id() === $post->user_id
                                )

                                    <form
                                        method="POST"
                                        action="{{ route('comments.destroy', $comment) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this comment?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <input
                                            type="hidden"
                                            name="redirect_to"
                                            value="dashboard"
                                        >

                                        <button
                                            type="submit"
                                            class="text-xs font-medium text-muted transition hover:text-rose-600"
                                        >
                                            Delete
                                        </button>
                                    </form>

                                @endif

                            </div>

                        </div>


                        {{-- Normal Comment --}}
                        <div
                            x-show="!editing"
                            class="mt-3 text-sm leading-relaxed text-ink/80"
                        >
                            {{ $comment->body }}
                        </div>


                        {{-- Inline Edit --}}
                        @if (auth()->id() === $comment->user_id)

                            <div
                                x-show="editing"
                                x-cloak
                                class="mt-3"
                            >

                                <form
                                    method="POST"
                                    action="{{ route('comments.update', $comment) }}"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="hidden"
                                        name="redirect_to"
                                        value="dashboard"
                                    >

                                    <textarea
                                        name="body"
                                        rows="3"
                                        required
                                        minlength="2"
                                        maxlength="1000"
                                        class="w-full rounded-xl border border-border bg-paper/50 p-4 text-sm text-ink focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary"
                                    >{{ $comment->body }}</textarea>

                                    @error('body')
                                        <p class="mt-1.5 text-xs font-medium text-rose-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <div class="mt-3 flex items-center gap-2">

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-primary px-4 py-2 text-xs font-semibold text-white transition hover:opacity-90"
                                        >
                                            Save
                                        </button>

                                        <button
                                            type="button"
                                            @click="editing = false"
                                            class="rounded-lg border border-border bg-white px-4 py-2 text-xs font-semibold text-muted transition hover:bg-paper hover:text-ink"
                                        >
                                            Cancel
                                        </button>

                                    </div>

                                </form>

                            </div>

                        @endif

                    </div>

                </div>

            </article>

        @empty

            <div class="rounded-2xl border border-dashed border-border p-10 text-center">

                <p class="font-serif text-lg font-semibold text-ink">
                    No comments yet.
                </p>

                <p class="mt-2 text-sm text-muted">
                    Be the first to start the discussion.
                </p>

            </div>

        @endforelse

    </div>

</section>





    </div>
@endsection
