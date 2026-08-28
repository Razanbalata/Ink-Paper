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


        {{-- Back --}}
        <div class="mt-10 border-t border-border pt-6">

            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:gap-3">
                ← Back to Ink & Paper
            </a>

        </div>

    </article>

@endsection
