<?php

namespace App\Filament\Resources\TipoRequerimentoResource\Pages;

use App\Filament\Resources\TipoRequerimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoRequerimento extends EditRecord
{
    protected static string $resource = TipoRequerimentoResource::class;
    protected static ?string $title = 'Editar Tipo de Requerimento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}