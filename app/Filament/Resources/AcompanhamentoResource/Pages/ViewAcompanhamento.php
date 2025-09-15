<?php

namespace App\Filament\Resources\AcompanhamentoResource\Pages;

use App\Filament\Resources\AcompanhamentoResource;
use App\Models\Requerimento;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Forms\Form;

class ViewAcompanhamento extends ViewRecord
{
    protected static string $resource = AcompanhamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informações do Requerimento')
                ->schema([
                   
                        Forms\Components\TextInput::make('tipo_requerimento')
                        ->label('# - Tipo do Requerimento')
                        ->disabled()
                        ->dehydrated()
                        ->formatStateUsing(function ($state, $record) {
                            if ($record && $record->requerimento) {
                                return "{$record->requerimento->id} - {$record->requerimento->tipo_requerimento->descricao}";
                            }
                            return 'Nenhum requerimento associado';
                        }),
                        Forms\Components\TextInput::make('discente')
                        ->label('Discente')
                        ->disabled()
                        ->dehydrated()
                        ->formatStateUsing(function ($state, $record) {
                            if ($record && $record->requerimento) {
                                return $record->requerimento->discente->nome;
                            }
                            return 'Nenhum requerimento associado';
                        }),
                        Forms\Components\Textarea::make('infor_complementares')
                        ->label('Informações Complementares')
                        ->disabled()
                        ->rows(7)
                        ->dehydrated()
                        ->formatStateUsing(function ($state, $record) {
                            if ($record && $record->requerimento) {
                                return $record->requerimento->informacaoComplementar->descricao ?? '';
                            }
                            return 'Nenhum requerimento associado';
                        }),
                        Forms\Components\Textarea::make('observacoes')
                        ->label('Observações')
                        ->disabled()
                        ->rows(7)
                        ->dehydrated()
                        ->formatStateUsing(function ($state, $record) {
                            if ($record && $record->requerimento) {
                                return $record->requerimento->observacoes ?? '';
                            }
                            return 'Nenhum requerimento associado';
                        }),
                        Forms\Components\View::make('anexos-table')
                        ->viewData([
                            'anexos' => $this->getRecord()->requerimento->anexos->map(function ($anexo) {
                                $fullPath = storage_path('app/public/' . $anexo->caminho);
                                return [
                                    'nome_original' => $anexo->nome_original,
                                    'caminho' => $anexo->caminho,
                                    'tamanho' => file_exists($fullPath) ? filesize($fullPath) : 0,
                                    'url' => asset('storage/' . $anexo->caminho)
                                ];
                            })->toArray()
                        ])
                        ->columnSpanFull(),
                   
                ])
                ->columns(2),
                Forms\Components\Section::make('Acompanhamento')
                ->schema([
                    Forms\Components\Textarea::make('descricao')
                        ->label('Descrição')
                        ->disabled()
                        ->columnSpanFull()
                        ->rows(5),
                        
                    Forms\Components\Toggle::make('finalizador')
                        ->label('Finalizar Requerimento?')
                        ->disabled()
                        ->onColor('success')
                        ->offColor('gray'),
                ]),
                
            // Seção para anexos (se necessário)
         /*   Forms\Components\Section::make('Anexos')
                ->schema([
                    // Adicione aqui os campos de anexos se necessário
                ])
                ->hidden(fn ($record) => $record->anexos->isEmpty()),*/
        ]);
   }
}