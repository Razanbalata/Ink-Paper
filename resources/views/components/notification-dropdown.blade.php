@php
    $notifications = auth()->user()->notifications()->latest()->take(5)->get();
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<div class="relative" x-data="{ open: false }">

    {{-- Notification Button --}}
    <button type="button" @click="open = !open"
        class="relative flex h-10 w-10 items-center justify-center rounded-full text-muted transition hover:bg-paper hover:text-ink focus:outline-none"
        aria-label="Notifications">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M15 17h5l-1.5-1.5V11a6.5 6.5 0 0 0-13 0v4.5L4 17h5m6 0a3 3 0 0 1-6 0m6 0H9" />
        </svg>

        {{-- Unread Badge --}}
        @if ($unreadCount > 0)
            <span class="absolute right-1 top-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-primary px-1 text-[10px] font-bold leading-none text-white">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div x-show="open" x-cloak @click.outside="open = false" x-transition
        class="absolute right-0 z-50 mt-3 w-80 overflow-hidden rounded-2xl border border-border bg-white shadow-xl">

        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-border px-4 py-3">
            <div>
                <h3 class="text-sm font-bold text-ink">Notifications</h3>
                <p class="mt-0.5 text-xs text-muted">Your latest activity</p>
            </div>

            @if ($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-primary transition hover:opacity-80">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>

        {{-- List --}}
        <div class="max-h-96 overflow-y-auto divide-y divide-border">
            @forelse ($notifications as $notification)
                @php $isUnread = is_null($notification->read_at); @endphp
                
                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ route('dashboard.posts.show', $notification->data['post_id'] ?? '') }}">

                    <button type="submit" 
                        class="flex w-full gap-3 px-4 py-3 text-left transition hover:bg-paper {{ $isUnread ? 'bg-paper/40' : 'bg-white' }}">
                        
                        {{-- Icon --}}
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-paper">
                            @if (($notification->data['type'] ?? null) === 'reaction')
                                <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M20.8 8.8c0 5.5-8.8 10.2-8.8 10.2S3.2 14.3 3.2 8.8A4.8 4.8 0 0 1 8 4a5.2 5.2 0 0 1 4 2.1A5.2 5.2 0 0 1 16 4a4.8 4.8 0 0 1 4.8 4.8Z" />
                                </svg>
                            @else
                                <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M21 11.5a8.4 8.4 0 0 1-8.9 8.4A8.5 8.5 0 0 1 3 11.5 8.5 8.5 0 0 1 11.5 3a8.5 8.5 0 0 1 8.5 8.5Z" />
                                    <path stroke-linecap="round" stroke-width="1.8" d="M8 11.5h8" />
                                </svg>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium leading-5 text-ink">
                                {{ $notification->data['message'] ?? 'You have a new notification.' }}
                            </p>

                            @if (!empty($notification->data['post_title']))
                                <p class="mt-0.5 truncate text-xs text-muted">
                                    {{ $notification->data['post_title'] }}
                                </p>
                            @endif

                            <div class="mt-1 flex items-center justify-between">
                                <span class="text-[11px] text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                @if ($isUnread)
                                    <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                @endif
                            </div>
                        </div>
                    </button>
                </form>
            @empty
                <div class="px-4 py-8 text-center">
                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-paper">
                        <svg class="h-5 w-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M15 17h5l-1.5-1.5V11a6.5 6.5 0 0 0-13 0v4.5L4 17h5m6 0a3 3 0 0 1-6 0" />
                        </svg>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-ink">No notifications yet</p>
                    <p class="mt-0.5 text-xs text-muted">Your activity will appear here.</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        <div class="border-t border-border bg-paper/50 px-4 py-2.5 text-center">
            <a href="{{ route('notifications.index') }}" class="text-xs font-semibold text-primary transition hover:opacity-80">
                View all notifications
            </a>
        </div>

    </div>

</div>