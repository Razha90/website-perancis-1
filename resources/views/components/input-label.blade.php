@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-sans text-sm text-secondary_blue ']) }}>
    {{ $value ?? $slot }}
</label>
