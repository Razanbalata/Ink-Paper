@props([
    'label' => null,
    'name',
    'type' => 'text',
])

<div class="space-y-2">

    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-ink">
            {{ $label }}
        </label>
    @endif

    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
        {{ $attributes->merge([
            'class' =>
                'w-full rounded-lg border border-border bg-white px-4 py-3 text-sm outline-none transition placeholder:text-muted focus:border-primary focus:ring-2 focus:ring-primary/10',
        ]) }}>

</div>
