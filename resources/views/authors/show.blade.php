@extends('layouts.guest')

@section('title', $user->name . ' — Ink & Paper')

@section('public-content')

    {{-- Author Header --}}
    <section class="border-b border-border bg-paper">

        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">

            <div class="flex flex-col items-center gap-6 text-center sm:flex-row sm:items-start sm:text-left">

                {{-- Avatar --}}
                <div class="shrink-0">
                    <x-avatar :name="$user->name" size="lg" />
                </div>

                {{-- Author Info --}}
                <div class="max-w-2xl">

                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">
                        Author
                    </span>

                    <h1 class="mt-3 font-serif text-4xl font-extrabold tracking-tight text-ink sm:text-5xl">
                        {{ $user->name }}
                    </h1>

                    @if ($user->bio)
                        <p class="mt-4 text-lg leading-relaxed text-muted">
                            {{ $user->bio }}
                        </p>
                    @else
                        <p class="mt-4 text-lg leading-relaxed text-muted">
                            Writer and contributor at Ink &amp; Paper.
                        </p>
                    @endif

                </div>

            </div>

        </div>

    </section>


    {{-- Author Posts --}}
    <section class="py-16 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex items-end justify-between border-b border-border pb-6">

                <div>

                    <span class="text-xs font-bold uppercase tracking-widest text-primary">
                        Published
                    </span>

                    <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Stories by {{ $user->name }}
                    </h2>

                </div>

                <span class="hidden text-sm text-muted sm:block">
                    {{ $posts->total() }}
                    {{ Str::plural('story', $posts->total()) }}
                </span>

            </div>


            @if ($posts->count())

                {{-- Posts Grid --}}
                <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($posts as $post)
                        <x-card :post="$post"
                            class="group flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md">

                            <div>

                                {{-- Cover --}}
                                <a href="{{ route('posts.show', $post->slug) }}" class="block">

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

                                        {{-- Category --}}
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

                                    <x-avatar :name="$user->name" size="sm" />

                                    <div>

                                        <p class="text-sm font-semibold text-ink">
                                            {{ $user->name }}
                                        </p>

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
                {{-- Empty State --}}
                <div class="mt-10 rounded-2xl border border-dashed border-border bg-white px-6 py-16 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary/10">

                        <span class="font-serif text-2xl font-bold text-primary">
                            ✦
                        </span>

                    </div>

                    <h3 class="mt-5 font-serif text-2xl font-bold text-ink">
                        No published stories yet
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-muted">
                        {{ $user->name }} hasn't published any stories yet.
                    </p>

                    <a href="{{ route('home') }}"
                        class="mt-6 inline-flex items-center text-sm font-semibold text-primary hover:underline">
                        ← Back to Home
                    </a>

                </div>

            @endif

        </div>

    </section>

@endsection
