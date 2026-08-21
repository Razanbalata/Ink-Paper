@extends('layouts.app')

@section('title', 'Ink & Paper — Ideas Worth Reading')

@section('content')

    {{-- Hero Section --}}
    <section class="border-b border-border bg-paper relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">
                
                {{-- Hero Content --}}
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-3.5 py-1.5 text-xs font-semibold tracking-wide text-primary">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary animate-pulse"></span>
                        A Place For Thoughtful Ideas
                    </div>

                    <h1 class="mt-6 font-serif text-5xl font-extrabold tracking-tight text-ink sm:text-6xl lg:text-7xl lg:leading-[1.08]">
                        Ideas worth <br class="hidden sm:inline" />
                        <span class="italic font-normal text-primary">reading &amp; sharing.</span>
                    </h1>

                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-muted sm:text-xl">
                        Discover curated stories, deep perspectives, and practical insights written by passionate creators worldwide.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <x-button class="shadow-sm">
                            Start Writing
                        </x-button>

                        <x-button variant="secondary">
                            Explore Stories
                        </x-button>
                    </div>
                </div>

                {{-- Hero Editorial Quote Card --}}
                <div class="lg:col-span-5">
                    <div class="relative rounded-2xl border border-border bg-white p-8 shadow-sm">
                        <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-widest text-muted">
                            <span>Editor's Choice</span>
                            <span class="text-primary font-serif italic font-normal">Vol. 01</span>
                        </div>
                        
                        <blockquote class="font-serif mt-6 text-xl leading-relaxed text-ink">
                            “Writing is not life itself, but is, I think, sometimes my way back to life.”
                        </blockquote>

                        <div class="mt-8 flex items-center gap-3 border-t border-border/60 pt-6">
                            <x-avatar name="Ink & Paper Editorial" size="sm" />
                            <div>
                                <p class="text-sm font-semibold text-ink">Ink &amp; Paper Editorial</p>
                                <p class="text-xs text-muted">Curated Daily Selection</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Featured Stories Section --}}
    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex items-end justify-between border-b border-border pb-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-primary">Handpicked</span>
                    <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Featured Stories
                    </h2>
                </div>

                <a href="#" class="group inline-flex items-center gap-1 text-sm font-semibold text-ink transition hover:text-primary">
                    View all stories 
                    <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                </a>
            </div>

            {{-- Articles Grid --}}
            <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                {{-- Card 1 --}}
                <x-card class="group flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div>
                        <div class="relative flex h-52 items-center justify-center overflow-hidden rounded-lg bg-zinc-100">
                            <span class="font-serif text-5xl font-bold text-zinc-300 transition-transform duration-300 group-hover:scale-110">
                                01
                            </span>
                            <div class="absolute top-3 left-3">
                                <x-badge variant="primary">Technology</x-badge>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="font-serif text-2xl font-bold leading-snug text-ink transition group-hover:text-primary">
                                Building better Laravel applications
                            </h3>
                            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">
                                A practical look at architecture, maintainability, and modern Laravel development standards.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-between border-t border-border/50 pt-4">
                        <div class="flex items-center gap-3">
                            <x-avatar name="Razan Balata" size="sm" />
                            <div>
                                <p class="text-sm font-semibold text-ink">Razan Balata</p>
                                <p class="text-xs text-muted">8 min read</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-muted">Oct 12</span>
                    </div>
                </x-card>

                {{-- Card 2 --}}
                <x-card class="group flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div>
                        <div class="relative flex h-52 items-center justify-center overflow-hidden rounded-lg bg-zinc-100">
                            <span class="font-serif text-5xl font-bold text-zinc-300 transition-transform duration-300 group-hover:scale-110">
                                02
                            </span>
                            <div class="absolute top-3 left-3">
                                <x-badge>Design</x-badge>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="font-serif text-2xl font-bold leading-snug text-ink transition group-hover:text-primary">
                                Designing interfaces people enjoy using
                            </h3>
                            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">
                                Exploring the relationship between visual hierarchy, usability, and thoughtful micro-interactions.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-between border-t border-border/50 pt-4">
                        <div class="flex items-center gap-3">
                            <x-avatar name="Julian Vane" size="sm" />
                            <div>
                                <p class="text-sm font-semibold text-ink">Julian Vane</p>
                                <p class="text-xs text-muted">6 min read</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-muted">Oct 10</span>
                    </div>
                </x-card>

                {{-- Card 3 --}}
                <x-card class="group flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
                    <div>
                        <div class="relative flex h-52 items-center justify-center overflow-hidden rounded-lg bg-zinc-100">
                            <span class="font-serif text-5xl font-bold text-zinc-300 transition-transform duration-300 group-hover:scale-110">
                                03
                            </span>
                            <div class="absolute top-3 left-3">
                                <x-badge>Productivity</x-badge>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="font-serif text-2xl font-bold leading-snug text-ink transition group-hover:text-primary">
                                Building a better creative workflow
                            </h3>
                            <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">
                                Simple systems that help writers focus, create consistently, and publish higher quality work.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-between border-t border-border/50 pt-4">
                        <div class="flex items-center gap-3">
                            <x-avatar name="Sarah Miller" size="sm" />
                            <div>
                                <p class="text-sm font-semibold text-ink">Sarah Miller</p>
                                <p class="text-xs text-muted">5 min read</p>
                            </div>
                        </div>
                        <span class="text-xs font-medium text-muted">Oct 08</span>
                    </div>
                </x-card>

            </div>
        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="border-y border-border bg-white py-20">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="font-serif text-4xl font-extrabold tracking-tight text-ink sm:text-5xl">
                Have something worth sharing?
            </h2>

            <p class="mt-4 text-lg leading-relaxed text-muted">
                Join a growing community of thoughtful writers and readers. Publish your insights with elegance and simplicity.
            </p>

            <div class="mt-8 flex justify-center gap-4">
                <x-button class="px-8 py-3.5 text-base">
                    Start Writing Today
                </x-button>
            </div>
        </div>
    </section>

@endsection