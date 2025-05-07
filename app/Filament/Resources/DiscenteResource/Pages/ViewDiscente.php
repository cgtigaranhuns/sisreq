<?php

namespace App\Filament\Resources\DiscenteResource\Pages;

use App\Filament\Resources\DiscenteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Gate;

class ViewDiscente extends ViewRecord
{
    protected static string $resource = DiscenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        Gate::authorize('update', $this->record);
    }
}