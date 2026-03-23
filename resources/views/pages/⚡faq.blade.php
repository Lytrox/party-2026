<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('FAQ')] class extends Component {
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-6 pb-8">

    {{-- Hero banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-linear-to-br from-sky-500 via-cyan-500 to-teal-500 p-8 text-white shadow-lg">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15),transparent_60%)]"></div>
        <div class="relative">
            <div class="mb-1 flex items-center gap-2 opacity-80">
                <flux:icon name="question-mark-circle" class="size-4" />
                <span class="text-xs font-semibold uppercase tracking-widest">{{ __('faq.title') }}</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight">{{ __('faq.title') }}</h1>
            <p class="mt-1 text-cyan-100">{{ __('faq.subtitle') }}</p>
        </div>
    </div>

    {{-- FAQ items --}}
    <div class="flex flex-col gap-4">
        @foreach(__('faq.items') as $item)
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-sky-50 dark:bg-sky-900/20"></div>
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-400">
                        <flux:icon name="question-mark-circle" class="size-5" />
                    </div>
                    <div class="flex-1">
                        <flux:heading size="sm" class="font-semibold tracking-wide text-neutral-800 dark:text-neutral-100">
                            {{ $item['question'] }}
                        </flux:heading>
                        <div class="mt-2 space-y-2">
                            @foreach(explode("\n\n", $item['answer']) as $paragraph)
                                <flux:text class="text-neutral-600 dark:text-neutral-400">{{ $paragraph }}</flux:text>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
