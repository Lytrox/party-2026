<?php

namespace App\Filament\Resources\UserOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->label('user.username')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('attending')
                    ->label('user-option.attending')
                    ->translateLabel()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'yes' => __('user-option.attending_options.yes'),
                        'no' => __('user-option.attending_options.no'),
                        'maybe' => __('user-option.attending_options.maybe'),
                        default => $state,
                    })
                    ->badge(),
                IconColumn::make('allergies')
                    ->label('user-option.allergies')
                    ->translateLabel()
                    ->boolean(),
                IconColumn::make('drinking_alcohol')
                    ->label('user-option.drinking_alcohol')
                    ->translateLabel()
                    ->boolean(),
                IconColumn::make('bringing_fursuit')
                    ->label('user-option.bringing_fursuit')
                    ->translateLabel()
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('general.created_at')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('general.updated_at')
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
