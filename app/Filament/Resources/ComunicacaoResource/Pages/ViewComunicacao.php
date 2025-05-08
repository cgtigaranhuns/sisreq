<?php

namespace App\Filament\Resources\ComunicacaoResource\Pages;

use App\Filament\Resources\ComunicacaoResource;
use App\Models\Requerimento;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Gate;

class ViewComunicacao extends ViewRecord
{
    protected static string $resource = ComunicacaoResource::class;
    protected static bool $shouldRegisterNavigation = false;

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
                Forms\Components\Section::make('Comunicado')
                ->schema([
                    Forms\Components\Textarea::make('mensagem')
                        ->label('Mensagem')
                        ->disabled()
                        ->columnSpanFull()
                        ->rows(7),

                ]),
            ]);
        }

        public function mount($record): void
{
    parent::mount($record);

    Gate::authorize('view', $this->record);
}
}