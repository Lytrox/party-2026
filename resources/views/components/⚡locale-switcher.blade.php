<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    public string $locale = '';

    public function mount(): void
    {
        $this->locale = Auth::user()->preferred_locale ?? app()->getLocale();
    }

    public function switchLocale(string $locale): void
    {
        $this->validate(['locale' => ['required', 'string', 'in:de,en']]);

        $this->locale = $locale;

        $user = Auth::user();
        $user->preferred_locale = $locale;
        $user->save();

        App::setLocale($locale);

        $this->js('window.location.reload()');
    }
};
?>

<div class="flex items-center gap-1 px-2 py-1">
    <button
        wire:click="switchLocale('de')"
        class="rounded-md px-2.5 py-1 text-xs font-semibold transition
            {{ $locale === 'de'
                ? 'bg-zinc-200 text-zinc-900 dark:bg-zinc-700 dark:text-white'
                : 'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200' }}"
        aria-label="{{ __('German') }}"
    >DE</button>
    <span class="text-zinc-300 dark:text-zinc-600">|</span>
    <button
        wire:click="switchLocale('en')"
        class="rounded-md px-2.5 py-1 text-xs font-semibold transition
            {{ $locale === 'en'
                ? 'bg-zinc-200 text-zinc-900 dark:bg-zinc-700 dark:text-white'
                : 'text-zinc-500 hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200' }}"
        aria-label="{{ __('English') }}"
    >EN</button>
</div>
