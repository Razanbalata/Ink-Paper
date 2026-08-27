@extends('layouts.guest')

@section('title', 'All Posts — Ink & Paper')

@section('public-content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="flex flex-col gap-4 border-b border-border pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-primary">Discover &amp; Read</span>
                <h1 class="mt-1 font-serif text-4xl font-extrabold text-ink sm:text-5xl">
                    All Articles
                </h1>
                <p class="mt-2 text-base text-muted">
                    Explore high-quality thoughts, stories, and insights from our community.
                </p>
            </div>

            <a href="{{ route('posts.create') }}" class="shrink-0">
                <x-button>
                    Create Post
                </x-button>
            </a>
        </div>

        <!-- Posts Grid -->
        <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($posts as $post)
                <x-card :post="$post"
                    class="group flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div>
                        <!-- Category Badge -->
                        <div class="flex items-center justify-between">
                            @if ($post->category)
                                <x-badge variant="primary">
                                    {{ $post->category->name }}
                                </x-badge>
                            @else
                                <x-badge>Uncategorized</x-badge>
                            @endif

                            <span class="text-xs font-medium text-muted">
                                {{ $post->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        <!-- Post Title & Excerpt -->
                        <div class="mt-4">
                            <h2
                                class="font-serif text-2xl font-bold leading-snug text-ink transition group-hover:text-primary">
                                <a href="{{ route('posts.show', $post) }}" class="focus:outline-none">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-muted">
                                {{ $post->excerpt }}
                            </p>
                        </div>
                    </div>

                    <!-- Author Info Footer -->
                    <div class="mt-8 flex items-center justify-between border-t border-border/50 pt-4">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$post->user->name ?? 'Anonymous'" size="sm" />
                            <div>
                                <a href="{{ route('authors.show', $post->user) }}"
                                    class="text-sm font-semibold text-ink transition hover:text-primary">
                                    {{ $post->user->name ?? 'Anonymous' }}
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('posts.show', $post) }}"
                            class="text-xs font-semibold text-primary transition hover:underline">
                            Read &rarr;
                        </a>
                    </div>
                </x-card>
            @empty
                <!-- Empty State -->
                <div class="col-span-full rounded-2xl border border-dashed border-border p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6" />
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-xl font-bold text-ink">No posts found</h3>
                    <p class="mt-2 text-sm text-muted">Be the first one to share an article with our community.</p>
                    <div class="mt-6">
                        <a href="{{ route('posts.create') }}">
                            <x-button>
                                Write a Post
                            </x-button>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="mt-12 border-t border-border pt-6">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
@endsection
