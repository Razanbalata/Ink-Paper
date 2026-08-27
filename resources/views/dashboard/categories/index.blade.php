@extends('layouts.dashboard')

@section('title', 'Categories — Ink & Paper')

@section('dashboard-content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col gap-4 border-b border-border pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-primary">Content Structure</span>
                <h1 class="mt-1 font-serif text-4xl font-extrabold text-ink sm:text-5xl">
                    Categories
                </h1>
                <p class="mt-2 text-sm text-muted">
                    Organize your stories, articles, and topics.
                </p>
            </div>

            <a href="{{ route('dashboard.categories.create') }}" class="shrink-0">
                <x-button>
                    + New Category
                </x-button>
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($categories as $category)
                <div class= 'rounded-2xl border border-border bg-white p-5 shadow-sm'>
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <h2 class="font-serif text-xl font-bold text-ink transition group-hover:text-primary">
                                {{ $category->name }}
                            </h2>

                            <x-badge variant="neutral">
                                {{ $category->posts_count ?? 0 }} posts
                            </x-badge>
                        </div>

                        <p class="mt-3 line-clamp-2 text-sm text-muted">
                            {{ $category->description ?? 'No description provided.' }}
                        </p>
                    </div>

                    <!-- Card Actions -->
                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-border/50 pt-4">
                        <a 
                            href="{{ route('dashboard.categories.edit', $category) }}" 
                            class="rounded-lg border border-border bg-white px-3 py-1.5 text-xs font-semibold text-ink transition hover:bg-paper"
                        >
                            Edit
                        </a>

                        <form 
                            method="POST" 
                            action="{{ route('dashboard.categories.destroy', $category) }}"
                            onsubmit="return confirm('Are you sure you want to delete this category?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button 
                                type="submit" 
                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full rounded-2xl border border-dashed border-border p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-xl font-bold text-ink">No categories found</h3>
                    <p class="mt-1 text-sm text-muted">Create your first category to group your posts effectively.</p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard.categories.create') }}">
                            <x-button>
                                Create Category
                            </x-button>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="mt-10 border-t border-border pt-6">
                {{ $categories->links() }}
            </div>
        @endif

    </div>
@endsection