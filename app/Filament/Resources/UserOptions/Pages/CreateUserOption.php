<?php

namespace App\Filament\Resources\UserOptions\Pages;

use App\Filament\Resources\UserOptions\UserOptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserOption extends CreateRecord
{
    protected static string $resource = UserOptionResource::class;
}
