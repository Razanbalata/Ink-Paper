@extends('layouts.guest')

@section('title', 'Ink & Paper — Ideas Worth Reading')

@section('public-content')

    {{-- Hero Section --}}
    <section class="relative overflow-hidden border-b border-border bg-paper py-20 sm:py-32">
        {{-- Subtle Ambient Glow --}}
        <div class="pointer-events-none absolute -top-40 -left-40 h-96 w-96 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 -right-40 h-96 w-96 rounded-full bg-primary/5 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">

                {{-- Hero Content --}}
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2.5 rounded-full border border-primary/20 bg-primary/10 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary shadow-xs">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-primary"></span>
                        </span>
                        A Place For Thoughtful Ideas
                    </div>

                    <h1 class="mt-6 font-serif text-5xl font-extrabold tracking-tight text-ink sm:text-6xl lg:text-7xl lg:leading-[1.08]">
                        Ideas worth <br class="hidden sm:inline" />
                        <span class="font-normal italic text-primary">reading &amp; sharing.</span>
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-muted sm:text-xl">
                        Discover curated stories, deep perspectives, and practical insights written by passionate creators worldwide.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <x-button class="shadow-sm transition-transform hover:-translate-y-0.5">
                            Start Writing
                        </x-button>

                        <x-button variant="secondary" class="transition-transform hover:-translate-y-0.5">
                            Explore Stories
                        </x-button>
                    </div>
                </div>

                {{-- Hero Editorial Quote Card --}}
                <div class="lg:col-span-5">
                    <div class="relative rounded-2xl border border-border/80 bg-white/80 p-8 shadow-sm backdrop-blur-md transition duration-300 hover:border-primary/30 hover:shadow-md sm:p-10">
                        <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-widest text-muted">
                            <span class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                Editor's Choice
                            </span>
                            <span class="font-serif font-normal italic text-primary">Vol. 01</span>
                        </div>

                        <blockquote class="mt-6 font-serif text-xl italic leading-relaxed text-ink sm:text-2xl">
                            “Writing is not life itself, but is, I think, sometimes my way back to life.”
                        </blockquote>

                        <div class="mt-8 flex items-center gap-3.5 border-t border-border/60 pt-6">
                            <x-avatar name="Ink & Paper Editorial" size="sm" class="ring-2 ring-primary/20" />
                            <div>
                                <p class="text-sm font-semibold text-ink">Ink &amp; Paper Editorial</p>
                                <p class="text-xs text-muted">Curated Daily Selection</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Featured Article --}}
    <section class="border-b border-border py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="mb-10 flex items-end justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">
                        Featured Story
                    </span>
                    <h2 class="mt-2 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Editor's Pick
                    </h2>
                </div>

                <a href="#latest-stories"
                    class="group hidden items-center gap-2 text-sm font-semibold text-muted transition hover:text-primary sm:inline-flex">
                    Explore stories
                    <span class="transition-transform group-hover:translate-x-1">
                        &rarr;
                    </span>
                </a>
            </div>

            @if ($featuredPost)
                <article class="group overflow-hidden rounded-2xl border border-border/80 bg-white transition duration-300 hover:border-primary/30 hover:shadow-2xl">
                    <div class="grid lg:grid-cols-12">

                        {{-- Cover --}}
                        <a href="{{ route('posts.show', $featuredPost->slug) }}"
                            class="relative block min-h-[320px] overflow-hidden bg-zinc-100 sm:min-h-[400px] lg:col-span-7 lg:min-h-[520px]">

                            @if ($featuredPost->cover_image)
                                <img src="{{ asset('storage/' . $featuredPost->cover_image) }}"
                                    alt="{{ $featuredPost->title }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                                <div class="flex h-full min-h-[320px] items-center justify-center bg-zinc-100 sm:min-h-[400px] lg:min-h-[520px]">
                                    <span class="font-serif text-8xl font-bold text-zinc-200">
                                        I&amp;P
                                    </span>
                                </div>
                            @endif

                            {{-- Featured Badge --}}
                            <div class="absolute top-5 left-5">
                                <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-ink/80 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-white shadow-lg backdrop-blur-md">
                                    <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                    Featured
                                </span>
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="flex flex-col justify-between p-8 sm:p-10 lg:col-span-5 lg:p-12">
                            <div>
                                {{-- Category --}}
                                @if ($featuredPost->category)
                                    <a href="{{ route('categories.show', $featuredPost->category->slug) }}"
                                        class="inline-block text-xs font-bold uppercase tracking-[0.18em] text-primary transition hover:opacity-80">
                                        {{ $featuredPost->category->name }}
                                    </a>
                                @endif

                                {{-- Title --}}
                                <h3 class="mt-4 font-serif text-2xl font-extrabold leading-tight text-ink sm:text-3xl lg:text-4xl">
                                    <a href="{{ route('posts.show', $featuredPost->slug) }}" class="transition hover:text-primary">
                                        {{ $featuredPost->title }}
                                    </a>
                                </h3>

                                {{-- Excerpt --}}
                                @if ($featuredPost->excerpt)
                                    <p class="mt-4 text-base leading-relaxed text-muted line-clamp-3 sm:text-lg">
                                        {{ $featuredPost->excerpt }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-8">
                                {{-- Author & Meta --}}
                                <div class="flex items-center gap-3.5 border-t border-border/80 pt-6">
                                    <x-avatar name="{{ $featuredPost->user->name }}" size="sm" />
                                    <div>
                                        <p class="text-sm font-semibold text-ink">
                                            {{ $featuredPost->user->name }}
                                        </p>
                                        <div class="mt-0.5 flex items-center gap-2 text-xs text-muted">
                                            <span>{{ $featuredPost->read_time }} min read</span>
                                            <span>•</span>
                                            <span>{{ $featuredPost->published_at?->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Read Article Link --}}
                                <a href="{{ route('posts.show', $featuredPost->slug) }}"
                                    class="group/link mt-6 inline-flex items-center gap-2 text-sm font-bold text-ink transition hover:text-primary">
                                    Read story
                                    <span class="transition-transform group-hover/link:translate-x-1">
                                        &rarr;
                                    </span>
                                </a>
                            </div>
                        </div>

                    </div>
                </article>
            @else
                <div class="rounded-2xl border border-dashed border-border bg-white p-16 text-center shadow-xs">
                    <p class="font-serif text-2xl font-bold text-ink">
                        No featured story yet.
                    </p>
                    <p class="mt-2 text-sm text-muted">
                        Published stories will appear here.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- Latest Stories --}}
    <section id="latest-stories" class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-end justify-between border-b border-border pb-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-primary">
                        Latest
                    </span>
                    <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Latest Stories
                    </h2>
                </div>
            </div>

            {{-- Posts --}}
            @if ($posts->count())
                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-card :post="$post" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($posts->hasPages())
                    <div class="mt-16 border-t border-border/60 pt-8">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="mt-12 rounded-2xl border border-dashed border-border bg-white p-16 text-center shadow-xs">
                    <h3 class="font-serif text-2xl font-bold text-ink">
                        No stories yet.
                    </h3>
                    <p class="mt-2 text-sm text-muted">
                        Published stories will appear here.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- Popular Categories --}}
    <section class="border-y border-border bg-white py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex flex-col gap-4 border-b border-border pb-8 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">
                        Explore by topic
                    </span>
                    <h2 class="mt-2 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Popular Categories
                    </h2>
                    <p class="mt-2 max-w-xl text-sm leading-relaxed text-muted">
                        Explore stories across the topics our readers are following most.
                    </p>
                </div>

                <a href="#"
                    class="group inline-flex items-center gap-2 text-sm font-semibold text-ink transition hover:text-primary">
                    View all topics
                    <span class="transition-transform group-hover:translate-x-1">
                        &rarr;
                    </span>
                </a>
            </div>

            {{-- Categories Grid --}}
            @if ($categories->count())
                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}"
                            class="group flex items-center justify-between rounded-xl border border-border/80 bg-paper p-6 transition-all duration-300 hover:-translate-y-1 hover:border-primary/30 hover:bg-white hover:shadow-md">

                            <div class="flex items-center gap-4">
                                {{-- Category Number --}}
                                <span class="font-serif text-2xl font-bold text-zinc-300 transition-colors group-hover:text-primary">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <div>
                                    <x-badge variant="primary" class="group-hover:bg-primary/10">
                                        {{ $category->name }}
                                    </x-badge>

                                    <p class="mt-1.5 text-xs font-medium text-muted">
                                        {{ $category->posts_count }}
                                        {{ $category->posts_count === 1 ? 'story' : 'stories' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Arrow --}}
                            <span class="text-lg text-muted transition-all duration-300 group-hover:translate-x-1.5 group-hover:text-primary">
                                &rarr;
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="mt-10 rounded-xl border border-dashed border-border p-12 text-center">
                    <p class="font-serif text-xl font-bold text-ink">
                        No categories yet.
                    </p>
                    <p class="mt-2 text-sm text-muted">
                        Categories will appear here once they are available.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="relative overflow-hidden border-b border-border bg-paper py-24 sm:py-32">
        <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-96 w-96 rounded-full bg-primary/5 blur-3xl"></div>

        <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="font-serif text-4xl font-extrabold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                Have something worth sharing?
            </h2>

            <p class="mt-6 text-lg leading-relaxed text-muted sm:text-xl">
                Join a growing community of thoughtful writers and readers. Publish your insights with elegance and simplicity.
            </p>

            <div class="mt-10 flex justify-center">
                <x-button class="px-8 py-4 text-base shadow-lg transition-transform hover:-translate-y-0.5">
                    Start Writing Today
                </x-button>
            </div>
        </div>
    </section>

@endsection