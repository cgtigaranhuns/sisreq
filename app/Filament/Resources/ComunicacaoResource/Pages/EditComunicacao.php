<?php

namespace App\Filament\Resources\ComunicacaoResource\Pages;

use App\Filament\Resources\ComunicacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComunicacao extends EditRecord
{
    protected static string $resource = ComunicacaoResource::class;
    protected static ?string $title = 'Editar Comunicado';

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