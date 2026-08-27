@extends('layouts.dashboard')

@section('title', 'Dashboard — Ink & Paper')

@section('dashboard-content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        
        <!-- Welcome Banner -->
        <div class="flex flex-col gap-4 border-b border-border pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-primary">Overview</span>
                <h1 class="mt-1 font-serif text-4xl font-extrabold text-ink sm:text-5xl">
                    Welcome back, {{ auth()->user()->name }}
                </h1>
                <p class="mt-2 text-sm text-muted">
                    Manage your stories and track your publishing activity.
                </p>
            </div>

            <a href="{{ route('posts.create') }}" class="shrink-0">
                <x-button>
                    Write a new story
                </x-button>
            </a>
        </div>

        <!-- Statistics Grid -->
        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:gap-6">
            <div class="flex flex-col justify-between rounded-2xl border border-border bg-white p-5 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-muted">Total Posts</span>
                <strong class="mt-3 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                    {{ $stats['total'] }}
                </strong>
            </div>

            <div class="flex flex-col justify-between rounded-2xl border border-border bg-white p-5 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Published</span>
                <strong class="mt-3 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                    {{ $stats['published'] }}
                </strong>
            </div>

            <div class="flex flex-col justify-between rounded-2xl border border-border bg-white p-5 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Drafts</span>
                <strong class="mt-3 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                    {{ $stats['drafts'] }}
                </strong>
            </div>

            <div class="flex flex-col justify-between rounded-2xl border border-border bg-white p-5 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Archived</span>
                <strong class="mt-3 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                    {{ $stats['archived'] }}
                </strong>
            </div>
        </div>

        <!-- Recent Posts Section -->
        <div class="mt-12">
            <div class="flex items-center justify-between border-b border-border pb-4">
                <h2 class="font-serif text-2xl font-bold text-ink">
                    Recent Posts
                </h2>

                <a href="{{ route('dashboard.posts') }}" class="text-xs font-bold uppercase tracking-wider text-primary hover:underline">
                    View all &rarr;
                </a>
            </div>

            <div class="mt-6 space-y-4">
                @forelse($recentPosts as $post)
                    <div class="group flex flex-col justify-between gap-4 rounded-2xl border border-border bg-white p-5 shadow-sm transition hover:border-primary/40 sm:flex-row sm:items-center">
                        <div class="space-y-1">
                            <h3 class="font-serif text-lg font-bold text-ink transition group-hover:text-primary">
                                <a href="{{ route('dashboard.posts.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="line-clamp-1 text-sm text-muted">
                                {{ $post->excerpt }}
                            </p>
                        </div>

                        <div class="flex items-center gap-4 shrink-0 border-t border-border/50 pt-3 sm:border-t-0 sm:pt-0">
                            @php
                                $badgeVariant = match($post->status) {
                                    'published' => 'primary',
                                    'draft' => 'secondary',
                                    'archived' => 'neutral',
                                    default => 'neutral'
                                };
                            @endphp

                            <x-badge :variant="$badgeVariant">
                                {{ ucfirst($post->status) }}
                            </x-badge>

                            <a href="{{ route('posts.edit', $post) }}" class="rounded-lg border border-border bg-white px-3 py-1.5 text-xs font-semibold text-ink transition hover:bg-paper">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-border p-8 text-center">
                        <p class="text-sm text-muted">You haven't written any posts yet.</p>
                        <a href="{{ route('posts.create') }}" class="mt-3 inline-block text-xs font-bold text-primary hover:underline">
                            Write your first story &rarr;
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection