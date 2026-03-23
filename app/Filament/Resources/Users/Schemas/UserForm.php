<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Resources\Users\Pages\CreateUser;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Profile'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Displayed name'))
                            ->helperText(__('This is not the name that will be printed on the badge. The badge name is defined on the party registration page.'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label(__('Email address'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof CreateUser)
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText(fn ($livewire) => $livewire instanceof CreateUser
                                ? null
                                : __('Leave blank to keep current password')),
                    ]),

                Section::make(__('Permissions'))
                    ->schema([
                        Toggle::make('is_admin')
                            ->label(__('Administrator'))
                            ->helperText(__('Administrators can access the admin panel and manage registrations.')),
                    ]),
            ]);
    }
}
