<?php

namespace App\Filament\Resources\Rsvps\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RsvpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Name Badge'))
                    ->schema([
                        TextInput::make('badge_name')
                            ->label(__('Badge name'))
                            ->helperText(__('This name will be printed on the badge.'))
                            ->maxLength(100)
                            ->required(),
                    ]),

                Section::make(__('Attendance'))
                    ->columns(2)
                    ->schema([
                        Select::make('attending')
                            ->label(__('Attending'))
                            ->options([
                                '1' => __('Yes'),
                                '0' => __('No'),
                            ])
                            ->nullable()
                            ->placeholder(__('Not decided yet')),

                        Toggle::make('drinking_alcohol')
                            ->label(__('Drinking alcohol')),

                        Toggle::make('bringing_fursuit')
                            ->label(__('Bringing fursuit')),
                    ]),

                Section::make(__('Allergies'))
                    ->schema([
                        Toggle::make('has_allergies')
                            ->label(__('Has allergies'))
                            ->live(),

                        Textarea::make('allergies')
                            ->label(__('Allergy details'))
                            ->rows(3)
                            ->visible(fn ($get) => $get('has_allergies')),
                    ]),

                Section::make(__('Bringing'))
                    ->schema([
                        Textarea::make('bringing')
                            ->label(__('What are you bringing?'))
                            ->helperText(__('e.g. a cake, a hookah, snacks...'))
                            ->rows(2),

                        Toggle::make('bringing_music_equipment')
                            ->label(__('Bringing music equipment')),
                    ]),

                Section::make(__('Diet'))
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_vegetarian')
                            ->label(__('I am vegetarian')),

                        Toggle::make('is_vegan')
                            ->label(__('I am vegan')),
                    ]),
            ]);
    }
}
