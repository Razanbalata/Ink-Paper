<nav class="sticky top-0 z-50 border-b border-border bg-paper/90 backdrop-blur-md">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="font-serif text-2xl font-extrabold tracking-tight text-ink">
            Ink <span class="text-primary font-normal">&amp;</span> Paper
        </a>

        {{-- Desktop Navigation --}}
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

        {{-- Actions --}}
        <div class="hidden items-center gap-4 md:flex">
            <a href="#" class="text-sm font-semibold text-muted transition hover:text-ink">
                Sign In
            </a>
            <x-button>
                Start Writing
            </x-button>
        </div>

        {{-- Mobile menu button --}}
        <button type="button" class="rounded-lg p-2 text-ink hover:bg-border/50 md:hidden" aria-label="Open menu">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

    </div>
</nav>