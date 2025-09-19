<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Novo Usuário';
    protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }
}