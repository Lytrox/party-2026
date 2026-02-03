<?php

namespace App\Filament\Resources\UserOptions;

use App\Filament\Resources\UserOptions\Pages\CreateUserOption;
use App\Filament\Resources\UserOptions\Pages\EditUserOption;
use App\Filament\Resources\UserOptions\Pages\ListUserOptions;
use App\Filament\Resources\UserOptions\Pages\ViewUserOption;
use App\Filament\Resources\UserOptions\Schemas\UserOptionForm;
use App\Filament\Resources\UserOptions\Schemas\UserOptionInfolist;
use App\Filament\Resources\UserOptions\Tables\UserOptionsTable;
use App\Models\UserOption;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserOptionResource extends Resource
{
    protected static ?string $model = UserOption::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'User option';

    public static function form(Schema $schema): Schema
    {
        return UserOptionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserOptionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserOptionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserOptions::route('/'),
            'create' => CreateUserOption::route('/create'),
            'view' => ViewUserOption::route('/{record}'),
            'edit' => EditUserOption::route('/{record}/edit'),
        ];
    }
}
