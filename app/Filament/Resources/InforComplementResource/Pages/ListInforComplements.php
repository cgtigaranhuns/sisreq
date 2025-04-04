<?php

namespace App\Filament\Resources\InforComplementResource\Pages;

use App\Filament\Resources\InforComplementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInforComplements extends ListRecords
{
    protected static string $resource = InforComplementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
