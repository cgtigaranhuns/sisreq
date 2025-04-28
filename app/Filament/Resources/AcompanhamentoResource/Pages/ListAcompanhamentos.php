<?php

namespace App\Filament\Resources\AcompanhamentoResource\Pages;

use App\Filament\Resources\AcompanhamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcompanhamentos extends ListRecords
{
    protected static string $resource = AcompanhamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Acompanhamento'),
        ];
    }
}