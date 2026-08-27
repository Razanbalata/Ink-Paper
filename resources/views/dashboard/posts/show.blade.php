@extends('layouts.dashboard')

@section('title', $post->title . ' — Post Details')

@section('dashboard-content')
    <div class="mx-auto max-w-6xl space-y-10 py-6">

        {{-- Top Bar Navigation & Actions --}}
        <div class="flex flex-col gap-4 border-b border-border/60 pb-6 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('dashboard.posts') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-muted transition hover:text-ink">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Posts
            </a>

            <div class="flex items-center gap-3">
                @if ($post->status === 'published')
                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-xl border border-border bg-white px-4 py-2.5 text-xs font-semibold text-ink shadow-sm transition hover:bg-paper">
                        <svg class="h-4 w-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        View Public
                    </a>
                @endif

                <a href="{{ route('posts.edit', $post) }}"
                    class="rounded-xl border border-border bg-white px-4 py-2.5 text-xs font-semibold text-ink shadow-sm transition hover:bg-paper">
                    Edit
                </a>

                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                    onsubmit="return confirm('Are you sure you want to delete this article?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Article Header --}}
        <div class="space-y-6">
            <div class="flex flex-wrap items-center gap-3">
                @if ($post->category)
                    <x-badge variant="primary">
                        {{ $post->category->name }}
                    </x-badge>
                @endif

                @if ($post->status === 'published')
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200/60">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Published
                    </span>
                @elseif ($post->status === 'draft')
                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3.5 py-1 text-xs font-semibold text-amber-700 border border-amber-200/60">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        Draft
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 rounded-full bg-zinc-100 px-3.5 py-1 text-xs font-semibold text-zinc-600 border border-zinc-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-zinc-400"></span>
                        Archived
                    </span>
                @endif
            </div>

            <h1 class="font-serif text-4xl font-extrabold leading-snug tracking-tight text-ink sm:text-5xl">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p class="text-lg leading-relaxed text-muted max-w-3xl">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>

        {{-- Meta Stats Grid --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="rounded-2xl border border-border/80 bg-white p-6 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-widest text-muted">Created</span>
                <p class="mt-2 text-base font-semibold text-ink">
                    {{ $post->created_at->format('M d, Y') }}
                </p>
                <p class="mt-0.5 text-xs text-muted">At {{ $post->created_at->format('h:i A') }}</p>
            </div>

            <div class="rounded-2xl border border-border/80 bg-white p-6 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-widest text-muted">Published</span>
                <p class="mt-2 text-base font-semibold text-ink">
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                </p>
                <p class="mt-0.5 text-xs text-muted">
                    {{ $post->published_at ? $post->published_at->format('h:i A') : 'Draft status' }}
                </p>
            </div>

            <div class="rounded-2xl border border-border/80 bg-white p-6 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-widest text-muted">Reading Time</span>
                <p class="mt-2 text-base font-semibold text-ink">
                    {{ $post->read_time }} min read
                </p>
                <p class="mt-0.5 text-xs text-muted">Estimated time</p>
            </div>
        </div>

        {{-- Featured Image --}}
        @if ($post->cover_image)
            <div class="overflow-hidden rounded-2xl border border-border/80 bg-white shadow-sm">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="max-h-[500px] w-full object-cover">
            </div>
        @endif

        {{-- Article Body --}}
        <div class="rounded-2xl border border-border/80 bg-white p-8 sm:p-12 shadow-sm">
            <div class="prose prose-stone max-w-none font-serif text-lg leading-loose text-ink">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        {{-- Tags --}}
        @if ($post->tags->isNotEmpty())
            <div class="rounded-2xl border border-border/80 bg-white p-6 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-widest text-muted">Tags</span>
                <div class="mt-4 flex flex-wrap gap-2.5">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-xl border border-border bg-paper px-3.5 py-1.5 text-xs font-medium text-ink">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection