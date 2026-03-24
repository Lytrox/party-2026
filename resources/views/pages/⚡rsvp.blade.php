<?php

use App\Models\Rsvp;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Registration')] class extends Component {
    public string $badgeName = '';
    public string $attending = '';
    public bool $hasAllergies = false;
    public string $allergies = '';
    public string $bringing = '';
    public bool $bringingMusicEquipment = false;
    public bool $drinkingAlcohol = false;
    public bool $bringingFursuit = false;
    public bool $isVegetarian = false;
    public bool $isVegan = false;

    public function mount(): void
    {
        $rsvp = Auth::user()->rsvp;

        if ($rsvp) {
            $this->attending = match($rsvp->attending) {
                true  => '1',
                false => '0',
                default => '',
            };
            $this->hasAllergies = $rsvp->has_allergies;
            $this->allergies = $rsvp->allergies ?? '';
            $this->bringing = $rsvp->bringing ?? '';
            $this->bringingMusicEquipment = $rsvp->bringing_music_equipment;
            $this->drinkingAlcohol = $rsvp->drinking_alcohol;
            $this->bringingFursuit = $rsvp->bringing_fursuit;
            $this->badgeName = $rsvp->badge_name ?? '';
            $this->isVegetarian = $rsvp->is_vegetarian;
            $this->isVegan = $rsvp->is_vegan;
        }
    }

    #[Computed]
    public function othersBringing(): Collection
    {
        return Rsvp::query()
            ->where('user_id', '!=', Auth::id())
            ->whereNotNull('bringing')
            ->where('bringing', '!=', '')
            ->where('attending', true)
            ->with('user:id,name')
            ->get(['user_id', 'bringing', 'badge_name']);
    }

    #[Computed]
    public function registrationDeadline(): ?Carbon
    {
        $deadline = config('party.registration_deadline');

        return $deadline ? Carbon::parse($deadline) : null;
    }

    #[Computed]
    public function registrationClosed(): bool
    {
        return $this->registrationDeadline !== null && Carbon::now()->isAfter($this->registrationDeadline);
    }

    public function save(): void
    {
        abort_if($this->registrationClosed, 403);

        $this->validate([
            'badgeName' => ['required', 'string', 'max:100'],
            'attending' => ['nullable', 'in:,0,1'],
            'hasAllergies' => ['required', 'boolean'],
            'allergies' => ['nullable', 'string', 'max:1000', 'required_if:hasAllergies,true'],
            'bringing' => ['nullable', 'string', 'max:1000'],
            'bringingMusicEquipment' => ['required', 'boolean'],
            'drinkingAlcohol' => ['required', 'boolean'],
            'bringingFursuit' => ['required', 'boolean'],
            'isVegetarian' => ['required', 'boolean'],
            'isVegan' => ['required', 'boolean'],
        ]);

        Auth::user()->rsvp()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'badge_name' => $this->badgeName,
                'attending' => match($this->attending) {
                    '1' => true,
                    '0' => false,
                    default => null,
                },
                'has_allergies' => $this->hasAllergies,
                'allergies' => $this->hasAllergies ? $this->allergies : null,
                'bringing' => $this->bringing ?: null,
                'bringing_music_equipment' => $this->bringingMusicEquipment,
                'drinking_alcohol' => $this->drinkingAlcohol,
                'bringing_fursuit' => $this->bringingFursuit,
                'is_vegetarian' => $this->isVegetarian,
                'is_vegan' => $this->isVegan,
            ]
        );

        $this->dispatch('rsvp-saved');
    }
}; ?>

<div class="flex h-full w-full flex-1 flex-col gap-6 pb-8">

    {{-- Hero banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-linear-to-br from-pink-500 via-fuchsia-600 to-violet-600 p-8 text-white shadow-lg">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.15),transparent_60%)]"></div>
        <div class="relative">
            <div class="mb-1 flex items-center gap-2 opacity-80">
                <flux:icon name="ticket" class="size-4" />
                <span class="text-xs font-semibold uppercase tracking-widest">{{ __('Registration') }}</span>
            </div>
            <h1 class="text-3xl font-bold tracking-tight">{{ __('Are you coming?') }}</h1>
            <p class="mt-1 text-fuchsia-100">{{ __("Let us know — we'd love to have you there!") }}</p>
        </div>
    </div>

    {{-- Deadline notice --}}
    @if($this->registrationDeadline !== null)
        @if($this->registrationClosed)
            <div class="flex items-center gap-3 rounded-2xl bg-red-50 px-5 py-4 ring-1 ring-red-200 dark:bg-red-950/40 dark:ring-red-800">
                <flux:icon name="lock-closed" class="size-5 shrink-0 text-red-500 dark:text-red-400" />
                <flux:text class="font-medium text-red-700 dark:text-red-300">{{ __('Registration is closed.') }}</flux:text>
            </div>
        @else
            <div class="flex items-center gap-3 rounded-2xl bg-amber-50 px-5 py-4 ring-1 ring-amber-200 dark:bg-amber-950/40 dark:ring-amber-800">
                <flux:icon name="clock" class="size-5 shrink-0 text-amber-500 dark:text-amber-400" />
                <flux:text class="font-medium text-amber-700 dark:text-amber-300">
                    {{ __('Registration closes on :date at :time.', [
                        'date' => $this->registrationDeadline->isoFormat('LL'),
                        'time' => $this->registrationDeadline->format('H:i'),
                    ]) }}
                </flux:text>
            </div>
        @endif
    @endif

    <form wire:submit="save" class="flex flex-col gap-4">


        {{-- Attending --}}
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
            <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-violet-100 dark:bg-violet-900/30"></div>
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-400">
                    <flux:icon name="hand-raised" class="size-5" />
                </div>
                <div class="flex-1">
                    <flux:text class="mb-3 text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Attendance') }}</flux:text>
                    <flux:field>
                        <flux:label>{{ __('Are you attending?') }}</flux:label>
                        <flux:select wire:model="attending" :disabled="$this->registrationClosed">
                            <flux:select.option value="">{{ __('Not decided yet') }}</flux:select.option>
                            <flux:select.option value="1">{{ __('Yes, I\'ll be there!') }}</flux:select.option>
                            <flux:select.option value="0">{{ __('No, I can\'t make it') }}</flux:select.option>
                        </flux:select>
                        <flux:error name="attending" />
                    </flux:field>
                </div>
            </div>
        </div>

        {{-- Badge name --}}
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
            <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-indigo-100 dark:bg-indigo-900/30"></div>
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-400">
                    <flux:icon name="identification" class="size-5" />
                </div>
                <div class="flex-1">
                    <flux:text class="mb-3 text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Name Badge') }}</flux:text>
                    <flux:field>
                        <flux:label :badge="__('Required')">{{ __('Badge name') }}</flux:label>
                        <flux:description>{{ __('This name will be printed on your badge.') }}</flux:description>
                        <flux:input wire:model="badgeName" maxlength="100" required :disabled="$this->registrationClosed" />
                        <flux:error name="badgeName" />
                    </flux:field>
                </div>
            </div>
        </div>

        {{-- Allergies & Diet --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Allergies --}}
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-rose-100 dark:bg-rose-900/30"></div>
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-400">
                        <flux:icon name="exclamation-triangle" class="size-5" />
                    </div>
                    <div class="flex-1 space-y-4">
                        <flux:text class="text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Allergies & Intolerances') }}</flux:text>
                        <flux:field>
                            <flux:label>{{ __('Do you have any allergies and/or intolerances?') }}</flux:label>
                            <flux:switch wire:model.live="hasAllergies" :disabled="$this->registrationClosed" />
                            <flux:error name="hasAllergies" />
                        </flux:field>
                        @if ($hasAllergies)
                            <flux:field>
                                <flux:label :badge="__('Required')">{{ __('Please describe your allergies') }}</flux:label>
                                <flux:textarea wire:model="allergies" rows="3" :placeholder="__('e.g. nuts, gluten, lactose...')" :disabled="$this->registrationClosed" />
                                <flux:error name="allergies" />
                            </flux:field>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Diet --}}
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-lime-100 dark:bg-lime-900/30"></div>
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-lime-100 text-lime-600 dark:bg-lime-900/40 dark:text-lime-400">
                        <flux:icon name="heart" class="size-5" />
                    </div>
                    <div class="flex-1">
                        <flux:text class="mb-3 text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Diet') }}</flux:text>
                        <div class="space-y-3">
                            <flux:field>
                                <flux:checkbox wire:model.live="isVegetarian" :label="__('I am vegetarian')" :disabled="$this->registrationClosed" />
                                <flux:error name="isVegetarian" />
                            </flux:field>
                            <flux:field>
                                <flux:checkbox wire:model.live="isVegan" :label="__('I am vegan')" :disabled="$this->registrationClosed" />
                                <flux:error name="isVegan" />
                            </flux:field>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Bringing something --}}
        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
            <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-amber-100 dark:bg-amber-900/30"></div>
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <flux:icon name="gift" class="size-5" />
                </div>
                <div class="flex-1 space-y-4">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Bringing Something?') }}</flux:text>
                    <flux:field>
                        <flux:label>{{ __('Are you bringing anything?') }}</flux:label>
                        <flux:description>{{ __('e.g. a cake, a hookah, snacks, drinks...') }}</flux:description>
                        <flux:textarea wire:model="bringing" rows="2" :placeholder="__('Tell us what you\'d like to bring (optional)')" :disabled="$this->registrationClosed" />
                        <flux:error name="bringing" />
                    </flux:field>
                    <flux:field>
                        <flux:checkbox wire:model="bringingMusicEquipment" :label="__('I want to bring music equipment (speakers, DJ setup, etc.)')" :disabled="$this->registrationClosed" />
                        <flux:error name="bringingMusicEquipment" />
                    </flux:field>
                </div>
            </div>
        </div>

        {{-- What others are bringing --}}
        @if($this->othersBringing->isNotEmpty())
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-amber-50 dark:bg-amber-900/20"></div>
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-6">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-500 dark:bg-amber-900/30 dark:text-amber-400">
                        <flux:icon name="eye" class="size-5" />
                    </div>
                    <div class="flex-1">
                        <flux:text class="mb-3 text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('What others are bringing') }}</flux:text>
                        <ul class="space-y-2">
                            @foreach($this->othersBringing as $rsvp)
                                <li class="flex items-start gap-2">
                                    <flux:icon name="user-circle" class="mt-0.5 size-4 shrink-0 text-neutral-400" />
                                    <span class="text-sm text-neutral-700 dark:text-neutral-300">
                                        <span class="font-medium">{{ mb_substr($rsvp->badge_name ?? $rsvp->user?->name ?? '?', 0, 3) }}***</span>:
                                        {{ $rsvp->bringing }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- Drinking & Fursuit --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            {{-- Drinking alcohol --}}
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30"></div>
                <div class="relative flex items-start gap-4">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-400">
                        <flux:icon name="beaker" class="size-5" />
                    </div>
                    <div class="flex-1">
                        <flux:text class="mb-3 text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Alcohol') }}</flux:text>
                        <flux:field>
                            <flux:label>{{ __('Will you be drinking alcohol?') }}</flux:label>
                            <flux:switch wire:model="drinkingAlcohol" :disabled="$this->registrationClosed" />
                            <flux:error name="drinkingAlcohol" />
                        </flux:field>
                    </div>
                </div>
            </div>

            {{-- Fursuit --}}
            <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-neutral-100 dark:bg-zinc-900 dark:ring-neutral-800">
                <div class="absolute top-0 right-0 h-24 w-24 translate-x-6 -translate-y-6 rounded-full bg-sky-100 dark:bg-sky-900/30"></div>
                <div class="relative flex items-start gap-4">
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-400">
                        <flux:icon name="face-smile" class="size-5" />
                    </div>
                    <div class="flex-1">
                        <flux:text class="mb-3 text-xs font-semibold uppercase tracking-wider text-neutral-400">{{ __('Fursuit') }}</flux:text>
                        <flux:field>
                            <flux:label>{{ __('Are you bringing your fursuit?') }}</flux:label>
                            <flux:switch wire:model="bringingFursuit" :disabled="$this->registrationClosed" />
                            <flux:error name="bringingFursuit" />
                        </flux:field>
                    </div>
                </div>
            </div>

        </div>

        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <flux:button variant="primary" type="submit" icon="check" class="px-8" :disabled="$this->registrationClosed">
                {{ __('Save registration') }}
            </flux:button>
            <x-action-message on="rsvp-saved" class="text-sm text-emerald-600 dark:text-emerald-400">
                {{ __('Saved!') }}
            </x-action-message>
        </div>

    </form>

</div>
