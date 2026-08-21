@props([
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'bg-primary text-white hover:opacity-90',
        'secondary' => 'border border-border bg-white text-ink hover:bg-zinc-50',
        'ghost' => 'text-ink hover:bg-zinc-100',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ];
@endphp

<button type="{{ $type }}"
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center justify-center rounded-lg px-5 py-2.5 text-sm font-semibold transition ' .
            $variants[$variant],
    ]) }}>
    {{ $slot }}
</button>
