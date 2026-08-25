@extends('layouts.app')

@section('content')
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

                    <a href="#" class="text-sm font-medium text-muted transition hover:text-ink">
                        Explore
                    </a>

                    <a href="#" class="text-sm font-medium text-muted transition hover:text-ink">
                        Topics
                    </a>

                    <a href="#"
                        class="inline-flex items-center gap-2 text-sm font-medium text-muted transition hover:text-ink">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>

                        Search
                    </a>

                </div>


                {{-- Guest Actions --}}
                <div class="hidden items-center gap-4 md:flex">

                    <a href="#" class="text-sm font-semibold text-muted transition hover:text-ink">
                        Sign In
                    </a>

                    <a href="#"
                        class="rounded-full bg-ink px-5 py-2.5 text-sm font-semibold text-paper transition hover:-translate-y-0.5 hover:shadow-md">
                        Get Started
                    </a>

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

                    <a href="#"
                        class="block rounded-lg px-3 py-3 text-sm font-medium text-muted transition hover:bg-white hover:text-ink">
                        Explore
                    </a>

                    <a href="#"
                        class="block rounded-lg px-3 py-3 text-sm font-medium text-muted transition hover:bg-white hover:text-ink">
                        Topics
                    </a>

                    <a href="#"
                        class="block rounded-lg px-3 py-3 text-sm font-medium text-muted transition hover:bg-white hover:text-ink">
                        Search
                    </a>

                    <div class="my-3 border-t border-border"></div>

                    <a href="#"
                        class="block rounded-lg px-3 py-3 text-sm font-semibold text-ink transition hover:bg-white">
                        Sign In
                    </a>

                    <a href="#"
                        class="mt-1 block rounded-lg bg-ink px-3 py-3 text-center text-sm font-semibold text-paper transition hover:opacity-90">
                        Get Started
                    </a>

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

            if (!button || !menu) {
                return;
            }

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
