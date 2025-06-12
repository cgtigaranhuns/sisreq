<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Gate;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;
     protected static ?string $title = 'Visualizar Usuário';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function mount($record): void
{
    parent::mount($record);

    Gate::authorize('view', $this->record);
}
}