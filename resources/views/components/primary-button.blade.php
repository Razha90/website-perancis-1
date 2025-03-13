<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-secondary_blue hover:underline']) }}>
    {{ $slot }}
</button>
