<?php

namespace App\Filament\Admin\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5, 60); // Max 5 attempts per 60 seconds
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        return parent::authenticate();
    }

    public function getHeading(): string | Htmlable | null
    {
        return "សូមបញ្ចូលព័ត៌មានអ្នកប្រើប្រាស់របស់អ្នក!!!";
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('ឈ្មោះគណនី')
            ->placeholder('ឈ្មោះគណនី')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('លេខសំងាត់')
            ->placeholder('លេខសំងាត់')
            ->password()
            ->required();
    }

    protected function getRememberFormComponent(): Component
    {
        return \Filament\Forms\Components\Hidden::make('remember')
            ->default(false);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getAuthenticateFormAction(): \Filament\Actions\Action
    {
        return parent::getAuthenticateFormAction()
            ->label('ចូល');
    }
}
