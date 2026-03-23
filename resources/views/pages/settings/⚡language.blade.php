<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Language settings')] class extends Component {
    public string $locale = '';

    public function mount(): void
    {
        $this->locale = Auth::user()->preferred_locale ?? app()->getLocale();
    }

    public function updateLocale(): void
    {
        $this->validate([
            'locale' => ['required', 'string', 'in:de,en'],
        ]);

        $user = Auth::user();
        $user->preferred_locale = $this->locale;
        $user->save();

        App::setLocale($this->locale);

        $this->dispatch('locale-updated');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Language settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Language')" :subheading="__('Choose your preferred language')">
        <form wire:submit="updateLocale" class="my-6 w-full space-y-6">
            <flux:radio.group wire:model="locale" variant="segmented">
                <flux:radio value="de">{{ __('German') }}</flux:radio>
                <flux:radio value="en">{{ __('English') }}</flux:radio>
            </flux:radio.group>

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">
                    {{ __('Save') }}
                </flux:button>

                <x-action-message on="locale-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-pages::settings.layout>
</section>
