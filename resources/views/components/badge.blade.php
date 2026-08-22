@props([
    'variant' => 'default',
])

@php
    $variants = [
        'default' => 'bg-zinc-100 text-zinc-700',
        'neutral' => 'bg-zinc-100 text-zinc-700',
        'primary' => 'bg-violet-100 text-violet-700',
        'success' => 'bg-green-100 text-green-700',
        'danger' => 'bg-red-100 text-red-700',
    ];
@endphp

<span
    {{ $attributes->merge([
        'class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ' . $variants[$variant],
    ]) }}>
    {{ $slot }}
</span>
