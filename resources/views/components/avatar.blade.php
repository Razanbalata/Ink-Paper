@props([
    'src' => null,
    'name' => 'User',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-14 w-14 text-lg',
    ];
@endphp

@if ($src)
    <img src="{{ $src }}" alt="{{ $name }}" class="{{ $sizes[$size] }} rounded-full object-cover">
@else
    <div
        class="{{ $sizes[$size] }} flex items-center justify-center rounded-full bg-zinc-200 font-semibold text-zinc-700">
        {{ strtoupper(substr($name, 0, 1)) }}
    </div>
@endif
