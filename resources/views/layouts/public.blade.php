<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-zinc-800">
        <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mb-6">
                <flux:button
                    icon="arrow-left"
                    variant="ghost"
                    onclick="history.length > 1 ? history.back() : window.location = '{{ route('login') }}'"
                >
                    {{ __('Back') }}
                </flux:button>
            </div>

            {{ $slot }}
        </div>

        @fluxScripts
    </body>
</html>
