@extends('layouts.guest')

@section('title', $post->title . ' — Ink & Paper')

@section('public-content')

    <article class="relative mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-20">

        {{-- Top Navigation --}}
        <div class="mb-8 flex items-center justify-between border-b border-border/40 pb-6">
            <a href="{{ route('home') }}"
                class="group inline-flex items-center gap-2 text-xs font-bold tracking-widest uppercase text-muted transition-colors hover:text-ink">
                <svg class="h-4 w-4 stroke-[2.5] transition-transform group-hover:-translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Feed
            </a>

            @if ($post->category)
                <a href="{{ route('categories.show', $post->category->slug ?? '') }}"
                    class="rounded-full bg-paper px-3.5 py-1 text-[11px] font-bold uppercase tracking-widest text-primary border border-border/50 transition-colors hover:border-primary">
                    {{ $post->category->name }}
                </a>
            @endif
        </div>

        {{-- Article Header --}}
        <header class="space-y-6 text-left">
            <h1 class="font-serif text-3xl font-extrabold tracking-tight text-ink sm:text-5xl lg:text-6xl leading-[1.12]">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p
                    class="font-serif text-xl sm:text-2xl leading-relaxed text-muted/90 italic border-l-2 border-primary/80 pl-6 py-1">
                    {{ $post->excerpt }}
                </p>
            @endif

            <div class="flex flex-wrap items-center justify-between gap-4 border-y border-border/40 py-4">
                <div class="flex items-center gap-3.5">
                    <x-avatar :name="$post->user->name ?? 'Anonymous'" size="md" class="ring-2 ring-paper shadow-sm" />
                    <div>
                        <a href="{{ route('authors.show', $post->user ?? '#') }}"
                            class="text-sm font-bold text-ink transition-colors hover:text-primary">
                            {{ $post->user->name ?? 'Anonymous' }}
                        </a>
                        <p class="text-[11px] font-medium text-muted/80">
                            Published on {{ ($post->published_at ?? $post->created_at)->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-xs font-semibold text-muted">
                    <span class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $post->read_time }} min read
                    </span>
                </div>
            </div>
        </header>

        {{-- Cover Image --}}
        @if ($post->cover_image)
            <figure class="my-10 overflow-hidden rounded-2xl border border-border/30 bg-paper shadow-sm">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}"
                    class="w-full max-h-[540px] object-cover transition-transform duration-1000 ease-out hover:scale-[1.02]">
            </figure>
        @endif

        {{-- Article Main Body --}}
        <section class="mt-8">
            <div
                class="prose prose-stone prose-lg sm:prose-xl max-w-none font-serif text-ink/90 leading-[1.95]
                       prose-headings:font-serif prose-headings:font-bold prose-headings:text-ink prose-headings:tracking-tight
                       prose-a:text-primary prose-a:underline-offset-4 prose-a:decoration-primary/30 hover:prose-a:decoration-primary 
                       prose-blockquote:border-l-primary prose-blockquote:bg-paper/40 prose-blockquote:py-3 prose-blockquote:px-6 prose-blockquote:rounded-r-lg prose-blockquote:not-italic
                       selection:bg-primary/15 selection:text-ink">
                {!! nl2br(e($post->content)) !!}
            </div>
        </section>

        {{-- Tags --}}
        @if ($post->tags->isNotEmpty())
            <div class="mt-12 border-t border-border/40 pt-6 flex flex-wrap items-center gap-2">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('tags.show', $tag->slug) }}"
                        class="rounded-lg bg-paper px-3 py-1 text-xs font-semibold text-muted transition-all hover:bg-primary/10 hover:text-primary">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Sticky Floating Bar: Reaction Button & Dynamic Reaction Summary --}}
        <div x-data="{
            reacted: {{ auth()->check() && $post->reactions->contains('user_id', auth()->id()) ? 'true' : 'false' }},
            count: {{ $post->reactions->count() }},
            bookmarked: {{ auth()->check() && $post->bookmarks->contains('user_id', auth()->id()) ? 'true' : 'false' }},
            loading: false,
            showUsers: false,
            users: [],
            usersLoading: false,
        
            async init() {
                // جلب قائمة التفاعلات فور تحميل الصفحة لتهيئة Avatars الديناميكية
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
                    console.error(error);
                } finally {
                    this.usersLoading = false;
                }
            },
        
            async toggleReaction() {
                @guest window.location.href = '{{ route('login') }}'; return; @endguest
                if (this.loading) return;
                this.loading = true;
                try {
                    const response = await fetch('{{ route('reactions.toggle', $post) }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    });
                    if (!response.ok) throw new Error('Failed to toggle reaction');
                    const data = await response.json();
        
                    this.reacted = data.reacted;
                    this.count = data.count;
        
                    // إعادة جلب القائمة فوراً لتحديث الـ Avatars والمودال لحظياً
                    await this.fetchUsers();
                } catch (error) {
                    console.error(error);
                } finally {
                    this.loading = false;
                }
            },
        
            async toggleBookmark() {
                @guest window.location.href = '{{ route('login') }}'; return; @endguest
        
                if (this.bookmarkLoading) return;
        
                this.bookmarkLoading = true;
        
                try {
                    const response = await fetch('{{ route('bookmarks.toggle', $post) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    });
        
                    if (!response.ok) {
                        throw new Error('Failed to toggle bookmark');
                    }
        
                    const data = await response.json();
        
                    this.bookmarked = data.bookmarked;
                } catch (error) {
                    console.error(error);
                } finally {
                    this.bookmarkLoading = false;
                }
            },
        
            openModal() {
                this.showUsers = true;
                if (this.users.length === 0) {
                    this.fetchUsers();
                }
            }
        }">
            {{-- Floating Bar --}}
            <div class="sticky bottom-6 z-40 my-10 flex justify-center">
                <div
                    class="inline-flex items-center gap-3 rounded-full border border-border/80 bg-white/90 p-2 pl-3 shadow-xl backdrop-blur-md transition-all hover:border-primary/40">

                    {{-- Toggle Like Button --}}
                    <button type="button" @click="toggleReaction()" :disabled="loading"
                        class="inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-xs font-bold transition-all active:scale-95"
                        :class="reacted ? 'bg-primary/10 text-primary' : 'text-ink hover:bg-paper'">
                        <svg class="h-4 w-4 transition-transform" :class="reacted ? 'scale-110 fill-current' : 'fill-none'"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" />
                        </svg>
                        <span x-text="reacted ? 'Liked' : 'Like'"></span>
                    </button>

                    <div class="h-4 w-px bg-border/60"></div>

                    {{-- Dynamic Reaction Summary (Avatars & Count Trigger) --}}
                    <div class="flex items-center gap-2">
                        <button type="button" @click="openModal()"
                            class="group inline-flex items-center gap-2 text-xs font-semibold text-ink">
                            <span class="font-bold" x-text="count"></span>
                            <span class="text-muted hidden sm:inline"
                                x-text="count === 1 ? 'reaction' : 'reactions'"></span>
                        </button>

                        {{-- Dynamic Avatars via Alpine --}}
                        <div x-show="users.length > 0" class="flex items-center">
                            <template x-for="(user, index) in users.slice(0, 3)" :key="user.id">
                                <div class="relative -ml-2 first:ml-0 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-paper text-[9px] font-bold text-primary shadow-sm"
                                    :title="user.name" x-text="user.name.charAt(0).toUpperCase()">
                                </div>
                            </template>

                            <template x-if="count > 3">
                                <span
                                    class="relative -ml-2 flex h-7 min-w-7 items-center justify-center rounded-full border-2 border-white bg-slate-100 px-1 text-[9px] font-bold text-slate-600 shadow-sm"
                                    x-text="'+' + (count - 3)">
                                </span>
                            </template>
                        </div>
                    </div>

                    <div class="h-4 w-px bg-border/60"></div>

                    {{-- Scroll To Comments --}}
                    <a href="#comments"
                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-xs font-bold text-muted transition hover:bg-paper hover:text-ink">
                        <svg class="h-4 w-4 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>{{ $post->comments->count() }}</span>
                    </a>
                    {{-- Bookmark --}}
                    <button type="button" @click="toggleBookmark()" :disabled="bookmarkLoading"
                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1.5 text-xs font-bold transition-all active:scale-95"
                        :class="bookmarked
                            ?
                            'bg-primary/10 text-primary' :
                            'text-muted hover:bg-paper hover:text-ink'"
                        :aria-label="bookmarked ? 'Remove bookmark' : 'Save article'">
                        <svg class="h-4 w-4 transition-transform"
                            :class="bookmarked ? 'scale-110 fill-current' : 'fill-none'" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M6 4.75A2.75 2.75 0 0 1 8.75 2h6.5A2.75 2.75 0 0 1 18 4.75V21l-6-3.5L6 21V4.75Z" />
                        </svg>

                        <span class="hidden sm:inline" x-text="bookmarked ? 'Saved' : 'Save'"></span>
                    </button>
                    <div class="h-4 w-px bg-border/60"></div>

                    {{-- Share --}}
                    <button type="button" x-data
                        @click="navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!')"
                        class="rounded-full p-1.5 text-muted transition hover:bg-paper hover:text-ink">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 002-2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Reactions Users Modal --}}
            <template x-teleport="body">
                <div x-show="showUsers" x-cloak @keydown.escape.window="showUsers = false"
                    class="fixed inset-0 z-50 flex items-center justify-center px-4">

                    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showUsers = false"></div>

                    <div x-show="showUsers" x-transition @click.stop
                        class="relative w-full max-w-md overflow-hidden rounded-2xl border border-border bg-white shadow-2xl">

                        <div class="flex items-center justify-between border-b border-border px-6 py-5">
                            <div>
                                <h3 class="font-serif text-xl font-bold text-ink">Reactions</h3>
                                <p class="mt-0.5 text-xs text-muted">
                                    <span x-text="count"></span> people reacted to this article
                                </p>
                            </div>

                            <button type="button" @click="showUsers = false"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-muted transition hover:bg-paper hover:text-ink">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="max-h-[400px] overflow-y-auto p-4">
                            <div x-show="usersLoading" class="flex justify-center py-10">
                                <div class="h-6 w-6 animate-spin rounded-full border-2 border-border border-t-primary">
                                </div>
                            </div>

                            <div x-show="!usersLoading" class="space-y-1">
                                <template x-for="user in users" :key="user.id">
                                    <div class="flex items-center gap-3 rounded-xl px-3 py-3 transition hover:bg-paper">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary/10 text-sm font-bold text-primary"
                                            x-text="user.name.charAt(0).toUpperCase()"></div>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-ink" x-text="user.name"></p>
                                            <p class="text-xs text-muted">Reacted to this article</p>
                                        </div>
                                    </div>
                                </template>

                                <div x-show="users.length === 0" class="py-8 text-center text-xs font-medium text-muted">
                                    No reactions yet. Be the first to react!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Comments Section --}}
        <section id="comments" class="mt-14">
            <div class="flex items-center justify-between border-b border-border/40 pb-4">
                <h2 class="font-serif text-2xl font-bold text-ink">Discussion</h2>
                <span class="text-xs font-bold uppercase tracking-widest text-muted">
                    {{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}
                </span>
            </div>

            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-8">
                    @csrf
                    <input type="hidden" name="redirect_to" value="public">
                    <div
                        class="rounded-2xl border border-border/80 bg-paper/40 p-4 transition-focus-within focus-within:border-primary focus-within:bg-white focus-within:ring-1 focus-within:ring-primary">
                        <textarea name="body" rows="3" placeholder="Add to the discussion..." required minlength="2"
                            maxlength="1000" class="w-full resize-y bg-transparent text-sm text-ink placeholder-muted/60 focus:outline-none"></textarea>

                        <div class="mt-3 flex justify-end border-t border-border/30 pt-3">
                            <button type="submit"
                                class="rounded-xl bg-ink px-5 py-2 text-xs font-bold uppercase tracking-wider text-white transition hover:bg-primary">
                                Publish Comment
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="mt-8 rounded-2xl border border-dashed border-border/80 p-8 text-center bg-paper/20">
                    <p class="font-serif text-base font-bold text-ink">Want to join the conversation?</p>
                    <p class="mt-1 text-xs text-muted">Sign in to leave a comment or share your thoughts.</p>
                    <a href="{{ route('login') }}"
                        class="mt-4 inline-block rounded-xl bg-ink px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white transition hover:bg-primary">
                        Sign In
                    </a>
                </div>
            @endauth

            <div class="mt-10 space-y-6">
                @forelse ($post->comments as $comment)
                    <div class="group relative rounded-xl border border-border/40 bg-white p-5 transition-all hover:border-border/80"
                        x-data="{ editing: false }">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <x-avatar :name="$comment->user->name ?? 'Anonymous'" size="sm" />
                                <div>
                                    <h4 class="text-sm font-bold text-ink">{{ $comment->user->name ?? 'Anonymous' }}</h4>
                                    <time
                                        class="text-[11px] text-muted">{{ $comment->created_at->diffForHumans() }}</time>
                                </div>
                            </div>

                            @auth
                                @if (auth()->id() === $comment->user_id)
                                    <div class="flex items-center gap-3 text-xs font-semibold text-muted" x-show="!editing">
                                        <button type="button" @click="editing = true"
                                            class="hover:text-primary">Edit</button>
                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                                            onsubmit="return confirm('Delete comment?');">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="redirect_to" value="public">
                                            <button type="submit" class="hover:text-rose-600">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <div x-show="!editing" class="mt-3 font-serif text-sm leading-relaxed text-ink/90">
                            {{ $comment->body }}
                        </div>

                        @auth
                            @if (auth()->id() === $comment->user_id)
                                <div x-show="editing" x-cloak class="mt-3">
                                    <form method="POST" action="{{ route('comments.update', $comment) }}">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="redirect_to" value="public">
                                        <textarea name="body" rows="2" required
                                            class="w-full rounded-lg border border-border p-3 text-sm focus:outline-none focus:border-primary">{{ $comment->body }}</textarea>
                                        <div class="mt-2 flex justify-end gap-2">
                                            <button type="button" @click="editing = false"
                                                class="text-xs font-bold text-muted px-3 py-1">Cancel</button>
                                            <button type="submit"
                                                class="rounded-lg bg-primary px-3 py-1 text-xs font-bold text-white">Save</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @empty
                    <p class="py-8 text-center text-xs font-medium text-muted">No comments posted yet.</p>
                @endforelse
            </div>
        </section>

    </article>

@endsection
