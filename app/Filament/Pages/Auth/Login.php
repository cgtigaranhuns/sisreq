<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Support\Htmlable;
//use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{

    public function getHeading(): string|Htmlable
    {
        //return  env('LDAP_ADM_BASE_DN');
        return  config('app.name');
      //  return  config('app.name') . '  ' . config('nome_instituicao');
       
    }
    public function getSubheading(): string|Htmlable
    {
        return 'Sistema de Requerimentos';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('matricula')
                    ->label('Matrícula')
                    ->required()
                    ->autocomplete()
                    ->autofocus()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $connection = strlen($state) < 11 ? 'adm' : 'labs';
                        $set('ldap_connection', $connection);
                    })
                    ->validationMessages([
                        'required' => 'O campo usuário é obrigatório',
                    ]),
                
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required()
                    ->revealable()
                    ->validationMessages([
                        'required' => 'O campo senha é obrigatório',
                    ]),
                
                Hidden::make('ldap_connection')
                    ->default('adm'),
                
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'matricula' => $data['matricula'],
            'password' => $data['password'],
            'connection' => $data['ldap_connection'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
            'data.password' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            return parent::authenticate();
        } catch (ValidationException $e) {
            session()->flash(
                'errors',
                array_merge(session()->get('errors', []), $e->errors())
            );

            throw $e;
        }
    }
}