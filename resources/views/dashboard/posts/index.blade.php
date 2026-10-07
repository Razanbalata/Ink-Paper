@extends('layouts.dashboard')

@section('title', 'My Posts — Ink & Paper')

@section('dashboard-content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col gap-4 border-b border-border pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-primary">Author Space</span>
                <h1 class="mt-1 font-serif text-4xl font-extrabold text-ink sm:text-5xl">
                    My Posts
                </h1>
                <p class="mt-2 text-sm text-muted">
                    Manage your stories, drafts, and publication statuses.
                </p>
            </div>

            <a href="{{ route('posts.create') }}" class="shrink-0">
                <x-button>
                    + New Post
                </x-button>
            </a>
        </div>

        <!-- Navigation Tabs -->
        <div class="mt-8 flex flex-wrap gap-2 border-b border-border/60 pb-4">
            @php
                $currentStatus = request('status');
                $tabs = [
                    null => 'All',
                    'published' => 'Published',
                    'draft' => 'Drafts',
                    'archived' => 'Archived',
                ];
            @endphp

            @foreach ($tabs as $status => $label)
                <a href="{{ $status ? route('dashboard.posts', ['status' => $status]) : route('dashboard.posts') }}"
                    class="rounded-xl px-4 py-2 text-xs font-bold transition {{ $currentStatus === $status ? 'bg-primary text-white shadow-sm' : 'bg-white border border-border text-ink hover:bg-paper' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Posts List -->
        <div class="mt-8 space-y-4">
            @forelse($posts as $post)
                <div
                    class="group flex flex-col justify-between gap-4 rounded-2xl border border-border bg-white p-5 shadow-sm transition hover:border-primary/40 sm:flex-row sm:items-center">
                    <div class="space-y-1">
                        <div class="flex items-center gap-3">
                            <h2 class="font-serif text-xl font-bold text-ink transition group-hover:text-primary">
                                <a href="{{ route('dashboard.posts.show', $post) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                        </div>

                        <p class="line-clamp-2 text-sm text-muted">
                            {{ $post->excerpt }}
                        </p>

                        <div class="flex items-center gap-3 pt-2 text-xs text-slate-500">

                            {{-- Created Date --}}
                            <div class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span>Created on {{ $post->created_at->format('M d, Y') }}</span>
                            </div>

                            {{-- Separator Dot --}}
                            <span class="h-1 w-1 rounded-full bg-slate-300"></span>

                            {{-- Views Count --}}
                            <div class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M2.25 12s3.5-5.25 9.75-5.25S21.75 12 21.75 12 18.25 17.25 12 17.25 2.25 12 2.25 12Z" />
                                    <circle cx="12" cy="12" r="2.5" />
                                </svg>
                                <span>{{ number_format($post->views_count) }} views</span>
                            </div>

                        </div>

                    </div>

                    <!-- Actions & Status -->
                    <div class="flex items-center gap-4 shrink-0 border-t border-border/50 pt-3 sm:border-t-0 sm:pt-0">
                        @php
                            $badgeVariant = match ($post->status) {
                                'published' => 'primary',
                                'draft' => 'secondary',
                                'archived' => 'neutral',
                                default => 'neutral',
                            };
                        @endphp

                        <x-badge :variant="$badgeVariant">
                            {{ ucfirst($post->status) }}
                        </x-badge>

                        <a href="{{ route('posts.edit', $post) }}"
                            class="rounded-lg border border-border bg-white px-3 py-1.5 text-xs font-semibold text-ink transition hover:bg-paper">
                            Edit
                        </a>
                    </div>
                </div>

            @empty
                <!-- Empty State -->
                <div class="rounded-2xl border border-dashed border-border p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-xl font-bold text-ink">No posts found</h3>
                    <p class="mt-1 text-sm text-muted">Start writing your first story to share with the world.</p>
                    <div class="mt-6">
                        <a href="{{ route('posts.create') }}">
                            <x-button>
                                Create Post
                            </x-button>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="mt-10 border-t border-border pt-6">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
@endsection
