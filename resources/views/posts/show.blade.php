@extends('layouts.guest')

@section('title', $post->title . ' — Ink & Paper')

@section('public-content')

    <article class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">

        {{-- Article Header --}}
        <header class="border-b border-border pb-10">

            {{-- Category + Meta --}}
            <div class="flex flex-wrap items-center gap-3">

                @if ($post->category)
                    <a href="#" class="text-xs font-bold uppercase tracking-widest text-primary hover:underline">
                        {{ $post->category->name }}
                    </a>
                @endif

                <span class="text-muted">•</span>

                <span class="text-xs font-medium text-muted">
                    {{ ($post->published_at ?? $post->created_at)->format('F d, Y') }}
                </span>

                <span class="text-muted">•</span>

                <span class="text-xs font-medium text-muted">
                    {{ $post->read_time }} min read
                </span>

            </div>


            {{-- Title --}}
            <h1
                class="mt-6 font-serif text-4xl font-extrabold leading-tight tracking-tight text-ink sm:text-5xl lg:text-6xl">
                {{ $post->title }}
            </h1>


            {{-- Excerpt --}}
            @if ($post->excerpt)
                <p class="mt-6 max-w-3xl font-serif text-xl leading-relaxed text-muted sm:text-2xl">
                    {{ $post->excerpt }}
                </p>
            @endif


            {{-- Author --}}
            <div class="mt-8 flex items-center gap-3">

                <x-avatar :name="$post->user->name ?? 'Anonymous'" size="md" />

                <div>

                    <a href="{{ route('authors.show', $post->user) }}"
                        class="text-sm font-semibold text-ink transition hover:text-primary">
                        {{ $post->user->name ?? 'Anonymous' }}
                    </a>

                    <p class="text-xs text-muted">
                        Author
                    </p>

                </div>

            </div>

        </header>


        {{-- Cover Image --}}
        @if ($post->cover_image)
            <div class="mt-10 overflow-hidden rounded-2xl border border-border bg-zinc-100 shadow-sm">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="w-full object-cover">
            </div>
        @endif


        {{-- Article Content --}}
        <div class="mt-12">

            <div class="prose prose-stone max-w-none font-serif text-lg leading-[1.9] text-ink sm:text-xl">

                {!! nl2br(e($post->content)) !!}

            </div>

        </div>


        {{-- Tags --}}
        @if ($post->tags->isNotEmpty())

            <div class="mt-12 border-t border-border pt-6">

                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-muted">
                    Topics
                </p>

                <div class="flex flex-wrap gap-2">

                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}"
                            class="rounded-lg border border-border bg-white px-3 py-1.5 text-xs font-medium text-ink transition hover:border-primary hover:text-primary">
                            #{{ $tag->name }}
                        </a>
                    @endforeach

                </div>

            </div>

        @endif

        <!-- Comments Section -->
        <section id="comments" class="mt-16 border-t border-border pt-10">

            <!-- Comments Header -->
            <div class="flex items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-primary">
                        Discussion
                    </span>

                    <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink">
                        Comments
                    </h2>
                </div>

                <span class="text-sm font-medium text-muted">
                    {{ $post->comments->count() }}
                    {{ Str::plural('comment', $post->comments->count()) }}
                </span>
            </div>


            <!-- Comment Form / Login Message -->
            @auth

                <div class="mt-8 rounded-2xl border border-border bg-white p-6 shadow-sm">

                    <div class="flex items-start gap-4">

                        <x-avatar :name="auth()->user()->name" size="md" />

                        <div class="flex-1">

                            <div class="mb-3">
                                <p class="text-sm font-bold text-ink">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-muted">
                                    Share your thoughts
                                </p>
                            </div>

                            <form method="POST" action="{{ route('comments.store', $post) }}">
                                @csrf

                                <textarea name="body" rows="4" placeholder="Write your comment..."
                                    class="w-full resize-none rounded-xl border border-border bg-paper p-4 text-sm text-ink placeholder-muted transition focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary">{{ old('body') }}</textarea>

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
            @else
                <!-- Guest Message -->
                <div class="mt-8 rounded-2xl border border-border bg-white p-8 text-center shadow-sm">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        💬
                    </div>

                    <h3 class="mt-4 font-serif text-xl font-bold text-ink">
                        Join the conversation
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-muted">
                        Sign in to share your thoughts and join the discussion.
                    </p>

                    <a href="{{ route('login') }}"
                        class="mt-5 inline-flex items-center justify-center rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:opacity-90">
                        Sign In to Comment
                    </a>

                </div>

            @endauth


            <!-- Comments List -->
            <div class="mt-10 space-y-6">

                @forelse ($post->comments as $comment)
                    <article class="border-b border-border/70 pb-6 last:border-0">

                        <div class="flex items-start gap-4">

                            <!-- Avatar -->
                            <x-avatar :name="$comment->user->name ?? 'Anonymous'" size="md" />

                            <!-- Comment Content -->
                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center justify-between gap-3">

                                    <div>
                                        <p class="text-sm font-bold text-ink">
                                            {{ $comment->user->name ?? 'Anonymous' }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-muted">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>


                                    <!-- Delete Button -->
                                    @auth
                                        @if (auth()->id() === $comment->user_id)
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="text-xs font-semibold text-muted transition hover:text-rose-600">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endauth

                                </div>


                                <!-- Comment Body -->
                                <p class="mt-3 text-sm leading-relaxed text-ink/80">
                                    {{ $comment->body }}
                                </p>

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="rounded-2xl border border-dashed border-border p-10 text-center">

                        <p class="font-serif text-lg font-semibold text-ink">
                            No comments yet.
                        </p>

                        <p class="mt-2 text-sm text-muted">
                            Be the first to share your thoughts.
                        </p>

                    </div>
                @endforelse

            </div>

        </section>

        {{-- Back --}}
        <div class="mt-10 border-t border-border pt-6">

            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:gap-3">
                ← Back to Ink & Paper
            </a>

        </div>

    </article>

@endsection
