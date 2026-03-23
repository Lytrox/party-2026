@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand {{ $attributes }}>
        <x-slot name="logo">
            <img src="/images/logo-dark.svg" alt="{{ config('app.name') }}" width="5820" height="2851" class="h-20 w-auto max-w-none dark:hidden" />
            <img src="/images/logo-light.svg" alt="{{ config('app.name') }}" width="6078" height="3085" class="hidden h-20 w-auto max-w-none dark:block" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand {{ $attributes }}>
        <x-slot name="logo">
            <img src="/images/logo-dark.svg" alt="{{ config('app.name') }}" width="5820" height="2851" class="h-20 w-auto max-w-none dark:hidden" />
            <img src="/images/logo-light.svg" alt="{{ config('app.name') }}" width="6078" height="3085" class="hidden h-20 w-auto max-w-none dark:block" />
        </x-slot>
    </flux:brand>
@endif
