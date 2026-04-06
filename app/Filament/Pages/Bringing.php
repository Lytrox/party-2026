<?php

namespace App\Filament\Pages;

use App\Models\Rsvp;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class Bringing extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.bringing';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGift;

    public static function getNavigationLabel(): string
    {
        return __('Bringing');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Registrations');
    }

    public function getTitle(): string
    {
        return __('What guests are bringing');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Rsvp::query()
                    ->where(function ($query) {
                        $query->whereNotNull('bringing')
                            ->where('bringing', '!=', '');
                    })
                    ->orWhere('bringing_music_equipment', true)
                    ->with('user')
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('badge_name')
                    ->label(__('Badge name'))
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('bringing')
                    ->label(__('Bringing'))
                    ->wrap()
                    ->placeholder('—')
                    ->searchable(),

                IconColumn::make('bringing_music_equipment')
                    ->label(__('Music equip.'))
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('attending')
                    ->label(__('Attending')),

                TernaryFilter::make('bringing_music_equipment')
                    ->label(__('Bringing music equipment')),
            ])
            ->emptyStateHeading(__('Nobody is bringing anything yet'))
            ->emptyStateDescription(__('Guests who fill in what they are bringing will appear here.'))
            ->emptyStateIcon('heroicon-o-gift');
    }
}
