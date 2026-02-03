<?php

namespace App\Filament\Resources\UserOptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UserOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('user.username')
                    ->translateLabel()
                    ->relationship('user', 'username')
                    ->required(),
                Select::make('attending')
                    ->label('user-option.attending')
                    ->translateLabel()
                    ->options([
                        'yes' => __('user-option.attending_options.yes'),
                        'no' => __('user-option.attending_options.no'),
                        'maybe' => __('user-option.attending_options.maybe'),
                    ])
                    ->default('maybe')
                    ->required(),
                Toggle::make('allergies')
                    ->label('user-option.allergies')
                    ->translateLabel()
                    ->live()
                    ->default(false),
                Textarea::make('allergies_description')
                    ->label('user-option.allergies_description')
                    ->translateLabel()
                    ->default(null)
                    ->helperText(__('user-option.allergies_helper'))
                    ->visible(fn(Get $get) => $get('allergies') === true)
                    ->required(fn(Get $get) => $get('allergies') === true)
                    ->columnSpanFull(),
                Textarea::make('providing_stuff')
                    ->label('user-option.providing_stuff')
                    ->translateLabel()
                    ->default(null)
                    ->helperText(__('user-option.providing_stuff_helper'))
                    ->columnSpanFull(),
                Toggle::make('drinking_alcohol')
                    ->label('user-option.drinking_alcohol')
                    ->translateLabel()
                    ->default(false),
                Toggle::make('bringing_fursuit')
                    ->label('user-option.bringing_fursuit')
                    ->translateLabel()
                    ->default(false),
                Textarea::make('comments')
                    ->label('user-option.comments')
                    ->translateLabel()
                    ->default(null)
                    ->helperText(__('user-option.comments_helper'))
                    ->columnSpanFull(),
            ]);
    }
}
