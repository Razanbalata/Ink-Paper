@extends('layouts.guest')

@section('title', $post->title . ' — Ink & Paper')

@section('public-content')

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">

        {{-- Article Header --}}
        <header class="border-b border-border/80 pb-10">

            {{-- Category + Meta --}}
            <div class="flex flex-wrap items-center gap-2.5 text-xs font-medium text-muted">
                @if ($post->category)
                    <a href="#" class="font-bold uppercase tracking-widest text-primary hover:underline">
                        {{ $post->category->name }}
                    </a>
                    <span>•</span>
                @endif

                <time datetime="{{ ($post->published_at ?? $post->created_at)->toIso8601String() }}">
                    {{ ($post->published_at ?? $post->created_at)->format('F d, Y') }}
                </time>

                <span>•</span>

                <span>{{ $post->read_time }} min read</span>
            </div>

            {{-- Title --}}
            <h1 class="mt-5 font-serif text-3xl font-bold tracking-tight text-ink sm:text-5xl leading-[1.15]">
                {{ $post->title }}
            </h1>

            {{-- Excerpt --}}
            @if ($post->excerpt)
                <p class="mt-5 font-serif text-lg leading-relaxed text-muted/90 sm:text-xl">
                    {{ $post->excerpt }}
                </p>
            @endif

            {{-- Author --}}
            <div class="mt-8 flex items-center gap-3.5 pt-2">
                <x-avatar :name="$post->user->name ?? 'Anonymous'" size="md" class="ring-2 ring-primary/10" />

                <div>
                    <a href="{{ route('authors.show', $post->user) }}"
                        class="text-sm font-semibold text-ink transition hover:text-primary">
                        {{ $post->user->name ?? 'Anonymous' }}
                    </a>
                    <p class="text-xs text-muted">Author</p>
                </div>
            </div>

        </header>

        {{-- Cover Image --}}
        @if ($post->cover_image)
            <div class="mt-10 overflow-hidden rounded-2xl border border-border/80 bg-paper shadow-sm">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="w-full max-h-[500px] object-cover transition duration-300 hover:scale-[1.01]">
            </div>
        @endif

        {{-- Article Content --}}
        <div class="mt-10">
            <div
                class="prose prose-stone max-w-none font-serif text-base sm:text-lg leading-[1.85] text-ink/90 selection:bg-primary/20">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        {{-- Tags --}}
        @if ($post->tags->isNotEmpty())
            <div class="mt-12 border-t border-border/80 pt-6">
                <span class="block text-[11px] font-bold uppercase tracking-widest text-muted mb-3">
                    Topics
                </span>

                <div class="flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}"
                            class="rounded-lg border border-border bg-paper/50 px-3 py-1 text-xs font-medium text-ink/80 transition hover:border-primary hover:bg-white hover:text-primary">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Comments Section --}}
<section id="comments" class="mt-16 border-t border-border/80 pt-10">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <span class="text-[11px] font-bold uppercase tracking-widest text-primary">
                Discussion
            </span>
            <h2 class="mt-0.5 font-serif text-2xl font-bold text-ink">
                Comments
            </h2>
        </div>

        <span class="rounded-full border border-border bg-paper/60 px-3 py-1 text-xs font-semibold text-muted shadow-2xs">
            {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
        </span>
    </div>

    {{-- Comment Form / Guest Login Prompt --}}
    @auth
        <div class="mt-8 rounded-2xl border border-border/80 bg-white p-5 shadow-xs transition sm:p-6">
            <div class="flex items-start gap-3.5 sm:gap-4">
                <x-avatar :name="auth()->user()->name" size="md" class="shrink-0 ring-2 ring-primary/10" />

                <div class="min-w-0 flex-1">
                    <div class="mb-3">
                        <p class="text-sm font-semibold text-ink">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-muted">Share your thoughts with the community</p>
                    </div>

                    <form method="POST" action="{{ route('comments.store', $post) }}">
                        @csrf
                        <input type="hidden" name="redirect_to" value="public">

                        <textarea name="body" rows="3" placeholder="Write a response..." required minlength="2" maxlength="1000"
                            class="w-full resize-y rounded-xl border border-border/80 bg-paper/30 p-4 text-sm text-ink placeholder-muted/70 transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary leading-relaxed">{{ old('body') }}</textarea>

                        @error('body')
                            <p class="mt-2 text-xs font-medium text-rose-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="mt-3 flex justify-end">
                            <x-button type="submit">
                                Post Comment
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="mt-8 rounded-2xl border border-border/80 bg-paper/40 p-8 text-center sm:p-10">
            <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-primary/10 text-primary">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>

            <h3 class="mt-3.5 font-serif text-lg font-bold text-ink">
                Join the conversation
            </h3>

            <p class="mx-auto mt-1 max-w-xs text-xs leading-relaxed text-muted">
                Sign in to share your thoughts and respond to this article.
            </p>

            <a href="{{ route('login') }}"
                class="mt-5 inline-flex items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-xs font-semibold text-white shadow-xs transition hover:opacity-95">
                Sign In to Comment
            </a>
        </div>
    @endauth

    {{-- Comments List --}}
    <div class="mt-8 space-y-6">
        @forelse ($post->comments as $comment)
            <article class="border-b border-border/60 pb-6 last:border-0" x-data="{ editing: false }">
                <div class="flex items-start gap-3.5">
                    <x-avatar :name="$comment->user->name ?? 'Anonymous'" size="md" class="shrink-0" />

                    <div class="min-w-0 flex-1">
                        {{-- Meta Header --}}
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-ink">
                                    {{ $comment->user->name ?? 'Anonymous' }}
                                </span>
                                <span class="text-xs text-muted/60">•</span>
                                <time class="text-xs text-muted">
                                    {{ $comment->created_at->diffForHumans() }}
                                </time>

                                @if ($comment->updated_at->gt($comment->created_at))
                                    <span class="text-[10px] italic text-muted/70">(edited)</span>
                                @endif
                            </div>

                            @auth
                                @if (auth()->id() === $comment->user_id)
                                    <div class="flex items-center gap-3" x-show="!editing">
                                        <button type="button" @click="editing = true"
                                            class="text-xs font-medium text-muted transition hover:text-primary">
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this comment?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="redirect_to" value="public">
                                            <button type="submit"
                                                class="text-xs font-medium text-muted transition hover:text-rose-600">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        {{-- Comment View --}}
                        <div x-show="!editing" class="mt-2.5 text-sm leading-relaxed text-ink/85">
                            {{ $comment->body }}
                        </div>

                        {{-- Inline Edit Form --}}
                        @auth
                            @if (auth()->id() === $comment->user_id)
                                <div x-show="editing" x-cloak class="mt-3">
                                    <form method="POST" action="{{ route('comments.update', $comment) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="redirect_to" value="public">

                                        <textarea name="body" rows="3" required minlength="2" maxlength="1000"
                                            class="w-full resize-y rounded-xl border border-border bg-paper/50 p-3.5 text-sm text-ink placeholder-muted transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary leading-relaxed">{{ $comment->body }}</textarea>

                                        @error('body')
                                            <p class="mt-1.5 text-xs font-medium text-rose-600">
                                                {{ $message }}
                                            </p>
                                        @enderror

                                        <div class="mt-3 flex items-center gap-2">
                                            <button type="submit"
                                                class="rounded-lg bg-primary px-3.5 py-1.5 text-xs font-semibold text-white transition hover:opacity-90">
                                                Save
                                            </button>

                                            <button type="button" @click="editing = false"
                                                class="rounded-lg border border-border bg-white px-3.5 py-1.5 text-xs font-semibold text-muted transition hover:bg-paper hover:text-ink">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-border/80 p-8 text-center">
                <p class="font-serif text-base font-semibold text-ink">
                    No comments yet.
                </p>
                <p class="mt-1 text-xs text-muted">
                    Be the first to share your thoughts on this article.
                </p>
            </div>
        @endforelse
    </div>

</section>

        {{-- Back Link --}}
        <div class="mt-12 border-t border-border/80 pt-6">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:-translate-x-0.5">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Ink & Paper
            </a>
        </div>

    </article>

@endsection
