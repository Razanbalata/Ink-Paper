@extends('layouts.dashboard')

@section('title', 'Post Details')

@section('content')

    <div class="mx-auto max-w-6xl space-y-8">

        {{-- Header --}}
        <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">

            <div>

                {{-- Status --}}
                <div class="flex flex-wrap items-center gap-3">

                    @if ($post->category)
                        <x-badge variant="primary">
                            {{ $post->category->name }}
                        </x-badge>
                    @endif


                    @if ($post->status === 'published')
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            Published
                        </span>
                    @elseif ($post->status === 'draft')
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                            Draft
                        </span>
                    @else
                        <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-600">
                            Archived
                        </span>
                    @endif

                </div>


                {{-- Title --}}
                <h1 class="mt-4 font-serif text-4xl font-extrabold leading-tight text-ink">
                    {{ $post->title }}
                </h1>


                {{-- Excerpt --}}
                @if ($post->excerpt)
                    <p class="mt-3 max-w-3xl text-muted">
                        {{ $post->excerpt }}
                    </p>
                @endif

            </div>


            {{-- Actions --}}
            <div class="flex shrink-0 items-center gap-3">

                <a href="{{ route('posts.edit', $post) }}"
                    class="rounded-xl border border-border bg-white px-4 py-2 text-sm font-semibold text-ink shadow-sm transition hover:bg-paper">
                    Edit Article
                </a>


                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                    onsubmit="return confirm('Are you sure you want to delete this article?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                        Delete
                    </button>

                </form>

            </div>

        </div>


        {{-- Meta Information --}}
        <div class="grid gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-border bg-white p-5">

                <p class="text-xs font-bold uppercase tracking-wider text-muted">
                    Created
                </p>

                <p class="mt-2 text-sm font-semibold text-ink">
                    {{ $post->created_at->format('F d, Y') }}
                </p>

            </div>


            <div class="rounded-2xl border border-border bg-white p-5">

                <p class="text-xs font-bold uppercase tracking-wider text-muted">
                    Published
                </p>

                <p class="mt-2 text-sm font-semibold text-ink">

                    {{ $post->published_at ? $post->published_at->format('F d, Y') : 'Not published' }}

                </p>

            </div>


            <div class="rounded-2xl border border-border bg-white p-5">

                <p class="text-xs font-bold uppercase tracking-wider text-muted">
                    Reading Time
                </p>

                <p class="mt-2 text-sm font-semibold text-ink">
                    {{ $post->read_time }} min
                </p>

            </div>

        </div>


        {{-- Cover --}}
        @if ($post->cover_image)
            <div class="overflow-hidden rounded-2xl border border-border bg-white">

                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="max-h-[500px] w-full object-cover">

            </div>
        @endif


        {{-- Content --}}
        <div class="rounded-2xl border border-border bg-white p-6 shadow-sm sm:p-10">

            <div class="mb-6 border-b border-border pb-4">

                <h2 class="font-serif text-2xl font-bold text-ink">
                    Article Content
                </h2>

            </div>


            <div class="prose prose-stone max-w-none font-serif text-lg leading-relaxed text-ink">

                {!! nl2br(e($post->content)) !!}

            </div>

        </div>


        {{-- Tags --}}
        @if ($post->tags->isNotEmpty())

            <div class="rounded-2xl border border-border bg-white p-6">

                <p class="text-xs font-bold uppercase tracking-wider text-muted">
                    Tags
                </p>

                <div class="mt-4 flex flex-wrap gap-2">

                    @foreach ($post->tags as $tag)
                        <span class="rounded-lg border border-border bg-paper px-3 py-1.5 text-xs font-medium text-ink">
                            #{{ $tag->name }}
                        </span>
                    @endforeach

                </div>

            </div>

        @endif


        {{-- Back --}}
        <div>

            <a href="{{ route('dashboard.posts') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:gap-3">
                ← Back to My Posts
            </a>

        </div>

    </div>

@endsection
