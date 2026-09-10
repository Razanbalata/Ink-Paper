@extends('layouts.dashboard')

@section('dashboard-content')

<div class="min-h-screen bg-paper">
    <div class="mx-auto max-w-6xl px-6 py-16 lg:px-8">

        {{-- Header --}}
        <div class="mb-12">
            <div class="mb-4 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-primary">
                <svg
                    class="h-4 w-4"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path d="M6 4.75A2.75 2.75 0 0 1 8.75 2h6.5A2.75 2.75 0 0 1 18 4.75V21l-6-3.5L6 21V4.75Z"/>
                </svg>

                Your Library
            </div>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="font-serif text-4xl font-semibold tracking-tight text-ink sm:text-5xl">
                        Saved Articles
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-7 text-muted sm:text-base">
                        Articles you've saved to read later.
                    </p>
                </div>

                @if ($bookmarks->total() > 0)
                    <div class="text-sm font-medium text-muted">
                        {{ $bookmarks->total() }}
                        {{ $bookmarks->total() === 1 ? 'article' : 'articles' }}
                    </div>
                @endif
            </div>
        </div>


        {{-- Saved Articles --}}
        @if ($bookmarks->count())

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                @foreach ($bookmarks as $post)

                    <article
                        class="group flex h-full flex-col overflow-hidden rounded-2xl border border-border/70 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-primary/30 hover:shadow-xl"
                    >

                        {{-- Cover --}}
                        @if ($post->cover_image)
                            <a
                                href="{{ route('posts.show', $post) }}"
                                class="block aspect-[16/9] overflow-hidden bg-paper"
                            >
                                <img
                                    src="{{ asset('storage/' . $post->cover_image) }}"
                                    alt="{{ $post->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >
                            </a>
                        @else
                            <a
                                href="{{ route('posts.show', $post) }}"
                                class="flex aspect-[16/9] items-center justify-center bg-paper"
                            >
                                <span class="font-serif text-2xl font-semibold text-primary/30">
                                    Ink & Paper
                                </span>
                            </a>
                        @endif


                        {{-- Content --}}
                        <div class="flex flex-1 flex-col p-6">

                            {{-- Category --}}
                            @if ($post->category)
                                <a
                                    href="{{ route('categories.show', $post->category) }}"
                                    class="mb-3 inline-block text-[11px] font-bold uppercase tracking-[0.15em] text-primary transition hover:text-primary/70"
                                >
                                    {{ $post->category->name }}
                                </a>
                            @endif


                            {{-- Title --}}
                            <h2 class="font-serif text-xl font-semibold leading-tight text-ink">
                                <a
                                    href="{{ route('posts.show', $post) }}"
                                    class="transition-colors hover:text-primary"
                                >
                                    {{ $post->title }}
                                </a>
                            </h2>


                            {{-- Excerpt --}}
                            @if ($post->excerpt)
                                <p class="mt-3 line-clamp-3 text-sm leading-6 text-muted">
                                    {{ $post->excerpt }}
                                </p>
                            @endif


                            {{-- Footer --}}
                            <div class="mt-auto flex items-center justify-between gap-4 pt-6">

                                <div class="flex min-w-0 items-center gap-3">

                                    {{-- Author Avatar --}}
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary/10 text-xs font-bold text-primary">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-semibold text-ink">
                                            {{ $post->user->name }}
                                        </p>

                                        <p class="text-[11px] text-muted">
                                            {{ optional($post->published_at)->format('M d, Y') }}
                                        </p>
                                    </div>

                                </div>


                                {{-- Read --}}
                                <a
                                    href="{{ route('posts.show', $post) }}"
                                    class="shrink-0 text-xs font-bold text-primary transition hover:translate-x-0.5"
                                >
                                    Read →
                                </a>

                            </div>

                        </div>
                    </article>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if ($bookmarks->hasPages())
                <div class="mt-12">
                    {{ $bookmarks->links() }}
                </div>
            @endif


        @else

            {{-- Empty State --}}
            <div class="flex min-h-[420px] flex-col items-center justify-center rounded-3xl border border-dashed border-border bg-white/60 px-6 text-center">

                <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-primary">

                    <svg
                        class="h-7 w-7"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M6 4.75A2.75 2.75 0 0 1 8.75 2h6.5A2.75 2.75 0 0 1 18 4.75V21l-6-3.5L6 21V4.75Z"
                        />
                    </svg>

                </div>

                <h2 class="font-serif text-2xl font-semibold text-ink">
                    Nothing saved yet
                </h2>

                <p class="mt-2 max-w-md text-sm leading-6 text-muted">
                    Found something worth coming back to?
                    Save it here and read it whenever you're ready.
                </p>

                <a
                    href="{{ route('posts.index') }}"
                    class="mt-6 inline-flex items-center rounded-full bg-ink px-5 py-2.5 text-xs font-bold text-white transition hover:bg-primary"
                >
                    Explore Articles
                </a>

            </div>

        @endif

    </div>
</div>

@endsection
