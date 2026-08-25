@extends('layouts.guest')

@section('title', 'Ink & Paper — Ideas Worth Reading')

@section('public-content')

    {{-- Hero Section --}}
    <section class="border-b border-border bg-paper relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">

                {{-- Hero Content --}}
                <div class="lg:col-span-7">
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-3.5 py-1.5 text-xs font-semibold tracking-wide text-primary">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary animate-pulse"></span>
                        A Place For Thoughtful Ideas
                    </div>

                    <h1
                        class="mt-6 font-serif text-5xl font-extrabold tracking-tight text-ink sm:text-6xl lg:text-7xl lg:leading-[1.08]">
                        Ideas worth <br class="hidden sm:inline" />
                        <span class="italic font-normal text-primary">reading &amp; sharing.</span>
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-muted sm:text-xl">
                        Discover curated stories, deep perspectives, and practical insights written by passionate creators
                        worldwide.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <x-button class="shadow-sm">
                            Start Writing
                        </x-button>

                        <x-button variant="secondary">
                            Explore Stories
                        </x-button>
                    </div>
                </div>

                {{-- Hero Editorial Quote Card --}}
                <div class="lg:col-span-5">
                    <div class="relative rounded-2xl border border-border bg-white p-8 shadow-sm">
                        <div
                            class="flex items-center justify-between text-xs font-semibold uppercase tracking-widest text-muted">
                            <span>Editor's Choice</span>
                            <span class="text-primary font-serif italic font-normal">Vol. 01</span>
                        </div>

                        <blockquote class="font-serif mt-6 text-xl leading-relaxed text-ink">
                            “Writing is not life itself, but is, I think, sometimes my way back to life.”
                        </blockquote>

                        <div class="mt-8 flex items-center gap-3 border-t border-border/60 pt-6">
                            <x-avatar name="Ink & Paper Editorial" size="sm" />
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
    <section class="border-b border-border py-20 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">
                        Featured Story
                    </span>

                    <h2 class="mt-2 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Editor's Pick
                    </h2>
                </div>

                <a href="#"
                    class="group hidden items-center gap-2 text-sm font-semibold text-muted transition hover:text-primary sm:inline-flex">
                    Explore stories
                    <span class="transition-transform group-hover:translate-x-1">
                        &rarr;
                    </span>
                </a>
            </div>


            @if ($featuredPost)

                <article
                    class="group overflow-hidden rounded-2xl border border-border bg-white transition duration-300 hover:shadow-xl">

                    <div class="grid lg:grid-cols-2">

                        {{-- Cover --}}
                        <a href="{{ route('posts.show', $featuredPost->slug) }}"
                            class="relative block min-h-[320px] overflow-hidden bg-zinc-100 sm:min-h-[400px] lg:min-h-[500px]">

                            @if ($featuredPost->cover_image)
                                <img src="{{ asset('storage/' . $featuredPost->cover_image) }}"
                                    alt="{{ $featuredPost->title }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            @else
                                <div
                                    class="flex h-full min-h-[320px] items-center justify-center bg-zinc-100 sm:min-h-[400px] lg:min-h-[500px]">
                                    <span class="font-serif text-8xl font-bold text-zinc-200">
                                        I&amp;P
                                    </span>
                                </div>
                            @endif


                            {{-- Featured Badge --}}
                            <div class="absolute left-5 top-5">
                                <span
                                    class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-ink/80 px-3.5 py-1.5 text-xs font-bold uppercase tracking-wider text-white backdrop-blur-sm">
                                    <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                    Featured
                                </span>
                            </div>

                        </a>


                        {{-- Content --}}
                        <div class="flex flex-col justify-center p-8 sm:p-10 lg:p-14">

                            {{-- Category --}}
                            @if ($featuredPost->category)
                                <a href="#"
                                    class="w-fit text-xs font-bold uppercase tracking-[0.18em] text-primary transition hover:opacity-70">
                                    {{ $featuredPost->category->name }}
                                </a>
                            @endif


                            {{-- Title --}}
                            <h3
                                class="mt-4 font-serif text-3xl font-extrabold leading-tight text-ink sm:text-4xl lg:text-5xl">
                                <a href="{{ route('posts.show', $featuredPost->slug) }}"
                                    class="transition hover:text-primary">
                                    {{ $featuredPost->title }}
                                </a>
                            </h3>


                            {{-- Excerpt --}}
                            @if ($featuredPost->excerpt)
                                <p class="mt-5 max-w-xl text-base leading-relaxed text-muted sm:text-lg">
                                    {{ $featuredPost->excerpt }}
                                </p>
                            @endif


                            {{-- Author --}}
                            <div class="mt-8 flex items-center gap-3 border-t border-border pt-6">

                                <x-avatar name="{{ $featuredPost->user->name }}" size="sm" />

                                <div>
                                    <p class="text-sm font-semibold text-ink">
                                        {{ $featuredPost->user->name }}
                                    </p>

                                    <div class="mt-0.5 flex items-center gap-2 text-xs text-muted">
                                        <span>
                                            {{ $featuredPost->read_time }} min read
                                        </span>

                                        <span>·</span>

                                        <span>
                                            {{ $featuredPost->published_at?->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>

                            </div>


                            {{-- Read Article --}}
                            <a href="{{ route('posts.show', $featuredPost->slug) }}"
                                class="group/link mt-8 inline-flex w-fit items-center gap-2 text-sm font-bold text-ink transition hover:text-primary">
                                Read story

                                <span class="transition-transform group-hover/link:translate-x-1">
                                    &rarr;
                                </span>
                            </a>

                        </div>

                    </div>

                </article>
            @else
                <div class="rounded-2xl border border-dashed border-border bg-white p-12 text-center">
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

                <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($posts as $post)
                        <x-card :post="$post" />
                    @endforeach

                </div>


                {{-- Pagination --}}
                @if ($posts->hasPages())
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="mt-10 rounded-2xl border border-dashed border-border bg-white p-12 text-center">

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
    <section class="border-y border-border bg-white py-20 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex flex-col gap-4 border-b border-border pb-6 sm:flex-row sm:items-end sm:justify-between">

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
                    class="group inline-flex w-fit items-center gap-2 text-sm font-semibold text-ink transition hover:text-primary">
                    View all topics

                    <span class="transition-transform group-hover:translate-x-1">
                        &rarr;
                    </span>
                </a>

            </div>


            {{-- Categories --}}
            @if ($categories->count())

                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($categories as $category)
                        <a href="#"
                            class="group flex items-center justify-between rounded-xl border border-border bg-paper p-5 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/30 hover:bg-primary/5 hover:shadow-sm">

                            <div class="flex items-center gap-4">

                                {{-- Category Number --}}
                                <span
                                    class="font-serif text-2xl font-bold text-zinc-300 transition-colors group-hover:text-primary">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>


                                <div>
                                    <h3 class="font-serif text-xl font-bold text-ink transition group-hover:text-primary">
                                        {{ $category->name }}
                                    </h3>

                                    <p class="mt-0.5 text-xs text-muted">
                                        {{ $category->posts_count }}
                                        {{ $category->posts_count === 1 ? 'story' : 'stories' }}
                                    </p>
                                </div>

                            </div>


                            {{-- Arrow --}}
                            <span
                                class="text-lg text-muted transition-all duration-200 group-hover:translate-x-1 group-hover:text-primary">
                                &rarr;
                            </span>

                        </a>
                    @endforeach

                </div>
            @else
                <div class="mt-8 rounded-xl border border-dashed border-border p-10 text-center">

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
    <section class="border-y border-border bg-white py-20">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="font-serif text-4xl font-extrabold tracking-tight text-ink sm:text-5xl">
                Have something worth sharing?
            </h2>

            <p class="mt-4 text-lg leading-relaxed text-muted">
                Join a growing community of thoughtful writers and readers. Publish your insights with elegance and
                simplicity.
            </p>

            <div class="mt-8 flex justify-center gap-4">
                <x-button class="px-8 py-3.5 text-base">
                    Start Writing Today
                </x-button>
            </div>
        </div>
    </section>

@endsection
