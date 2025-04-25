<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Forms\Form;

class ViewRequerimento extends ViewRecord
{
    protected static string $resource = RequerimentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\EditAction::make(),
        ];
    }

    // Sobrescreva este método para modificar o formulário apenas na visualização
    public function form(Form $form): Form
    {
        return $form->schema([
           
                    Forms\Components\Select::make('discente_id')
                    ->relationship('discente', 'nome')
                        ->disabled(),
                    
                    Forms\Components\Select::make('tipo_requerimento_id')
                        ->relationship('tipo_requerimento', 'descricao')
                        ->disabled(),
                    Forms\Components\Textarea::make('anexo')
                        ->label('Documentos Exigidos')
                        ->disabled()
                        ->hidden(),
                    Forms\Components\Textarea::make('observacoes')
                        ->label('Observações')
                        ->rows(7)
                        ->disabled(),
                ]);
    }
}