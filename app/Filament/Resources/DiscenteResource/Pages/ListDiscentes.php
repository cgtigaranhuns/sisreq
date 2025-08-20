<?php

namespace App\Filament\Resources\DiscenteResource\Pages;

use App\Filament\Resources\DiscenteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDiscentes extends ListRecords
{
    protected static string $resource = DiscenteResource::class;
   

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Novo Discente'),
        ];
    }

    protected function getTableQuery(): ?Builder
    {
        $query = parent::getTableQuery();

        $user = auth()->user();

        if ($user->hasRole('Discente') && !$user->hasPermissionTo('Ver Discente')) {
            $query->where('matricula', $user->matricula);
        }

        return $query;
    }
}