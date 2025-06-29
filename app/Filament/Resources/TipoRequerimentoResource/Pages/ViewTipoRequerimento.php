<?php

namespace App\Filament\Resources\TipoRequerimentoResource\Pages;

use App\Filament\Resources\TipoRequerimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTipoRequerimento extends ViewRecord
{
    protected static string $resource = TipoRequerimentoResource::class;
     protected static ?string $title = 'Visualizar Tipo de requerimento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}