<?php

namespace App\Filament\Resources\UserOptions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserOptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.username')
                    ->label('user.username')
                    ->translateLabel(),
                TextEntry::make('attending')
                    ->label('user-option.attending')
                    ->translateLabel()
                    ->badge(),
                IconEntry::make('allergies')
                    ->label('user-option.allergies')
                    ->translateLabel()
                    ->boolean(),
                TextEntry::make('allergies_description')
                    ->label('user-option.allergies_description')
                    ->translateLabel()
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('providing_stuff')
                    ->label('user-option.providing_stuff')
                    ->translateLabel()
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('drinking_alcohol')
                    ->label('user-option.drinking_alcohol')
                    ->translateLabel()
                    ->boolean(),
                IconEntry::make('bringing_fursuit')
                    ->label('user-option.bringing_fursuit')
                    ->translateLabel()
                    ->boolean(),
                TextEntry::make('comments')
                    ->label('user-option.comments')
                    ->translateLabel()
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
