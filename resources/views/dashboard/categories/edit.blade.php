@extends('layouts.dashboard')

@section('title', 'Edit Category — Ink & Paper')

@section('dashboard-content')
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        
        <!-- Navigation Link -->
        <a href="{{ route('dashboard.categories.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-muted hover:text-ink transition mb-6">
            &larr; Back to Categories
        </a>

        <!-- Header -->
        <div class="border-b border-border pb-6">
            <h1 class="font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                Edit Category
            </h1>
            <p class="mt-2 text-sm text-muted">
                Update category details and information.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('dashboard.categories.update', $category) }}" class="mt-8 space-y-6">
            @csrf
            @method('PUT')

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
                        value="{{ old('name', $category->name) }}" 
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
                        class="mt-2 w-full rounded-xl border border-border bg-white px-4 py-3 text-sm text-ink outline-none transition focus:border-primary focus:ring-1 focus:ring-primary"
                    >{{ old('description', $category->description) }}</textarea>
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
                    Update Category
                </x-button>
            </div>
        </form>

    </div>
@endsection