<?php

namespace App\Filament\Resources\UserOptions\Pages;

use App\Filament\Resources\UserOptions\UserOptionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserOption extends ViewRecord
{
    protected static string $resource = UserOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
