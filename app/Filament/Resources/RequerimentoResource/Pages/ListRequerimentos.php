<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use App\Models\requerimentos;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Components\Tab;
use Illuminate\Contracts\View\View;

class ListRequerimentos extends ListRecords
{
    protected static string $resource = RequerimentoResource::class;
    public function getTabs(): array
    {
        return [
            null => Tab::make('Todos'),
            'pendente' => Tab::make('Pendentes')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pendente'))
                ->badge(requerimentos::query()->where('status', 'pendente')->count()),
            'em_analise' => Tab::make('Em Análise')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'em_analise'))
                ->badge(requerimentos::query()->where('status', 'em_analise')->count()),
            'finalizado' => Tab::make('Finalizados')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'finalizado'))
                ->badge(requerimentos::query()->where('status', 'finalizado')->count()),
        ];
    }
}