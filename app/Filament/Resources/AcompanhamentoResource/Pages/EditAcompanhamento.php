<?php

namespace App\Filament\Resources\AcompanhamentoResource\Pages;

use App\Filament\Resources\AcompanhamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcompanhamento extends EditRecord
{
    protected static string $resource = AcompanhamentoResource::class;
    protected static ?string $title = 'Editar Acompanhamento';

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