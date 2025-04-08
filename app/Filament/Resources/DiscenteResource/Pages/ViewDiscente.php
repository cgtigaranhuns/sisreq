<?php

namespace App\Filament\Resources\DiscenteResource\Pages;

use App\Filament\Resources\DiscenteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDiscente extends ViewRecord
{
    protected static string $resource = DiscenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
