@extends('layouts.guest')

@section('title', $user->name . ' — Ink & Paper')

@section('public-content')

    {{-- Author Header --}}
    <section class="border-b border-border bg-paper">

        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">

            <div class="flex flex-col items-center gap-6 text-center sm:flex-row sm:items-start sm:text-left">

                {{-- Avatar --}}
                <div class="shrink-0">
                    <x-avatar :name="$user->name" size="lg" />
                </div>

                {{-- Author Info --}}
                <div class="max-w-2xl">

                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-primary">
                        Author
                    </span>

                    <h1 class="mt-3 font-serif text-4xl font-extrabold tracking-tight text-ink sm:text-5xl">
                        {{ $user->name }}
                    </h1>

                    @if ($user->bio)
                        <p class="mt-4 text-lg leading-relaxed text-muted">
                            {{ $user->bio }}
                        </p>
                    @else
                        <p class="mt-4 text-lg leading-relaxed text-muted">
                            Writer and contributor at Ink &amp; Paper.
                        </p>
                    @endif

                    {{-- Profile Stats --}}
                    <div class="mt-6 flex items-center gap-6 text-sm">

                        <button type="button" data-modal-open="followers-modal"
                            data-url="{{ route('authors.followers', $user) }}"
                            class="text-sm text-muted hover:text-ink transition *:cursor-pointer">
                            <span class="font-bold text-ink group-hover:text-primary">
                                {{ $user->followers_count }}
                            </span>

                            <span class="text-muted">
                                Followers
                            </span>
                        </button>

                        <button type="button" data-modal-open="following-modal"
                            data-url="{{ route('authors.following', $user) }}"
                            class="text-sm text-muted hover:text-ink transition cursor-pointer">
                            <span class="font-bold text-ink group-hover:text-primary">
                                {{ $user->following_count }}
                            </span>

                            <span class="text-muted">
                                Following
                            </span>
                        </button>

                    </div>

                    {{-- Follow Button --}}
                    @if (auth()->check())

                        @if (auth()->id() !== $user->id)

                            <div class="mt-6">

                                @if ($isFollowing)
                                    <form method="POST" action="{{ route('users.unfollow', $user) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex items-center rounded-full border border-border px-5 py-2.5 text-sm font-semibold text-ink transition hover:border-ink">
                                            Following
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('users.follow', $user) }}">
                                        @csrf

                                        <button type="submit"
                                            class="inline-flex items-center rounded-full bg-ink px-5 py-2.5 text-sm font-semibold text-paper transition hover:bg-primary">
                                            Follow
                                        </button>
                                    </form>
                                @endif

                            </div>

                        @endif
                    @else
                        <div class="mt-6">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center rounded-full bg-ink px-5 py-2.5 text-sm font-semibold text-paper transition hover:bg-primary">
                                Follow
                            </a>
                        </div>

                    @endif

                </div>

            </div>

        </div>
        {{-- Followers Modal --}}
        <div id="followers-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-modal-close="followers-modal"></div>

            <div class="relative flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg overflow-hidden rounded-2xl border border-border bg-paper shadow-2xl"
                    role="dialog" aria-modal="true" aria-labelledby="followers-modal-title">
                    <div class="flex items-center justify-between border-b border-border px-6 py-5">
                        <div>
                            <h2 id="followers-modal-title" class="font-serif text-2xl font-bold text-ink">
                                Followers
                            </h2>

                            <p class="mt-1 text-sm text-muted">
                                People following {{ $user->name }}
                            </p>
                        </div>

                        <button type="button" data-modal-close="followers-modal"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-xl text-muted transition hover:bg-zinc-100 hover:text-ink"
                            aria-label="Close followers modal">
                            ×
                        </button>
                    </div>

                    <div class="max-h-[65vh] overflow-y-auto px-6 py-5">
                        <div id="followers-modal-content" class="text-sm text-muted">
                            Loading...
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Following Modal --}}
        <div id="following-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-modal-close="following-modal"></div>

            <div class="relative flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-lg overflow-hidden rounded-2xl border border-border bg-paper shadow-2xl"
                    role="dialog" aria-modal="true" aria-labelledby="following-modal-title">
                    <div class="flex items-center justify-between border-b border-border px-6 py-5">
                        <div>
                            <h2 id="following-modal-title" class="font-serif text-2xl font-bold text-ink">
                                Following
                            </h2>

                            <p class="mt-1 text-sm text-muted">
                                People {{ $user->name }} follows
                            </p>
                        </div>

                        <button type="button" data-modal-close="following-modal"
                            class="flex h-9 w-9 items-center justify-center rounded-full text-xl text-muted transition hover:bg-zinc-100 hover:text-ink"
                            aria-label="Close following modal">
                            ×
                        </button>
                    </div>

                    <div class="max-h-[65vh] overflow-y-auto px-6 py-5">
                        <div id="following-modal-content" class="text-sm text-muted">
                            Loading...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Author Posts --}}
    <section class="py-16 sm:py-20">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex items-end justify-between border-b border-border pb-6">

                <div>

                    <span class="text-xs font-bold uppercase tracking-widest text-primary">
                        Published
                    </span>

                    <h2 class="mt-1 font-serif text-3xl font-extrabold text-ink sm:text-4xl">
                        Stories by {{ $user->name }}
                    </h2>

                </div>

                <span class="hidden text-sm text-muted sm:block">
                    {{ $posts->total() }}
                    {{ Str::plural('story', $posts->total()) }}
                </span>

            </div>


            @if ($posts->count())

                {{-- Posts Grid --}}
                <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">

                    @foreach ($posts as $post)
                        <x-card :post="$post"
                            class="group flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-md">

                            <div>

                                {{-- Cover --}}
                                <a href="{{ route('posts.show', $post->slug) }}" class="block">

                                    <div
                                        class="relative flex h-52 items-center justify-center overflow-hidden rounded-lg bg-zinc-100">

                                        @if ($post->cover_image)
                                            <img src="{{ asset('storage/' . $post->cover_image) }}"
                                                alt="{{ $post->title }}"
                                                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        @else
                                            <span
                                                class="font-serif text-5xl font-bold text-zinc-300 transition-transform duration-300 group-hover:scale-110">
                                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                        @endif

                                        {{-- Category --}}
                                        @if ($post->category)
                                            <div class="absolute left-3 top-3">

                                                <a href="{{ route('categories.show', $post->category->slug) }}"
                                                    class="inline-flex" onclick="event.stopPropagation();">
                                                    <x-badge variant="primary">
                                                        {{ $post->category->name }}
                                                    </x-badge>
                                                </a>

                                            </div>
                                        @endif

                                    </div>

                                </a>


                                {{-- Content --}}
                                <div class="mt-6">

                                    <h3
                                        class="font-serif text-2xl font-bold leading-snug text-ink transition group-hover:text-primary">

                                        <a href="{{ route('posts.show', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>

                                    </h3>

                                    @if ($post->excerpt)
                                        <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif

                                </div>

                            </div>


                            {{-- Footer --}}
                            <div class="mt-8 flex items-center justify-between border-t border-border/50 pt-4">

                                <div class="flex items-center gap-3">

                                    <x-avatar :name="$user->name" size="sm" />

                                    <div>

                                        <p class="text-sm font-semibold text-ink">
                                            {{ $user->name }}
                                        </p>

                                        <p class="text-xs text-muted">
                                            {{ $post->read_time }} min read
                                        </p>

                                    </div>

                                </div>

                                <span class="text-xs font-medium text-muted">
                                    {{ ($post->published_at ?? $post->created_at)->format('M d') }}
                                </span>

                            </div>

                        </x-card>
                    @endforeach

                </div>


                {{-- Pagination --}}
                @if ($posts->hasPages())
                    <div class="mt-12 border-t border-border pt-8">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="mt-10 rounded-2xl border border-dashed border-border bg-white px-6 py-16 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary/10">

                        <span class="font-serif text-2xl font-bold text-primary">
                            ✦
                        </span>

                    </div>

                    <h3 class="mt-5 font-serif text-2xl font-bold text-ink">
                        No published stories yet
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-muted">
                        {{ $user->name }} hasn't published any stories yet.
                    </p>

                    <a href="{{ route('home') }}"
                        class="mt-6 inline-flex items-center text-sm font-semibold text-primary hover:underline">
                        ← Back to Home
                    </a>

                </div>

            @endif

        </div>

    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // فتح المودال وجلب البيانات
            document.querySelectorAll('[data-modal-open]').forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.getAttribute('data-modal-open');
                    const url = button.getAttribute('data-url');
                    const modal = document.getElementById(modalId);
                    const contentContainer = document.getElementById(modalId + '-content');

                    if (modal) {
                        modal.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden'); // منع تمرير الصفحة الخلفية

                        // جلب المحتوى عبر AJAX إذا كان فارغاً أو لضمان التحديث
                        if (url && contentContainer) {
                            contentContainer.innerHTML =
                                '<div class="py-8 text-center text-muted">جاري التحميل...</div>';

                            fetch(url)
                                .then(response => response.text())
                                .then(html => {
                                    contentContainer.innerHTML = html;
                                })
                                .catch(error => {
                                    contentContainer.innerHTML =
                                        '<div class="py-8 text-center text-red-500">حدث خطأ أثناء تحميل البيانات.</div>';
                                });
                        }
                    }
                });
            });

            // إغلاق المودال
            document.querySelectorAll('[data-modal-close]').forEach(element => {
                element.addEventListener('click', () => {
                    const modalId = element.getAttribute('data-modal-close');
                    const modal = document.getElementById(modalId);

                    if (modal) {
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });

            // إغلاق المودال عند الضغط على زر Esc من لوحة المفاتيح
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.fixed.inset-0.z-50:not(.hidden)').forEach(modal => {
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    });
                }
            });
        });
    </script>
@endsection
