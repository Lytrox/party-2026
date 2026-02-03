<?php

namespace App\Filament\Resources\UserOptions\Pages;

use App\Filament\Resources\UserOptions\UserOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserOptions extends ListRecords
{
    protected static string $resource = UserOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
