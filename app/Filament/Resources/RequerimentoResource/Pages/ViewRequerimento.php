<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Gate;

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
           
                    Forms\Components\TextInput::make('id')
                        ->label('ID')
                        ->disabled(),
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
    public function mount($record): void
{
    parent::mount($record);

    Gate::authorize('view', $this->record);
}
}