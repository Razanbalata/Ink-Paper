<div class="space-y-4">
    @forelse ($followers as $follower)

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('authors.show', $follower) }}" class="flex min-w-0 items-center gap-3">
                <x-avatar :name="$follower->name" size="md" />

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-ink">
                        {{ $follower->name }}
                    </p>

                    <p class="truncate text-xs text-muted">
                        {{ '@' . Str::slug($follower->name) }}
                    </p>
                </div>
            </a>

            @if (auth()->check() && auth()->id() !== $follower->id)
                @php
                    $isFollowingUser = auth()->user()->following()->whereKey($follower->id)->exists();
                @endphp

                @if ($isFollowingUser)
                    <form method="POST" action="{{ route('users.unfollow', $follower) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="shrink-0 rounded-full border border-border px-4 py-2 text-xs font-semibold text-ink transition hover:border-ink">
                            Following
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('users.follow', $follower) }}">
                        @csrf

                        <button type="submit"
                            class="shrink-0 rounded-full bg-ink px-4 py-2 text-xs font-semibold text-paper transition hover:bg-primary">
                            Follow
                        </button>
                    </form>
                @endif
            @elseif (!auth()->check())
                <a href="{{ route('login') }}"
                    class="shrink-0 rounded-full bg-ink px-4 py-2 text-xs font-semibold text-paper transition hover:bg-primary">
                    Follow
                </a>
            @endif
        </div>

    @empty

        <div class="py-10 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10">
                <span class="font-serif text-xl font-bold text-primary">
                    ✦
                </span>
            </div>

            <p class="mt-4 font-serif text-lg font-bold text-ink">
                No followers yet
            </p>

            <p class="mt-1 text-sm text-muted">
                {{ $user->name }} doesn't have any followers yet.
            </p>
        </div>

    @endforelse
</div>

@if ($followers->hasPages())
    <div class="mt-6 border-t border-border pt-4">
        {{ $followers->links() }}
    </div>
@endif
