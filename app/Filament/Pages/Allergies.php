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

class Allergies extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.allergies';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    public static function getNavigationLabel(): string
    {
        return __('Dietary Requirements');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Registrations');
    }

    public function getTitle(): string
    {
        return __('Dietary Requirements');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Rsvp::query()
                    ->where(fn ($query) => $query
                        ->where('has_allergies', true)
                        ->orWhere('is_vegetarian', true)
                        ->orWhere('is_vegan', true)
                    )
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

                TextColumn::make('allergies')
                    ->label(__('Allergies & Intolerances'))
                    ->wrap()
                    ->placeholder('—')
                    ->searchable(),

                IconColumn::make('is_vegetarian')
                    ->label(__('Vegetarian'))
                    ->boolean(),

                IconColumn::make('is_vegan')
                    ->label(__('Vegan'))
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('attending')
                    ->label(__('Attending')),

                TernaryFilter::make('has_allergies')
                    ->label(__('Has allergies')),

                TernaryFilter::make('is_vegetarian')
                    ->label(__('Vegetarian')),

                TernaryFilter::make('is_vegan')
                    ->label(__('Vegan')),
            ])
            ->emptyStateHeading(__('No dietary requirements reported'))
            ->emptyStateDescription(__('No guests have reported any allergies, intolerances, or dietary preferences.'))
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
