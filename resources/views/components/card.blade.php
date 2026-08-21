@props([
    'padding' => true,
])

<article
    {{ $attributes->merge([
        'class' => 'rounded-xl border border-border bg-white transition-all ' . ($padding ? 'p-6' : ''),
    ]) }}
>
    {{ $slot }}
</article>