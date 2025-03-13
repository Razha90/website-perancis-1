@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-secondary_blue text-primary_white  text-secondary_blue rounded-md shadow-sm ']) }}>
