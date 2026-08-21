<footer class="border-t border-border bg-paper">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">

            <div>
                <a href="{{ route('home') }}" class="font-serif text-2xl font-bold text-ink">
                    Ink <span class="text-primary font-normal">&amp;</span> Paper
                </a>
                <p class="mt-2 max-w-sm text-sm leading-relaxed text-muted">
                    A modern publishing platform for writers, readers, and curious minds.
                </p>
            </div>

            <div class="flex flex-wrap gap-x-8 gap-y-3 text-sm font-medium">
                <a href="{{ route('about') }}" class="text-muted transition hover:text-primary">About</a>
                <a href="{{ route('contact') }}" class="text-muted transition hover:text-primary">Contact</a>
                <a href="#" class="text-muted transition hover:text-primary">Privacy Policy</a>
                <a href="#" class="text-muted transition hover:text-primary">Terms of Service</a>
            </div>

        </div>

        <div class="mt-12 border-t border-border/60 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-muted">
            <p>© {{ date('Y') }} Ink &amp; Paper. All rights reserved.</p>
            <p class="font-serif italic">Designed for readers &amp; writers.</p>
        </div>
    </div>
</footer>