@props([
    'label' => null,
    'name',
])

<div class="space-y-2">

    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-ink">
            {{ $label }}
        </label>
    @endif

    <textarea id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge([
            'class' =>
                'min-h-32 w-full resize-y rounded-lg border border-border bg-white px-4 py-3 text-sm outline-none transition placeholder:text-muted focus:border-primary focus:ring-2 focus:ring-primary/10',
        ]) }}>{{ $slot }}</textarea>

</div>
