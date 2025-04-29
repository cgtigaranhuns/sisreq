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

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informações do Requerimento')
                ->schema([
                   /* Forms\Components\Select::make('requerimento_id')
                        ->relationship('requerimento', 'id')
                        ->disabled()
                        ->getOptionLabelFromRecordUsing(function ($record, Forms\Set $set) {
                           // $set('discente', $record->discente->nome);
                          //  $set('tipo_requerimento', $record->tipo_requerimento->descricao);
                          //  $set('observacoes', $record->id);
                            return "{$record->id} - {$record->discente->nome} - {$record->tipo_requerimento->descricao}";
                        })
                        ,
                    Forms\Components\TextInput::make('requerimento_id')
                        ->label('Requerimento')
                        ->disabled()
                        ->dehydrated()
                        ->formatStateUsing(function ($state, $record) {
                            if ($record && $record->requerimento) {
                                return "{$record->requerimento->id} - {$record->requerimento->discente->nome} - {$record->requerimento->tipo_requerimento->descricao}";
                            }
                            return 'Nenhum requerimento associado';
                        }),*/
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