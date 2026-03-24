<?php

namespace App\Filament\Pages;

use App\Models\User;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class PendingRegistrations extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.pending-registrations';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    public static function getNavigationLabel(): string
    {
        return __('Pending Registrations');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Users');
    }

    public function getTitle(): string
    {
        return __('Pending Registrations');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->doesntHave('rsvp'))
            ->columns([
                TextColumn::make('name')
                    ->label(__('Displayed name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('Email address'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('Registered'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->emptyStateHeading(__('No pending registrations'))
            ->emptyStateDescription(__('All registered users have filled out their party registration.'))
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
