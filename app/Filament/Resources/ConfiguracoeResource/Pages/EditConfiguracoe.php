<?php

namespace App\Filament\Resources\ConfiguracoeResource\Pages;

use App\Filament\Resources\ConfiguracoeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConfiguracoe extends EditRecord
{
    protected static string $resource = ConfiguracoeResource::class;
    protected static ?string $title = 'Editar Configurações do Sistema';

   protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}