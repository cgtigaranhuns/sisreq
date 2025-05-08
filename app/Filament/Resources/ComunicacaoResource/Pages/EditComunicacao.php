<?php

namespace App\Filament\Resources\ComunicacaoResource\Pages;

use App\Filament\Resources\ComunicacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Gate;

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

    public function mount($record): void
    {
        parent::mount($record);

        Gate::authorize('update', $this->record);
    }
}