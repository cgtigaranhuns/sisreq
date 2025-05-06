<?php

namespace App\Filament\Resources\ComunicacaoResource\Pages;

use App\Filament\Resources\ComunicacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComunicacaos extends ListRecords
{
    protected static string $resource = ComunicacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Comunicado'),
        ];
    }
}