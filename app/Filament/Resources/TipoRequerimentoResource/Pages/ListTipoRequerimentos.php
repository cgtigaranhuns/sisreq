<?php

namespace App\Filament\Resources\TipoRequerimentoResource\Pages;

use App\Filament\Resources\TipoRequerimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoRequerimentos extends ListRecords
{
    protected static string $resource = TipoRequerimentoResource::class;
    protected static ?string $title = 'Tipos de Requerimento';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo Tipo de Requerimento'),
        ];
    }
}