@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen flex-col">

        {{-- Public Navbar --}}
        <nav class="sticky top-0 z-50 border-b border-border bg-paper/90 backdrop-blur-md">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="font-serif text-2xl font-extrabold tracking-tight text-ink">
                    Ink <span class="font-normal text-primary">&amp;</span> Paper
                </a>

                {{-- Desktop Nav Links --}}
                <div class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-ink transition hover:text-primary">
                        Home
                    </a>
                    <a href="#" class="text-sm font-medium text-muted transition hover:text-ink">
                        Explore
                    </a>
                    <a href="#" class="text-sm font-medium text-muted transition hover:text-ink">
                        Authors
                    </a>
                </div>

                {{-- Action Buttons --}}
                <div class="hidden items-center gap-4 md:flex">
                    <a href="#" class="text-sm font-semibold text-muted transition hover:text-ink">
                        Sign In
                    </a>
                    <a href="{{ route('posts.create') }}">
                        <x-button>
                            Start Writing
                        </x-button>
                    </a>
                </div>

            </div>
        </nav>

        {{-- Main Page Content --}}
        <main class="flex-1">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3 rounded-xl border border-primary/20 bg-primary/10 p-4 text-sm font-medium text-primary">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
@endsection