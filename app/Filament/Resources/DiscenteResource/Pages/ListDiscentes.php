<?php

namespace App\Filament\Resources\DiscenteResource\Pages;

use App\Filament\Resources\DiscenteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiscentes extends ListRecords
{
    protected static string $resource = DiscenteResource::class;
   

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo Dicente'),
        ];
    }
}