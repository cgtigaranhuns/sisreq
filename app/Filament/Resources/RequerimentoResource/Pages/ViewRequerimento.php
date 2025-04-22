<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRequerimento extends ViewRecord
{
    protected static string $resource = RequerimentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
