@extends('layouts.app')

@section('title', $post->title . ' — Ink & Paper')

@section('content')
    <article class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">

        <!-- Header & Category -->
        <div class="border-b border-border pb-8 text-center sm:text-left">
            <div class="flex flex-wrap items-center justify-center gap-3 sm:justify-start">
                @if ($post->category)
                    <x-badge variant="primary">
                        {{ $post->category->name }}
                    </x-badge>
                @endif
                <span class="text-xs font-medium text-muted">
                    {{ $post->created_at->format('F d, Y') }}
                </span>
                <span class="text-xs font-medium text-muted">
                    {{ $post->read_time }} min read
                </span>
            </div>

            <!-- Post Title -->
            <h1 class="mt-4 font-serif text-4xl font-extrabold leading-tight text-ink sm:text-5xl lg:text-6xl">
                {{ $post->title }}
            </h1>

            <!-- Author Info & Actions Grid -->
            <div class="mt-8 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <x-avatar :name="$post->user->name ?? 'Anonymous'" size="md" />
                    <div class="text-left">
                        <p class="text-sm font-bold text-ink">
                            {{ $post->user->name ?? 'Anonymous' }}
                        </p>
                        <p class="text-xs text-muted">Author</p>
                    </div>
                </div>

                <!-- Admin / Owner Actions -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('posts.edit', $post) }}"
                        class="rounded-xl border border-border bg-white px-4 py-2 text-xs font-semibold text-ink shadow-sm transition hover:bg-paper">
                        Edit Article
                    </a>

                    <form method="POST" action="{{ route('posts.destroy', $post) }}"
                        onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="rounded-xl border border-rose-200 bg-rose-50/50 px-4 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Excerpt Callout -->
        @if ($post->excerpt)
            <div class="my-8 rounded-2xl border-l-4 border-primary bg-white p-6 shadow-sm">
                <p class="font-serif text-lg italic leading-relaxed text-ink/80">
                    "{{ $post->excerpt }}"
                </p>
            </div>
        @endif

        <!-- Main Article Content -->
        <div class="prose prose-stone max-w-none font-serif text-lg leading-relaxed text-ink sm:text-xl">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Tags Section -->
        @if ($post->tags && $post->tags->isNotEmpty())
            <div class="mt-12 flex flex-wrap items-center gap-2 border-t border-border pt-6">
                <span class="text-xs font-bold uppercase tracking-wider text-muted">Tags:</span>
                @foreach ($post->tags as $tag)
                    <span class="rounded-lg bg-white border border-border px-3 py-1 text-xs font-medium text-ink">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Footer Back Link -->
        <div class="mt-10 border-t border-border pt-6">
            <a href="{{ route('posts.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                &larr; Back to all articles
            </a>
        </div>

    </article>
@endsection
