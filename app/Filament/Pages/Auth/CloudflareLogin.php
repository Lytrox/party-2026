<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;
use l3aro\FilamentTurnstile\Facades\FilamentTurnstileFacade;
use l3aro\FilamentTurnstile\Forms\Turnstile;
use Filament\Auth\Pages\Login as AuthLogin;
use SensitiveParameter;

class CloudflareLogin extends AuthLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getUsernameFormComponent(),
                $this->getPasswordFormComponent(),
                Turnstile::make('captcha')
                    ->size('flexible'),
            ])
            ->statePath('data');
    }

    protected function getUsernameFormComponent() {
        return TextInput::make('username')
            ->label(__('user.username'))
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return [
            'username' => strtolower($data['username']),
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        $this->dispatch(FilamentTurnstileFacade::getResetEventName());

        throw ValidationException::withMessages([
            'data.username' => __('user.failed_login'),
        ]);
    }
}
