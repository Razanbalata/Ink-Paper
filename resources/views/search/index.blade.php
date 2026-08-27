@extends('layouts.guest')

@section('title', $query ? 'Search: ' . $query . ' — Ink & Paper' : 'Search — Ink & Paper')

@section('public-content')

    {{-- Search Header --}}
    <section class="border-b border-border bg-paper">

        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">

            <div class="max-w-3xl">

                <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">
                    Search
                </span>

                <h1 class="mt-4 font-serif text-5xl font-extrabold tracking-tight text-ink sm:text-6xl">
                    Find something worth reading.
                </h1>

                <p class="mt-5 text-lg leading-relaxed text-muted">
                    Search through stories, ideas, and perspectives published on Ink &amp; Paper.
                </p>

            </div>

            {{-- Search Form --}}
            <form action="{{ route('search') }}" method="GET" class="mt-10 max-w-3xl">

                <div class="flex flex-col gap-3 sm:flex-row">

                    <div class="relative flex-1">

                        <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-muted"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>

                        <input type="search" name="q" value="{{ $query }}" placeholder="Search articles..."
                            class="w-full rounded-xl border border-border bg-white py-3.5 pl-12 pr-4 text-sm text-ink outline-none transition placeholder:text-muted focus:border-primary focus:ring-2 focus:ring-primary/10" />

                    </div>

                    <button type="submit"
                        class="rounded-xl bg-ink px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-primary">
                        Search
                    </button>

                </div>

            </form>

        </div>

    </section>


    {{-- Search Results --}}
    <section class="py-16 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if ($query)

                {{-- Results Header --}}
                <div class="flex items-end justify-between border-b border-border pb-6">

                    <div>

                        <span class="text-xs font-bold uppercase tracking-widest text-primary">
                            Results
                        </span>

                        <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                            Results for "{{ $query }}"
                        </h2>

                    </div>

                    <span class="hidden text-sm text-muted sm:block">
                        {{ $posts->total() }}
                        {{ Str::plural('result', $posts->total()) }}
                    </span>

                </div>


                @if ($posts->count())

                    {{-- Results Grid --}}
                    <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                        @foreach ($posts as $post)
                            <x-card :post="$post"
                                class="group flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md">

                                <div>

                                    {{-- Cover --}}
                                    <a href="{{ route('dashboard.posts.show', $post->slug) }}" class="block">

                                        <div
                                            class="relative flex h-52 items-center justify-center overflow-hidden rounded-lg bg-zinc-100">

                                            @if ($post->cover_image)
                                                <img src="{{ asset('storage/' . $post->cover_image) }}"
                                                    alt="{{ $post->title }}"
                                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                            @else
                                                <span
                                                    class="font-serif text-5xl font-bold text-zinc-300 transition-transform duration-300 group-hover:scale-110">
                                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                            @endif

                                            @if ($post->category)
                                                <div class="absolute left-3 top-3">

                                                    <a href="{{ route('categories.show', $post->category->slug) }}"
                                                        class="inline-flex" onclick="event.stopPropagation();">
                                                        <x-badge variant="primary">
                                                            {{ $post->category->name }}
                                                        </x-badge>
                                                    </a>

                                                </div>
                                            @endif

                                        </div>

                                    </a>


                                    {{-- Content --}}
                                    <div class="mt-6">

                                        <h3
                                            class="font-serif text-2xl font-bold leading-snug text-ink transition group-hover:text-primary">

                                            <a href="{{ route('posts.show', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>

                                        </h3>

                                        @if ($post->excerpt)
                                            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">
                                                {{ $post->excerpt }}
                                            </p>
                                        @endif

                                    </div>

                                </div>


                                {{-- Footer --}}
                                <div class="mt-8 flex items-center justify-between border-t border-border/50 pt-4">

                                    <div class="flex items-center gap-3">

                                        <x-avatar :name="$post->user->name ?? 'Anonymous'" size="sm" />

                                        <div>

                                            <a href="{{ route('authors.show', $post->user) }}"
                                                class="text-sm font-semibold text-ink transition hover:text-primary">
                                                {{ $post->user->name ?? 'Anonymous' }}
                                            </a>

                                            <p class="text-xs text-muted">
                                                {{ $post->read_time }} min read
                                            </p>

                                        </div>

                                    </div>

                                    <span class="text-xs font-medium text-muted">
                                        {{ ($post->published_at ?? $post->created_at)->format('M d') }}
                                    </span>

                                </div>

                            </x-card>
                        @endforeach

                    </div>


                    {{-- Pagination --}}
                    @if ($posts->hasPages())
                        <div class="mt-12 border-t border-border pt-8">
                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    {{-- No Results --}}
                    <div class="mt-10 rounded-2xl border border-dashed border-border bg-white px-6 py-16 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary/10">

                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="1.8"
                                    d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>

                        </div>

                        <h3 class="mt-5 font-serif text-2xl font-bold text-ink">
                            No stories found
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-muted">
                            We couldn't find any published stories matching
                            "{{ $query }}".
                        </p>

                        <a href="{{ route('search') }}"
                            class="mt-6 inline-flex items-center text-sm font-semibold text-primary hover:underline">
                            Clear search
                        </a>

                    </div>

                @endif
            @else
                {{-- Initial Search State --}}
                <div class="rounded-2xl border border-border bg-white px-6 py-16 text-center">

                    <span class="text-xs font-bold uppercase tracking-widest text-primary">
                        Explore
                    </span>

                    <h2 class="mt-3 font-serif text-3xl font-extrabold text-ink">
                        What are you curious about?
                    </h2>

                    <p class="mx-auto mt-3 max-w-lg text-sm leading-relaxed text-muted">
                        Search for topics, technologies, ideas, or anything
                        you'd like to discover.
                    </p>

                </div>

            @endif

        </div>

    </section>

@endsection
