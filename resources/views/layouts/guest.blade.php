@extends('layouts.app')

@section('content')
    <div id="notification-toast-container"
        class="fixed right-5 top-20 z-[100] flex w-[calc(100%-2.5rem)] max-w-sm flex-col gap-3">
    </div>
    <div class="flex min-h-screen flex-col">

        {{-- Public Navbar --}}
        <nav class="sticky top-0 z-50 border-b border-border bg-paper/90 backdrop-blur-md">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="shrink-0 font-serif text-2xl font-extrabold tracking-tight text-ink">
                    Ink <span class="font-normal text-primary">&amp;</span> Paper
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-ink transition hover:text-primary">
                        Home
                    </a>

                    <a href="{{ route('posts.index') }}" class="text-sm font-medium text-muted transition hover:text-ink">
                        Explore
                    </a>

                    <a href="{{ route('search') }}"
                        class="inline-flex items-center gap-2 text-sm font-medium text-muted transition hover:text-ink">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                        Search
                    </a>
                </div>

                {{-- Desktop Actions --}}
                <div class="hidden items-center gap-4 md:flex">
                    @auth

                        {{-- Notifications --}}
                        <x-notification-dropdown />

                        {{-- Write --}}
                        <a href="{{ route('posts.create') }}"
                            class="text-sm font-semibold text-muted transition hover:text-ink">
                            Write
                        </a>

                        {{-- Dashboard & Profile --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <x-avatar :name="auth()->user()->name" size="sm" />
                            <span class="text-sm font-semibold text-ink">
                                {{ auth()->user()->name }}
                            </span>
                        </a>
                    @else
                        {{-- Sign In --}}
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-muted transition hover:text-ink">
                            Sign In
                        </a>

                        {{-- Get Started --}}
                        <a href="{{ route('register') }}">
                            <x-button>
                                Get Started
                            </x-button>
                        </a>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <button type="button" id="mobile-menu-button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-border text-ink transition hover:bg-white md:hidden"
                    aria-label="Open menu" aria-expanded="false">
                    <svg id="menu-open-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg id="menu-close-icon" class="hidden h-5 w-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="1.8" d="M6 6l12 12M6 18L18 6" />
                    </svg>
                </button>

            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden border-t border-border bg-paper md:hidden">
                <div class="mx-auto max-w-7xl space-y-1 px-4 py-4 sm:px-6">

                    <a href="{{ route('home') }}"
                        class="block rounded-lg px-3 py-2 text-sm font-medium text-muted transition hover:bg-white hover:text-ink">
                        Home
                    </a>

                    <a href="{{ route('posts.index') }}"
                        class="block rounded-lg px-3 py-2 text-sm font-medium text-muted transition hover:bg-white hover:text-ink">
                        Explore
                    </a>

                    <a href="{{ route('search') }}"
                        class="block rounded-lg px-3 py-2 text-sm font-medium text-muted transition hover:bg-white hover:text-ink">
                        Search
                    </a>

                    <div class="my-3 border-t border-border"></div>

                    @auth
                        <a href="{{ route('posts.create') }}"
                            class="block rounded-lg px-3 py-2 text-sm font-semibold text-ink transition hover:bg-white">
                            Write
                        </a>

                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-ink transition hover:bg-white">
                            <x-avatar :name="auth()->user()->name" size="sm" />
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block rounded-lg px-3 py-2 text-sm font-semibold text-ink transition hover:bg-white">
                            Sign In
                        </a>

                        <a href="{{ route('register') }}"
                            class="mt-1 block rounded-lg bg-ink px-3 py-2 text-center text-sm font-semibold text-paper transition hover:opacity-90">
                            Get Started
                        </a>
                    @endauth

                </div>
            </div>
        </nav>

        {{-- Main Content --}}
        <main class="flex-1">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                    <div
                        class="flex items-center gap-3 rounded-xl border border-primary/20 bg-primary/10 p-4 text-sm font-medium text-primary">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @yield('public-content')

        </main>

        {{-- Footer --}}
        <x-footer />

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const button = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-open-icon');
            const closeIcon = document.getElementById('menu-close-icon');

            if (!button || !menu) return;

            button.addEventListener('click', () => {
                const isOpen = !menu.classList.contains('hidden');

                menu.classList.toggle('hidden');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');

                button.setAttribute('aria-expanded', String(!isOpen));
            });
        });
    </script>
@endsection
