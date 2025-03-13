<div class="w-full">
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" x-show="show" class="transition-all duration-500">
        <livewire:components.app-navigation />
    </div>
    <livewire:components.live-chat />
</div>
