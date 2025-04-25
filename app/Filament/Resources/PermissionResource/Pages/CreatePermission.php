<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;
    protected static ?string $title = 'Nova Permissão';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}