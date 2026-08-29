@extends('layouts.guest')

@section('public-content')

    <div class="flex min-h-screen flex-col">

        <main class="flex-1">

            {{-- Header --}}
            <section class="border-b border-border bg-paper">
                <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-wider text-primary">
                                Activity
                            </p>
                            <h1 class="mt-2 font-serif text-4xl font-bold tracking-tight text-ink">
                                Notifications
                            </h1>
                            <p class="mt-3 max-w-xl text-sm leading-6 text-muted">
                                Stay up to date with reactions and comments on your stories.
                            </p>
                        </div>

                        @if ($notifications->count())
                            <form method="POST" action="{{ route('notifications.read-all') }}">
                                @csrf
                                <button type="submit"
                                    class="rounded-lg border border-border bg-white px-4 py-2 text-sm font-semibold text-ink transition hover:bg-paper">
                                    Mark all as read
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </section>

            {{-- List --}}
            <section class="bg-white">
                <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

                    <div class="space-y-3">
                        @forelse ($notifications as $notification)
                            @php $isUnread = is_null($notification->read_at); @endphp

                            <div class="rounded-2xl border border-border p-5 transition hover:border-border/80 {{ $isUnread ? 'bg-paper/50' : 'bg-white' }}">
                                <div class="flex gap-4">

                                    {{-- Icon --}}
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-paper">
                                        @if (($notification->data['type'] ?? null) === 'reaction')
                                            <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M20.8 8.8c0 5.5-8.8 10.2-8.8 10.2S3.2 14.3 3.2 8.8A4.8 4.8 0 0 1 8 4a5.2 5.2 0 0 1 4 2.1A5.2 5.2 0 0 1 16 4a4.8 4.8 0 0 1 4.8 4.8Z" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M21 11.5a8.4 8.4 0 0 1-8.9 8.4A8.5 8.5 0 0 1 3 11.5 8.5 8.5 0 0 1 11.5 3a8.5 8.5 0 0 1 8.5 8.5Z" />
                                                <path stroke-linecap="round" stroke-width="1.8" d="M8 11.5h8" />
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Content --}}
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-ink">
                                                    {{ $notification->data['message'] ?? 'You have a new notification.' }}
                                                </p>

                                                @if (!empty($notification->data['post_title']))
                                                    <p class="mt-1 text-sm text-muted">
                                                        {{ $notification->data['post_title'] }}
                                                    </p>
                                                @endif

                                                @if (($notification->data['type'] ?? null) === 'comment' && !empty($notification->data['comment']))
                                                    <p class="mt-3 rounded-lg bg-paper px-3 py-2 text-sm text-muted">
                                                        “{{ $notification->data['comment'] }}”
                                                    </p>
                                                @endif

                                                <p class="mt-2 text-xs text-muted">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>

                                            {{-- Status Badge --}}
                                            <div>
                                                @if ($isUnread)
                                                    <span class="inline-flex shrink-0 items-center gap-1.5 text-xs font-semibold text-primary">
                                                        <span class="h-2 w-2 rounded-full bg-primary"></span>
                                                        Unread
                                                    </span>
                                                @else
                                                    <span class="text-xs font-medium text-muted">
                                                        Read
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="mt-4 flex items-center gap-4">
                                            @if (!empty($notification->data['post_slug']))
                                                <a href="{{ route('posts.show', $notification->data['post_slug']) }}"
                                                    class="text-xs font-semibold text-primary transition hover:opacity-80">
                                                    View story →
                                                </a>
                                            @endif

                                            @if ($isUnread)
                                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-muted transition hover:text-ink">
                                                        Mark as read
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-border px-6 py-16 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-paper">
                                    <svg class="h-6 w-6 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M15 17h5l-1.5-1.5V11a6.5 6.5 0 0 0-13 0v4.5L4 17h5m6 0a3 3 0 0 1-6 0" />
                                    </svg>
                                </div>
                                <h2 class="mt-4 text-lg font-bold text-ink">No notifications yet</h2>
                                <p class="mt-1 text-sm text-muted">
                                    When someone reacts to or comments on your stories, you'll see it here.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($notifications->hasPages())
                        <div class="mt-8">
                            {{ $notifications->links() }}
                        </div>
                    @endif

                </div>
            </section>

        </main>

    </div>

@endsection