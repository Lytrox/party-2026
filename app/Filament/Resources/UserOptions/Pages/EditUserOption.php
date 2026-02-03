<?php

namespace App\Filament\Resources\UserOptions\Pages;

use App\Filament\Resources\UserOptions\UserOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserOption extends EditRecord
{
    protected static string $resource = UserOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
