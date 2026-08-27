@extends('layouts.dashboard')

@section('title', 'Create Category — Ink & Paper')

@section('dashboard-content')
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        
        <!-- Navigation Link -->
        <a href="{{ route('dashboard.categories.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-muted hover:text-ink transition mb-6">
            &larr; Back to Categories
        </a>

        <!-- Header -->
        <div class="border-b border-border pb-6">
            <h1 class="font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                Create Category
            </h1>
            <p class="mt-2 text-sm text-muted">
                Add a new taxonomy to group related posts on your blog.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('dashboard.categories.store') }}" class="mt-8 space-y-6">
            @csrf

            <div class="space-y-6">
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-ink">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="e.g. Technology, Lifestyle, Design"
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                        required
                    >
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
                        placeholder="Brief summary of what kind of stories belong in this category..."
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard.categories.index') }}" class="text-sm font-semibold text-muted hover:text-ink transition">
                    Cancel
                </a>
                <x-button type="submit">
                    Save Category
                </x-button>
            </div>
        </form>

    </div>
@endsection