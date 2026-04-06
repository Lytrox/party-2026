<?php

namespace App\Filament\Resources\Rsvps\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RsvpsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('badge_name')
                    ->label(__('Badge name'))
                    ->searchable()
                    ->placeholder('—'),

                IconColumn::make('attending')
                    ->label(__('Attending'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                IconColumn::make('has_allergies')
                    ->label(__('Allergies'))
                    ->boolean(),

                IconColumn::make('drinking_alcohol')
                    ->label(__('Alcohol'))
                    ->boolean(),

                IconColumn::make('bringing_fursuit')
                    ->label(__('Fursuit'))
                    ->boolean(),

                TextColumn::make('updated_at')
                    ->label(__('Last updated'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('attending')
                    ->label(__('Attending')),

                TernaryFilter::make('bringing_fursuit')
                    ->label(__('Bringing fursuit')),

            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
