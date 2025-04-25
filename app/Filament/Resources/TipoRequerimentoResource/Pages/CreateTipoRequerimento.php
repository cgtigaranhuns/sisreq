<?php

namespace App\Filament\Resources\TipoRequerimentoResource\Pages;

use App\Filament\Resources\TipoRequerimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTipoRequerimento extends CreateRecord
{
    protected static string $resource = TipoRequerimentoResource::class;
    protected static ?string $title = 'Novo Tipo de Requerimento';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}