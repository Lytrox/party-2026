<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make(__('Invoice details'))
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label(__('Title'))
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('amount')
                        ->label(__('Amount (€)'))
                        ->required()
                        ->numeric()
                        ->prefix('€')
                        ->minValue(0.01),

                    DatePicker::make('invoice_date')
                        ->label(__('Invoice date'))
                        ->required()
                        ->default(now()),

                    Select::make('paid_by_user_id')
                        ->label(__('Paid by'))
                        ->required()
                        ->options(User::query()->where('is_admin', true)->orderBy('name')->pluck('name', 'id'))
                        ->searchable(),

                    Textarea::make('notes')
                        ->label(__('Notes'))
                        ->nullable()
                        ->maxLength(1000)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
