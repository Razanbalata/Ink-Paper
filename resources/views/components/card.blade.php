@props(['post' => null])

@if ($post)
    <article class="group flex h-full flex-col justify-between rounded-2xl border border-border bg-white p-5 transition-all duration-200 hover:-translate-y-1 hover:shadow-md">

        <div>

            {{-- Cover --}}
            <a
                href="{{ route('posts.show', $post) }}"
                class="relative flex h-52 items-center justify-center overflow-hidden rounded-lg bg-zinc-100"
            >

                @if($post->cover_image)

                    <img
                        src="{{ asset('storage/' . $post->cover_image) }}"
                        alt="{{ $post->title }}"
                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    >

                @else

                    <span class="font-serif text-5xl font-bold text-zinc-300 transition-transform duration-300 group-hover:scale-110">
                        {{ str_pad($post->id, 2, '0', STR_PAD_LEFT) }}
                    </span>

                @endif


                {{-- Category --}}
                @if($post->category)

                    <div class="absolute left-3 top-3">
                        <x-badge variant="primary">
                            {{ $post->category->name }}
                        </x-badge>
                    </div>

                @endif

            </a>


            {{-- Content --}}
            <div class="mt-6">

                <h3 class="font-serif text-2xl font-bold leading-snug text-ink transition group-hover:text-primary">

                    <a href="{{ route('posts.show', $post) }}">
                        {{ $post->title }}
                    </a>

                </h3>


                @if($post->excerpt)

                    <p class="mt-3 line-clamp-2 text-sm leading-relaxed text-muted">
                        {{ $post->excerpt }}
                    </p>

                @endif

            </div>

        </div>


        {{-- Meta --}}
        <div class="mt-8 flex items-center justify-between border-t border-border/50 pt-4">

            <div class="flex items-center gap-3">

                <x-avatar
                    name="{{ $post->user->name }}"
                    size="sm"
                />

                <div>

                    <p class="text-sm font-semibold text-ink">
                        {{ $post->user->name }}
                    </p>

                    <p class="text-xs text-muted">
                        {{ $post->read_time }} min read
                    </p>

                </div>

            </div>


            <span class="text-xs font-medium text-muted">
                {{ $post->published_at?->format('M d') }}
            </span>

        </div>

    </article>
@else
    <div {{ $attributes->merge(['class' => 'rounded-2xl border border-border bg-white p-5 shadow-sm']) }}>
        {{ $slot }}
    </div>
@endif