<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Privacy Policy')] #[Layout('layouts.public')] class extends Component {
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-6 pb-8">

    {{-- Hero banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-linear-to-br from-violet-500 via-purple-500 to-indigo-500 p-8 text-white shadow-lg">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15),transparent_60%)]"></div>
        <div class="relative">
            <div class="mb-1 flex items-center gap-2 opacity-80">
                <flux:icon name="shield-check" class="size-4" />
                <span class="text-xs font-semibold uppercase tracking-widest">{{ __('privacy-policy.title') }}</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight">{{ __('privacy-policy.title') }}</h1>
            <p class="mt-1 text-violet-100">{{ __('privacy-policy.subtitle') }}</p>
        </div>
    </div>

    {{-- Sections --}}
    <div class="flex flex-col gap-4">
        @foreach(__('privacy-policy.sections') as $section)
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-violet-50 dark:bg-violet-900/20"></div>
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-400">
                        <flux:icon name="shield-check" class="size-5" />
                    </div>
                    <div class="flex-1">
                        <flux:heading size="sm" class="font-semibold tracking-wide text-neutral-800 dark:text-neutral-100">
                            {{ $section['heading'] }}
                        </flux:heading>

                        @if(!empty($section['body']))
                            <flux:text class="mt-2 text-neutral-600 dark:text-neutral-400">{{ $section['body'] }}</flux:text>
                        @endif

                        @if(!empty($section['link']))
                            <flux:link :href="$section['link']['url']" target="_blank" rel="noopener noreferrer" class="mt-1.5 inline-flex items-center gap-1 text-sm">
                                {{ $section['link']['label'] }}
                                <flux:icon name="arrow-top-right-on-square" class="size-3.5" />
                            </flux:link>
                        @endif

                        @if(!empty($section['items']))
                            <ul class="mt-2 space-y-1.5">
                                @foreach($section['items'] as $item)
                                    <li class="flex items-start gap-2">
                                        <flux:icon name="check" class="mt-0.5 size-4 shrink-0 text-violet-500 dark:text-violet-400" />
                                        <flux:text class="text-neutral-600 dark:text-neutral-400">{{ $item }}</flux:text>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
