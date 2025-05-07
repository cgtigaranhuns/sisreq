<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Gate;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Editar Usuário';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        Gate::authorize('update', $this->record);
    }
}