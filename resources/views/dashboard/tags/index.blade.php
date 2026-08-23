@extends('layouts.dashboard')

@section('title', 'Tags — Ink & Paper')

@section('dashboard-content')
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col gap-4 border-b border-border pb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-primary">Taxonomy</span>
                <h1 class="mt-1 font-serif text-4xl font-extrabold text-ink sm:text-5xl">
                    Tags
                </h1>
                <p class="mt-2 text-sm text-muted">
                    Organize your stories with relevant topics and keywords.
                </p>
            </div>

            <a href="{{ route('dashboard.tags.create') }}" class="shrink-0">
                <x-button>
                    + New Tag
                </x-button>
            </a>
        </div>

        <!-- Tags Grid -->
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($tags as $tag)
                <x-card class="group flex flex-col justify-between transition hover:border-primary/40">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <h2 class="font-serif text-xl font-bold text-ink transition group-hover:text-primary">
                                #{{ $tag->name }}
                            </h2>

                            <x-badge variant="neutral">
                                {{ $tag->posts_count }} {{ Str::plural('post', $tag->posts_count) }}
                            </x-badge>
                        </div>

                        @if(!empty($tag->description))
                            <p class="mt-3 line-clamp-2 text-sm text-muted">
                                {{ $tag->description }}
                            </p>
                        @endif
                    </div>

                    <!-- Card Actions -->
                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-border/50 pt-4">
                        <a 
                            href="{{ route('dashboard.tags.edit', $tag) }}" 
                            class="rounded-lg border border-border bg-white px-3 py-1.5 text-xs font-semibold text-ink transition hover:bg-paper"
                        >
                            Edit
                        </a>

                        <form 
                            method="POST" 
                            action="{{ route('dashboard.tags.destroy', $tag) }}"
                            onsubmit="return confirm('Are you sure you want to delete this tag?');"
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
                </x-card>
            @empty
                <!-- Empty State -->
                <div class="col-span-full rounded-2xl border border-dashed border-border p-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-xl font-bold text-ink">No tags found</h3>
                    <p class="mt-1 text-sm text-muted">Add tags to help readers discover content by specific keywords.</p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard.tags.create') }}">
                            <x-button>
                                Create Tag
                            </x-button>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($tags->hasPages())
            <div class="mt-10 border-t border-border pt-6">
                {{ $tags->links() }}
            </div>
        @endif

    </div>
@endsection