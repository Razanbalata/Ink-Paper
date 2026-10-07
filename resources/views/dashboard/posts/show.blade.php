@extends('layouts.dashboard')

@section('title', $post->title . ' — Post Details')

@section('dashboard-content')
    <div class="mx-auto max-w-5xl space-y-8 py-8 px-4 sm:px-6" x-data="{ showComments: false }">

        {{-- Action Bar --}}
        <div class="flex flex-col gap-4 border-b border-slate-200/80 pb-6 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('dashboard.posts') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-slate-900 group">
                <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Posts
            </a>

            <div class="flex flex-wrap items-center gap-2.5">
                @if ($post->status === 'published')
                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-2xs transition hover:bg-slate-50 hover:text-slate-900">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        View Public
                    </a>
                @endif

                <a href="{{ route('posts.edit', $post) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-2xs transition hover:bg-slate-50 hover:text-slate-900">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <form method="POST" action="{{ route('posts.destroy', $post) }}"
                    onsubmit="return confirm('Are you sure you want to delete this article?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50/60 px-4 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-100 hover:text-rose-700">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-2.5">
                @if ($post->category)
                    <x-badge variant="primary">
                        {{ $post->category->name }}
                    </x-badge>
                @endif

                @if ($post->status === 'published')
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-0.5 text-xs font-semibold text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Published
                    </span>
                @elseif ($post->status === 'draft')
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-amber-200 bg-amber-50 px-3 py-0.5 text-xs font-semibold text-amber-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        Draft
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-3 py-0.5 text-xs font-semibold text-slate-600">
                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                        Archived
                    </span>
                @endif
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl leading-tight font-serif">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p class="text-lg leading-relaxed text-slate-600 max-w-3xl">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>

        {{-- Meta Stats Grid --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">

            {{-- Created Card --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-2xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Created</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->created_at->format('M d, Y') }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">At {{ $post->created_at->format('h:i A') }}</p>
            </div>

            {{-- Published Card --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-2xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Published</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $post->published_at ? $post->published_at->format('h:i A') : 'Draft status' }}
                </p>
            </div>

            {{-- Reading Time Card --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-2xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Reading Time</span>
                <p class="mt-1.5 text-base font-semibold text-slate-900">
                    {{ $post->read_time }} min read
                </p>
                <p class="text-xs text-slate-500 mt-0.5">Estimated time</p>
            </div>

            {{-- Views Card (Fixed) --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-2xs transition hover:border-slate-300">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Views</span>
                <div class="mt-1.5 flex items-center gap-2">
                    <svg class="h-4 w-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M2.25 12s3.5-5.25 9.75-5.25S21.75 12 21.75 12 18.25 17.25 12 17.25 2.25 12 2.25 12Z" />
                        <circle cx="12" cy="12" r="2.5" />
                    </svg>
                    <p class="text-base font-semibold text-slate-900">
                        {{ number_format($post->views->count()) }}
                    </p>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Total views</p>
            </div>

        </div>

        {{-- Featured Cover Image --}}
        @if ($post->cover_image)
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50 shadow-2xs">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="max-h-[450px] w-full object-cover">
            </div>
        @endif

        {{-- Article Body --}}
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-10 shadow-2xs">
            <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed text-base sm:text-lg">
                {!! $post->content !!}
            </div>
        </div>

        {{-- Tags Section --}}
        @if ($post->tags->isNotEmpty())
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-2xs">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tags</span>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span
                            class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-700 transition hover:bg-slate-100">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Dynamic Reactions Section --}}
        <section x-data="{
            showUsers: false,
            users: [],
            count: {{ $post->reactions->count() }},
            reacted: {{ auth()->check() && $post->reactions->contains('user_id', auth()->id()) ? 'true' : 'false' }},
            usersLoading: false,
            loading: false,
            animateHeart: false,
        
            async init() {
                await this.fetchUsers();
            },
        
            async fetchUsers() {
                this.usersLoading = true;
                try {
                    const response = await fetch('{{ route('reactions.users', $post) }}', {
                        headers: { 'Accept': 'application/json' },
                    });
                    if (!response.ok) throw new Error('Failed to load users');
                    const data = await response.json();
                    this.users = data.users || [];
                } catch (error) {
                    console.error('Error fetching users:', error);
                } finally {
                    this.usersLoading = false;
                }
            },
        
            async toggleReaction() {
                @guest window.location.href = '{{ route('login') }}'; 
                return; @endguest
        
                if (this.loading) return;
                this.loading = true;
        
                // Trigger click animation
                this.animateHeart = true;
                setTimeout(() => this.animateHeart = false, 400);
        
                try {
                    const response = await fetch('{{ route('reactions.toggle', $post) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                    });
                    if (!response.ok) throw new Error('Failed to toggle reaction');
                    const data = await response.json();
        
                    this.reacted = data.reacted;
                    this.count = data.count;
        
                    // Sync the latest users list immediately
                    await this.fetchUsers();
                } catch (error) {
                    console.error('Error toggling reaction:', error);
                } finally {
                    this.loading = false;
                }
            },
        
            openModal() {
                this.showUsers = true;
                this.fetchUsers();
            }
        }"
            class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm transition-all sm:p-8 hover:shadow-md">
            {{-- Decorative Background Glow --}}
            <div class="pointer-events-none absolute -top-12 -right-12 h-32 w-32 rounded-full bg-rose-500/5 blur-2xl"></div>

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-bold text-rose-600">
                        <svg class="h-3 w-3 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        Community Pulse
                    </span>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900">
                        Reactions
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-500">
                        Join the conversation and show your support for this article.
                    </p>
                </div>

                {{-- Interactive Reaction Actions --}}
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Like Button --}}
                    <button type="button" @click="toggleReaction()" :disabled="loading"
                        class="group relative inline-flex items-center gap-2.5 rounded-2xl border px-5 py-3 text-xs font-bold transition-all duration-200 active:scale-95 disabled:opacity-50"
                        :class="reacted
                            ?
                            'border-rose-200 bg-rose-50 text-rose-600 shadow-xs' :
                            'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50 shadow-2xs'">

                        <svg class="h-4 w-4 transition-transform duration-300 group-hover:scale-110"
                            :class="{
                                'scale-125 text-rose-600 fill-current': reacted,
                                'animate-ping': animateHeart,
                                'fill-none stroke-current':
                                    !reacted
                            }"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" />
                        </svg>

                        <span x-text="reacted ? 'Liked' : 'Like'"></span>
                    </button>

                    {{-- Counter Pill --}}
                    <button type="button" @click="openModal()" :disabled="count === 0"
                        class="inline-flex items-center gap-2 rounded-2xl border border-slate-200/80 bg-slate-50/80 px-4 py-3 text-xs font-semibold text-slate-700 transition hover:bg-slate-100 disabled:cursor-default">
                        <span class="font-bold text-slate-900" x-text="count"></span>
                        <span x-text="count === 1 ? 'Reaction' : 'Reactions'"></span>
                    </button>
                </div>
            </div>

            {{-- Avatars & Social Proof Bar --}}
            <div x-show="count > 0" x-transition.opacity.duration.300ms class="mt-6 border-t border-slate-100 pt-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        {{-- Dynamic Avatar Stack --}}
                        <div class="flex -space-x-2.5 overflow-hidden">
                            <template x-for="(user, index) in users.slice(0, 5)" :key="user.id">
                                <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-slate-800 text-white flex items-center justify-center text-[11px] font-bold shadow-2xs uppercase transition-transform hover:z-10 hover:scale-110"
                                    :title="user.name" x-text="user.name.charAt(0)">
                                </div>
                            </template>
                        </div>

                        {{-- Names Highlight --}}
                        <div class="text-xs text-slate-600">
                            <template x-if="users.length > 0">
                                <span>
                                    Reacted by <strong class="font-semibold text-slate-900"
                                        x-text="users[0].name"></strong>
                                    <template x-if="users.length > 1">
                                        <span> and <button type="button" @click="openModal()"
                                                class="font-semibold text-rose-600 hover:underline"
                                                x-text="(count - 1) + ' others'"></button></span>
                                    </template>
                                </span>
                            </template>
                        </div>
                    </div>

                    <button type="button" @click="openModal()"
                        class="text-xs font-semibold text-slate-500 hover:text-slate-900 transition">
                        See all
                    </button>
                </div>
            </div>

            {{-- Empty State --}}
            <div x-show="count === 0"
                class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-5 text-center">
                <p class="text-xs font-medium text-slate-500">
                    Be the first one to react to this post!
                </p>
            </div>

            {{-- Modal List of Reacted Users --}}
            <template x-teleport="body">
                <div x-show="showUsers" x-cloak @keydown.escape.window="showUsers = false"
                    class="fixed inset-0 z-50 flex items-center justify-center px-4">

                    {{-- Backdrop --}}
                    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs transition-opacity" x-show="showUsers"
                        x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        @click="showUsers = false"></div>

                    {{-- Modal Box --}}
                    <div x-show="showUsers" x-transition:enter="ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95" @click.stop
                        class="relative w-full max-w-sm overflow-hidden rounded-3xl bg-white shadow-2xl border border-slate-100">

                        {{-- Modal Header --}}
                        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex h-7 w-7 items-center justify-center rounded-full bg-rose-50 text-rose-600">
                                    <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-900">
                                    Reactions
                                </h3>
                            </div>

                            <button type="button" @click="showUsers = false"
                                class="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Modal Content --}}
                        <div class="max-h-80 overflow-y-auto p-3">
                            <div x-show="usersLoading" class="flex items-center justify-center py-8">
                                <div
                                    class="h-6 w-6 animate-spin rounded-full border-2 border-rose-500 border-t-transparent">
                                </div>
                            </div>

                            <div x-show="!usersLoading" class="space-y-1">
                                <template x-for="user in users" :key="user.id">
                                    <div
                                        class="flex items-center justify-between rounded-2xl px-3 py-2.5 transition hover:bg-slate-50">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-xs font-bold text-white uppercase"
                                                x-text="user.name.charAt(0)"></div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900" x-text="user.name"></p>
                                                <p class="text-[11px] text-slate-400">Reacted to post</p>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <div x-show="users.length === 0 && !usersLoading"
                                    class="py-8 text-center text-xs text-slate-400">
                                    No reactions found.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </section>

        {{-- Interactive Engagement Bar (Comments Toggle Button) --}}
        <div
            class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-2xs sm:px-6">
            <div class="flex items-center gap-3">
                <button type="button" @click="showComments = !showComments"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-2xs transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary/20"
                    :class="{ 'bg-slate-100 border-slate-300': showComments }">
                    <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</span>
                    <svg class="h-3.5 w-3.5 text-slate-400 transition-transform duration-200"
                        :class="{ 'rotate-180': showComments }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <span class="text-xs text-slate-400 hidden sm:inline">
                Click comments to view or reply
            </span>
        </div>

        {{-- Collapsible Comments Section --}}
        <section id="comments" x-show="showComments" x-collapse x-cloak
            class="rounded-2xl border border-border/80 bg-white p-6 shadow-2xs sm:p-8">
            <div class="flex items-center justify-between gap-4 border-b border-border/60 pb-5">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-primary">
                        Discussion
                    </span>
                    <h2 class="mt-0.5 font-serif text-2xl font-bold text-ink">
                        Comments
                    </h2>
                    <p class="mt-0.5 text-xs text-muted">
                        Manage the responses to your article.
                    </p>
                </div>

                <span
                    class="rounded-full border border-border bg-paper/60 px-3 py-1 text-xs font-semibold text-muted shadow-2xs">
                    {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
                </span>
            </div>

            @auth
                <div class="mt-6 rounded-2xl border border-border/80 bg-paper/30 p-5 shadow-2xs">
                    <div class="flex items-start gap-3.5 sm:gap-4">
                        <x-avatar :name="auth()->user()->name" size="md" class="shrink-0 ring-2 ring-primary/10" />

                        <div class="min-w-0 flex-1">
                            <div class="mb-3">
                                <p class="text-sm font-semibold text-ink">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-muted">Add a note or response</p>
                            </div>

                            <form method="POST" action="{{ route('comments.store', $post) }}">
                                @csrf
                                <input type="hidden" name="redirect_to" value="dashboard">

                                <textarea name="body" rows="3" required minlength="2" maxlength="1000" placeholder="Write a response..."
                                    class="w-full resize-y rounded-xl border border-border/80 bg-white p-3.5 text-sm text-ink placeholder-muted/70 transition focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary leading-relaxed">{{ old('body') }}</textarea>

                                @error('body')
                                    <p class="mt-2 text-xs font-medium text-rose-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <div class="mt-3 flex justify-end">
                                    <x-button type="submit">
                                        Post Comment
                                    </x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            <div class="mt-8 space-y-6">
                @forelse ($post->comments as $comment)
                    <article class="border-b border-border/60 pb-6 last:border-0" x-data="{ editing: false }">
                        <div class="flex items-start gap-3.5">
                            <x-avatar :name="$comment->user->name ?? 'Anonymous'" size="md" class="shrink-0" />

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-ink">
                                            {{ $comment->user->name ?? 'Anonymous' }}
                                        </span>
                                        <span class="text-xs text-muted/60">•</span>
                                        <time class="text-xs text-muted">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </time>

                                        @if ($comment->updated_at->gt($comment->created_at))
                                            <span class="text-[10px] italic text-muted/70">(edited)</span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-3">
                                        @if (auth()->id() === $comment->user_id)
                                            <button type="button" @click="editing = true" x-show="!editing"
                                                class="text-xs font-medium text-muted transition hover:text-primary">
                                                Edit
                                            </button>
                                        @endif

                                        @if (auth()->id() === $comment->user_id || auth()->id() === $post->user_id)
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this comment?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="redirect_to" value="dashboard">
                                                <button type="submit"
                                                    class="text-xs font-medium text-muted transition hover:text-rose-600">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <div x-show="!editing" class="mt-2 text-sm leading-relaxed text-ink/85">
                                    {{ $comment->body }}
                                </div>

                                @if (auth()->id() === $comment->user_id)
                                    <div x-show="editing" x-cloak class="mt-3">
                                        <form method="POST" action="{{ route('comments.update', $comment) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="redirect_to" value="dashboard">

                                            <textarea name="body" rows="3" required minlength="2" maxlength="1000"
                                                class="w-full resize-y rounded-xl border border-border bg-paper/50 p-3.5 text-sm text-ink focus:border-primary focus:bg-white focus:outline-none focus:ring-1 focus:ring-primary leading-relaxed">{{ $comment->body }}</textarea>

                                            @error('body')
                                                <p class="mt-1.5 text-xs font-medium text-rose-600">
                                                    {{ $message }}
                                                </p>
                                            @enderror

                                            <div class="mt-3 flex items-center gap-2">
                                                <button type="submit"
                                                    class="rounded-lg bg-primary px-3.5 py-1.5 text-xs font-semibold text-white transition hover:opacity-90">
                                                    Save
                                                </button>

                                                <button type="button" @click="editing = false"
                                                    class="rounded-lg border border-border bg-white px-3.5 py-1.5 text-xs font-semibold text-muted transition hover:bg-paper hover:text-ink">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-border/80 p-8 text-center">
                        <p class="font-serif text-base font-semibold text-ink">
                            No comments yet.
                        </p>
                        <p class="mt-1 text-xs text-muted">
                            Be the first to start the discussion.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>

    </div>
@endsection
