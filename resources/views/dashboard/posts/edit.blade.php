@extends('layouts.app')

@section('title', 'Edit Post — Ink & Paper')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="border-b border-border pb-6">
            <span class="text-xs font-bold uppercase tracking-widest text-primary">Editor Mode</span>
            <h1 class="mt-1 font-serif text-4xl font-extrabold text-ink sm:text-5xl">
                Edit Article
            </h1>
        </div>

        <!-- Form Container -->
        <div class="mt-10 rounded-2xl border border-border bg-white p-6 sm:p-10 shadow-sm">
            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-posts.post-form :post="$post" :categories="$categories" :tags="$tags" />

                <div class="mt-8 flex items-center justify-end gap-4 border-t border-border/60 pt-6">
                    <a href="{{ route('dashboard.posts', $post) }}"
                        class="text-sm font-semibold text-muted transition hover:text-ink">
                        Cancel
                    </a>
                    <x-button type="submit">
                        Update Post
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
