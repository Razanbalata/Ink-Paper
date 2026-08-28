@extends('layouts.dashboard')

@section('title', $post->title . ' — Post Details')

@section('dashboard-content')
    <div class="mx-auto max-w-5xl space-y-8 py-8 px-4 sm:px-6">

        {{-- Top Navigation & Action Bar --}}
        <div class="flex flex-col gap-4 border-b border-slate-200/80 pb-6 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('dashboard.posts') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-slate-900 group">
                <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Posts
            </a>

            <div class="flex flex-wrap items-center gap-2.5">
                @if ($post->status === 'published')
                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        View Public
                    </a>
                @endif

                <a href="{{ route('posts.edit', $post) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                    onsubmit="return confirm('Are you sure you want to delete this article?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50/50 px-4 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100 hover:text-rose-700">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-2.5">
                @if ($post->category)
                    <x-badge variant="primary">
                        {{ $post->category->name }}
                    </x-badge>
                @endif

                @if ($post->status === 'published')
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-0.5 text-xs font-semibold text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Published
                    </span>
                @elseif ($post->status === 'draft')
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-3 py-0.5 text-xs font-semibold text-amber-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        Draft
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-3 py-0.5 text-xs font-semibold text-slate-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                        Archived
                    </span>
                @endif
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl leading-tight">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p class="text-lg leading-relaxed text-slate-600 max-w-3xl">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>

        {{-- Meta Stats Grid --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Created</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->created_at->format('M d, Y') }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">At {{ $post->created_at->format('h:i A') }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Published</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $post->published_at ? $post->published_at->format('h:i A') : 'Draft status' }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Reading Time</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->read_time }} min read
                </p>
                <p class="text-xs text-slate-500 mt-0.5">Estimated time</p>
            </div>
        </div>

        {{-- Featured Cover Image --}}
        @if ($post->cover_image)
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50 shadow-xs">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="max-h-[450px] w-full object-cover">
            </div>
        @endif

        {{-- Article Body --}}
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-xs">
            <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed text-base sm:text-lg">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        {{-- Tags Section --}}
        @if ($post->tags->isNotEmpty())
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tags</span>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-700 transition hover:bg-slate-100">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Comments Container --}}
        <div class="rounded-2xl border border-slate-200/80 bg-white shadow-xs overflow-hidden">
            {{-- Header --}}
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50/50">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Discussion</span>
                    <h2 class="text-xl font-bold text-slate-900 mt-0.5">Comments</h2>
                </div>
                <span class="rounded-full bg-slate-200/60 px-3 py-1 text-xs font-semibold text-slate-700">
                    {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
                </span>
            </div>

            {{-- Comments List --}}
            <div class="divide-y divide-slate-100">
                @forelse ($post->comments as $comment)
                    <div class="p-6 transition hover:bg-slate-50/30">
                        <div class="flex items-start gap-4">
                            <x-avatar :name="$comment->user->name ?? 'Anonymous'" size="md" />

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">
                                            {{ $comment->user->name ?? 'Anonymous' }}
                                        </p>
                                        <p class="text-xs text-slate-400">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    @if (auth()->id() === $comment->user_id)
                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-xs font-medium text-slate-400 hover:text-rose-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <p class="mt-3 text-sm leading-relaxed text-slate-700">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <p class="mt-3 font-semibold text-slate-900">No comments yet</p>
                        <p class="mt-1 text-sm text-slate-500">Your article hasn't received any comments yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection