<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use l3aro\FilamentTurnstile\Facades\FilamentTurnstileFacade;
use l3aro\FilamentTurnstile\Forms\Turnstile;
use Filament\Auth\Pages\Login as AuthLogin;

class CloudflareLogin extends AuthLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                Turnstile::make('captcha')
                    ->size('flexible'),
            ])
            ->statePath('data');
    }

    protected function throwFailureValidationException(): never
    {
        $this->dispatch(FilamentTurnstileFacade::getResetEventName());

        parent::throwFailureValidationException();
    }
}
