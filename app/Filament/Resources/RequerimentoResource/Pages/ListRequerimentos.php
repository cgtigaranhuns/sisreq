<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Models\Requerimento;
use App\Filament\Resources\RequerimentoResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
/*use Filament\Resources\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;*/

class ListRequerimentos extends ListRecords
{
    protected static string $resource = RequerimentoResource::class;

    
    public function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo Requerimento'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [

            \App\Filament\Resources\RequerimentoResource\Widgets\RequerimentosPendentes::class,
            \App\Filament\Resources\RequerimentoResource\Widgets\RequerimentosEmAnalise::class,
            \App\Filament\Resources\RequerimentoResource\Widgets\RequerimentosFinalizados::class,
        ];

    }



}