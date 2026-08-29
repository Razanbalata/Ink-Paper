@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen flex-col bg-paper">

        {{-- Admin & Dashboard Header --}}
        <header class="sticky top-0 z-50 border-b border-border bg-white shadow-sm">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

                <div class="flex items-center gap-8">
                    <!-- Brand Logo -->
                    <a href="{{ route('dashboard') }}" class="font-serif text-xl font-extrabold tracking-tight text-ink">
                        Ink <span class="font-normal text-primary">&amp;</span> Paper <span
                            class="ml-1 rounded-md bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary">Studio</span>
                    </a>

                    <!-- Dashboard Nav Links -->
                    <nav class="hidden items-center gap-1 md:flex">
                        <a href="{{ route('dashboard') }}"
                            class="rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-paper text-primary' : 'text-muted hover:text-ink' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('dashboard.posts') }}"
                            class="rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard.posts*') ? 'bg-paper text-primary' : 'text-muted hover:text-ink' }}">
                            My Posts
                        </a>

                        <a href="{{ route('dashboard.categories.index') }}"
                            class="rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard.categories*') ? 'bg-paper text-primary' : 'text-muted hover:text-ink' }}">
                            Categories
                        </a>
                        <a href="{{ route('dashboard.tags.index') }}"
                            class="rounded-lg px-3 py-2 text-sm font-semibold transition {{ request()->routeIs('dashboard.tags*') ? 'bg-paper text-primary' : 'text-muted hover:text-ink' }}">
                            Tags

                        </a>
                    </nav>
                </div>

                <!-- User Profile & Action -->
                <div class="flex items-center gap-4">

                    {{-- Notifications --}}
                    <x-notification-dropdown />
                    <a href="{{ route('posts.create') }}" class="hidden sm:block">
                        <x-button>
                            + New Story
                        </x-button>
                    </a>

                    <div class="flex items-center gap-3 border-l border-border pl-4">
                        <x-avatar :name="auth()->user()->name" size="sm" />
                        <span class="text-sm font-bold text-ink hidden sm:inline-block">
                            {{ auth()->user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-sm font-semibold text-muted transition hover:text-red-600 focus:outline-none">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </header>

        {{-- Main Dashboard Content Area --}}
        <main class="flex-1">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                    <div
                        class="flex items-center gap-3 rounded-xl border border-primary/20 bg-primary/10 p-4 text-sm font-medium text-primary">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @yield('dashboard-content')

        </main>

    </div>
@endsection
