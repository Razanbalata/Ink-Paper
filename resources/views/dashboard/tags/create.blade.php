@extends('layouts.dashboard')

@section('title', 'Create Tag — Ink & Paper')

@section('dashboard-content')
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        
        <!-- Navigation Link -->
        <a href="{{ route('dashboard.tags.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-muted hover:text-ink transition mb-6">
            &larr; Back to Tags
        </a>

        <!-- Header -->
        <div class="border-b border-border pb-6">
            <h1 class="font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                Create Tag
            </h1>
            <p class="mt-2 text-sm text-muted">
                Add a new tag to label and connect related posts across your blog.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('dashboard.tags.store') }}" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-6">
                <!-- Tag Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-ink">
                        Tag Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-bold text-muted">#</span>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="laravel, design, tutorial"
                            class="w-full rounded-xl border border-border bg-white py-3 pl-8 pr-4 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                            required
                        >
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-ink">
                        Description
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4" 
                        placeholder="Brief overview of what this tag represents..."
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard.tags.index') }}" class="text-sm font-semibold text-muted hover:text-ink transition">
                    Cancel
                </a>
                <x-button type="submit">
                    Create Tag
                </x-button>
            </div>
        </form>

    </div>
@endsection