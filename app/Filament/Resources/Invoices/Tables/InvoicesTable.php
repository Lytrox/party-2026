<?php

namespace App\Filament\Resources\Invoices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label(__('Amount'))
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('invoice_date')
                    ->label(__('Invoice date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('paidBy.name')
                    ->label(__('Paid by'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('notes')
                    ->label(__('Notes'))
                    ->limit(40)
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label(__('Added'))
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('invoice_date', 'desc')
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
