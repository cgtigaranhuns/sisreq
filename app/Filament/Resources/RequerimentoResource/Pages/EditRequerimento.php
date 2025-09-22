<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use App\Models\Anexo;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class EditRequerimento extends EditRecord
{
    protected static string $resource = RequerimentoResource::class;
    protected static ?string $title = 'Editar Requerimento';

    protected function afterSave(): void
    {
        // Salvar os novos anexos após editar o requerimento
        $anexos = $this->data['anexos'] ?? [];

        foreach ($anexos as $anexoPath) {
            $fullPath = Storage::disk('public')->path($anexoPath);

            Anexo::create([
                'requerimento_id' => $this->record->id,
                'caminho' => $anexoPath,
                'nome_original' => basename($anexoPath),
                'mime_type' => mime_content_type($fullPath),
                'tamanho' => filesize($fullPath),
            ]);
        }
    }

      // Sobrescreva este método para modificar o formulário apenas na visualização
    public function form(Form $form): Form
    {
        return $form->schema([
           
                    Forms\Components\Select::make('discente_id')
                    ->label('Discente')
                        //->relationship('discente', 'nome')
                        ->options(function () {
                        $query = \App\Models\Discente::query()->orderBy('nome');
                        
                        if (auth()->user()->hasRole('Discente')) {
                            $query->where('matricula', auth()->user()->matricula);
                        }

                        return $query->get()->mapWithKeys(function ($discente) {
                            return [
                                $discente->id => "{$discente->nome} - {$discente->matricula}"
                            ];
                        });
                    })
                    ->required()
                    ->disabled(),
                    Forms\Components\Select::make('tipo_requerimento_id')
                        ->relationship('tipo_requerimento', 'descricao')
                        ,
                    Forms\Components\Textarea::make('anexo')
                        ->label('Documentos Exigidos')
                        ->disabled()
                        ->hidden(),
                    Forms\Components\Textarea::make('observacoes')
                        ->label('Observações')
                        ->rows(7)
                        ,
                ]);
    }
    protected function getHeaderActions(): array
    {
        return [
          //  Actions\DeleteAction::make(),
        ];
    }
    public function mount($record): void
{
    parent::mount($record);

    Gate::authorize('view', $this->record);
}
protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}