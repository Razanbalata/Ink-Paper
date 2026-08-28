@extends('layouts.guest')

@section('title', 'Ink & Paper — Ideas Worth Reading')

@section('public-content')

    {{-- Hero Section --}}
    <section class="relative overflow-hidden border-b border-border bg-paper py-24 sm:py-32">
        {{-- Ambient Glows --}}
        <div class="pointer-events-none absolute -top-32 -left-32 h-96 w-96 rounded-full bg-primary/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-primary/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">

                {{-- Hero Content --}}
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-3.5 py-1.5 text-xs font-semibold tracking-wide text-primary shadow-xs">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-primary"></span>
                        </span>
                        A Place For Thoughtful Ideas
                    </div>

                    <h1 class="mt-6 font-serif text-4xl font-extrabold tracking-tight text-ink sm:text-6xl lg:text-7xl lg:leading-[1.1]">
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
                    <div class="relative rounded-2xl border border-border/80 bg-white/70 p-8 shadow-sm backdrop-blur-md transition duration-300 hover:border-primary/40 hover:shadow-md sm:p-10">
                        <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-widest text-muted">
                            <span class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-primary"></span>
                                Editor's Choice
                            </span>
                            <span class="font-serif italic text-primary">Vol. 01</span>
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
    @if ($featuredPost)
        <section class="border-b border-border bg-white py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                {{-- Section Header --}}
                <div class="mb-8 flex items-end justify-between border-b border-border pb-5">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-primary">
                            Featured
                        </span>
                        <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                            Editor's Pick
                        </h2>
                    </div>

                    <a href="{{ route('posts.index') }}"
                        class="hidden items-center gap-1 text-sm font-semibold text-ink transition hover:text-primary sm:inline-flex">
                        View all stories
                        <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>

                {{-- Featured Card --}}
                <a href="{{ route('posts.show', $featuredPost) }}"
                    class="group grid overflow-hidden rounded-2xl border border-border bg-paper transition duration-300 hover:-translate-y-1 hover:border-primary/30 hover:shadow-xl lg:grid-cols-12 lg:items-center">

                    {{-- Cover Image Container (تم ضبط الارتفاع بحد أقصى مريح) --}}
                    <div class="relative h-64 w-full overflow-hidden bg-zinc-100 sm:h-80 lg:col-span-6 lg:h-[360px]">
                        @if ($featuredPost->cover_image)
                            <img src="{{ asset('storage/' . $featuredPost->cover_image) }}" alt="{{ $featuredPost->title }}"
                                class="h-full w-full object-cover object-center transition duration-700 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-zinc-100">
                                <span class="font-serif text-6xl font-bold text-zinc-300">I&amp;P</span>
                            </div>
                        @endif

                        @if ($featuredPost->category)
                            <div class="absolute top-4 left-4 z-10">
                                <x-badge variant="primary">
                                    {{ $featuredPost->category->name }}
                                </x-badge>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col justify-between p-6 sm:p-8 lg:col-span-6 lg:p-10">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-widest text-muted">
                                Latest published article
                            </span>

                            <h3 class="mt-3 font-serif text-2xl font-extrabold leading-tight text-ink transition group-hover:text-primary sm:text-3xl">
                                {{ $featuredPost->title }}
                            </h3>

                            @if ($featuredPost->excerpt)
                                <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted sm:text-base">
                                    {{ $featuredPost->excerpt }}
                                </p>
                            @endif
                        </div>

                        {{-- Author & Link --}}
                        <div class="mt-6 border-t border-border/80 pt-5">
                            <div class="flex items-center gap-3">
                                <x-avatar :name="$featuredPost->user->name ?? 'Anonymous'" size="sm" />
                                <div>
                                    <p class="text-sm font-semibold text-ink">
                                        {{ $featuredPost->user->name ?? 'Anonymous' }}
                                    </p>
                                    <p class="text-xs text-muted">
                                        {{ $featuredPost->published_at?->format('F d, Y') }} · {{ $featuredPost->read_time }} min read
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 flex items-center gap-2 text-sm font-bold text-primary">
                                <span>Read article</span>
                                <span class="transition-transform duration-200 group-hover:translate-x-1">&rarr;</span>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </section>
    @endif

    {{-- Latest Stories --}}
    <section class="py-20 sm:py-28">
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

            {{-- Posts Grid --}}
            <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <a href="{{ route('posts.show', $post) }}" class="group block h-full">
                        <div class="flex h-full flex-col justify-between overflow-hidden rounded-xl border border-border bg-white p-5 transition duration-300 hover:-translate-y-1 hover:border-primary/30 hover:shadow-md">
                            <div>
                                {{-- Cover Image Container --}}
                                <div class="relative h-48 w-full overflow-hidden rounded-lg bg-zinc-100 sm:h-52">
                                    @if ($post->cover_image)
                                        <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                                            class="h-full w-full object-cover object-center transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-zinc-100">
                                            <span class="font-serif text-4xl font-bold text-zinc-300 transition-transform duration-300 group-hover:scale-110">
                                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>
                                    @endif

                                    @if ($post->category)
                                        <div class="absolute top-3 left-3 z-10">
                                            <x-badge variant="primary">
                                                {{ $post->category->name }}
                                            </x-badge>
                                        </div>
                                    @endif
                                </div>

                                {{-- Text Content --}}
                                <div class="mt-5">
                                    <h3 class="font-serif text-xl font-bold leading-snug text-ink transition group-hover:text-primary">
                                        {{ $post->title }}
                                    </h3>

                                    @if ($post->excerpt)
                                        <p class="mt-2.5 line-clamp-2 text-sm leading-relaxed text-muted">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Card Footer / Meta --}}
                            <div class="mt-6 flex items-center justify-between border-t border-border/50 pt-4">
                                <div class="flex items-center gap-2.5">
                                    <x-avatar :name="$post->user->name ?? 'Anonymous'" size="sm" />
                                    <div>
                                        <p class="text-xs font-semibold text-ink">
                                            {{ $post->user->name ?? 'Anonymous' }}
                                        </p>
                                        <p class="text-[11px] text-muted">
                                            {{ $post->read_time }} min read
                                        </p>
                                    </div>
                                </div>

                                <span class="text-xs font-medium text-muted">
                                    {{ $post->published_at?->format('M d') }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-border py-16 text-center">
                        <p class="font-serif text-xl text-muted">
                            No stories published yet.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
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
                    <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Popular Categories
                    </h2>
                    <p class="mt-2 max-w-xl text-sm leading-relaxed text-muted">
                        Explore stories across the topics our readers are following most.
                    </p>
                </div>

                <a href="#" class="group inline-flex items-center gap-2 text-sm font-semibold text-ink transition hover:text-primary">
                    View all topics
                    <span class="transition-transform duration-200 group-hover:translate-x-1">&rarr;</span>
                </a>
            </div>

            {{-- Categories Grid --}}
            @if ($categories->count())
                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($categories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}"
                            class="group flex items-center justify-between rounded-xl border border-border bg-paper p-6 transition duration-300 hover:-translate-y-1 hover:border-primary/40 hover:bg-white hover:shadow-md">

                            <div class="flex items-center gap-4">
                                <span class="font-serif text-2xl font-bold text-zinc-300 transition-colors duration-300 group-hover:text-primary">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <div>
                                    <x-badge variant="primary" class="group-hover:bg-primary/10">
                                        {{ $category->name }}
                                    </x-badge>
                                    <p class="mt-1.5 text-xs font-medium text-muted">
                                        {{ $category->posts_count }} {{ $category->posts_count === 1 ? 'story' : 'stories' }}
                                    </p>
                                </div>
                            </div>

                            <span class="text-lg text-muted transition-all duration-300 group-hover:translate-x-1 group-hover:text-primary">
                                &rarr;
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="mt-10 rounded-2xl border border-dashed border-border p-12 text-center">
                    <p class="font-serif text-xl font-bold text-ink">
                        No categories yet.
                    </p>
                    <p class="mt-1 text-sm text-muted">
                        Categories will appear here once they are available.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="relative overflow-hidden border-b border-border bg-paper py-24 sm:py-32">
        <div class="pointer-events-none absolute top-1/2 left-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="font-serif text-4xl font-extrabold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                Have something worth sharing?
            </h2>

            <p class="mt-6 text-lg leading-relaxed text-muted sm:text-xl">
                Join a growing community of thoughtful writers and readers. Publish your insights with elegance and simplicity.
            </p>

            <div class="mt-10 flex justify-center">
                <x-button class="px-8 py-3.5 text-base shadow-md transition-transform hover:-translate-y-0.5">
                    Start Writing Today
                </x-button>
            </div>
        </div>
    </section>

@endsection