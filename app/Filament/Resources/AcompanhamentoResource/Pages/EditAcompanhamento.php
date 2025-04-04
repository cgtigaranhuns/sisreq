<?php

namespace App\Filament\Resources\AcompanhamentoResource\Pages;

use App\Filament\Resources\AcompanhamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcompanhamento extends EditRecord
{
    protected static string $resource = AcompanhamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
