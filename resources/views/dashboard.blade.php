<x-layouts::app :title="__('Dashboard')">
    @php
        $party = config('party');
        $date = \Carbon\Carbon::parse($party['date']);
        $now = \Carbon\Carbon::now();
        $daysLeft = (int) $now->diffInDays($date, false);
        $lat = (float) $party['location']['lat'];
        $lon = (float) $party['location']['lon'];
        $offset = 0.008;
        $mapUrl = "https://www.openstreetmap.org/export/embed.html?bbox="
            . ($lon - $offset) . "%2C" . ($lat - $offset) . "%2C"
            . ($lon + $offset) . "%2C" . ($lat + $offset)
            . "&layer=mapnik&marker={$lat}%2C{$lon}";
        $directionsUrl = "https://www.openstreetmap.org/?mlat={$lat}&mlon={$lon}#map=15/{$lat}/{$lon}";
        $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query={$lat},{$lon}";
        $appleMapsUrl = "https://maps.apple.com/?ll={$lat},{$lon}&q=" . urlencode($party['location']['name']);
    @endphp

    <div class="flex h-full w-full flex-1 flex-col gap-6 pb-8">

        {{-- Hero banner --}}
        <div class="relative overflow-hidden rounded-2xl bg-linear-to-br from-violet-600 via-purple-600 to-pink-500 p-8 text-white shadow-lg">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15),transparent_60%)]"></div>
            <div class="relative">
                <div class="mb-1 flex items-center gap-2 opacity-80">
                    <flux:icon name="sparkles" class="size-4" />
                    <span class="text-xs font-semibold uppercase tracking-widest">{{ $party['name'] }}</span>
                </div>
                <h1 class="text-3xl font-bold tracking-tight">
                    {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}
                </h1>
                <p class="mt-1 text-purple-100">
                    {{ __("Here's everything you need to know about the party.") }}
                </p>
            </div>

            @if($daysLeft > 0)
                <div class="relative mt-6 inline-flex items-center gap-3 rounded-xl bg-white/15 px-5 py-3 backdrop-blur-sm">
                    <flux:icon name="clock" class="size-5 shrink-0" />
                    <span class="text-sm font-medium">
                        {{ trans_choice(':days day to go!|:days days to go!', $daysLeft, ['days' => $daysLeft]) }}
                    </span>
                </div>
            @elseif($daysLeft === 0)
                <div class="relative mt-6 inline-flex items-center gap-3 rounded-xl bg-white/15 px-5 py-3 backdrop-blur-sm">
                    <flux:icon name="fire" class="size-5 shrink-0" />
                    <span class="text-sm font-medium">{{ __("It's today! 🎉") }}</span>
                </div>
            @endif
        </div>

        {{-- Info cards: Date & Location always side-by-side on md+ --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Date & time --}}
            <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 transition-shadow hover:shadow-md dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-violet-100 dark:bg-violet-900/30"></div>
                <div class="relative">
                    <div class="mb-4 flex size-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-400">
                        <flux:icon name="calendar-days" class="size-5" />
                    </div>
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Date & Time') }}</flux:text>
                    <flux:heading size="lg" class="mt-1">{{ $date->isoFormat('D. MMMM YYYY') }}</flux:heading>
                    <flux:text class="mt-1 text-neutral-500">
                        {{ $party['time_start'] }} {{ __('Uhr') }}
                        @if($party['time_end'])
                            &ndash; {{ $party['time_end'] }} {{ __('Uhr') }}
                        @endif
                    </flux:text>
                </div>
            </div>

            {{-- Location --}}
            <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 transition-shadow hover:shadow-md dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30"></div>
                <div class="relative">
                    <div class="mb-4 flex size-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400">
                        <flux:icon name="map-pin" class="size-5" />
                    </div>
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Location') }}</flux:text>
                    <flux:heading size="lg" class="mt-1">{{ $party['location']['name'] }}</flux:heading>
                    <flux:text class="mt-1 text-neutral-500">{{ $party['location']['address'] }}</flux:text>
                    <flux:text class="text-neutral-500">{{ $party['location']['city'] }}</flux:text>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="{{ $directionsUrl }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 transition hover:bg-neutral-200 dark:bg-zinc-800 dark:text-neutral-300 dark:hover:bg-zinc-700">
                            <flux:icon name="map" class="size-3.5" />
                            {{ __('OpenStreetMap') }}
                        </a>
                        <a href="{{ $googleMapsUrl }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 transition hover:bg-neutral-200 dark:bg-zinc-800 dark:text-neutral-300 dark:hover:bg-zinc-700">
                            <flux:icon name="map-pin" class="size-3.5" />
                            {{ __('Google Maps') }}
                        </a>
                        <a href="{{ $appleMapsUrl }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-1.5 rounded-lg bg-neutral-100 px-3 py-1.5 text-xs font-medium text-neutral-700 transition hover:bg-neutral-200 dark:bg-zinc-800 dark:text-neutral-300 dark:hover:bg-zinc-700">
                            <flux:icon name="map-pin" class="size-3.5" />
                            {{ __('Apple Maps') }}
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Registration CTA --}}
        <a href="{{ route('registration') }}" wire:navigate class="group relative block overflow-hidden rounded-2xl bg-linear-to-br from-amber-400 to-orange-500 p-6 shadow-sm transition-shadow hover:shadow-md">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(255,255,255,0.2),transparent_60%)]"></div>
            <div class="relative flex items-center justify-between gap-4 text-white">
                <div class="flex items-center gap-4">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-white/20">
                        <flux:icon name="party-popper" class="size-5" />
                    </div>
                    <div>
                        <div class="font-semibold">{{ __('Register for the party') }}</div>
                        <div class="text-sm text-amber-100">{{ __('Click here to register') }}</div>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-2 rounded-xl border-2 border-white px-5 py-2.5 text-sm font-bold text-white transition-colors group-hover:bg-white/20">
                    {{ __('Register now') }}
                    <flux:icon name="arrow-right" class="size-4" />
                </div>
            </div>
        </a>

        {{-- Map --}}
        <div class="overflow-hidden rounded-2xl shadow-sm ring-1 ring-neutral-100 dark:ring-neutral-800">
            <div class="flex items-center gap-3 bg-white px-6 py-4 dark:bg-zinc-900">
                <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400">
                    <flux:icon name="map" class="size-4" />
                </div>
                <div>
                    <flux:text class="font-medium">{{ $party['location']['name'] }}</flux:text>
                    <flux:text class="text-xs text-neutral-400">{{ $party['location']['address'] }}, {{ $party['location']['city'] }}</flux:text>
                </div>
            </div>
            <iframe
                src="{{ $mapUrl }}"
                class="h-[500px] w-full"
                loading="lazy"
                title="{{ __('Party location map') }}"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>

    </div>
</x-layouts::app>
