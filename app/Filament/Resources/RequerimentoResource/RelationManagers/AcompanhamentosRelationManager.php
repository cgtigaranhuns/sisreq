<?php

namespace App\Filament\Resources\RequerimentoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcompanhamentosRelationManager extends RelationManager
{
    protected static string $relationship = 'Acompanhamentos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
              /*  Forms\Components\TextInput::make('Acompanhamentos')
                    ->required()
                    ->maxLength(255),*/
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Acompanhamentos')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#'),
                 Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable(),
                Tables\Columns\IconColumn::make('finalizador')
                    ->label('Finalizado?')
                    ->aligncenter()
                    ->boolean(),
                    Tables\Columns\TextColumn::make('requerimento.status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'em_analise' => 'Em Análise',
                        'finalizado' => 'Finalizado',
                        default => $state,})
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'danger',
                        'em_analise' => 'warning',
                        'finalizado' => 'success',
                    })
                    ->searchable(),
                    Tables\Columns\TextColumn::make('anexos_count')
                    ->label('Anexos')
                    ->aligncenter()
                    ->counts('anexos'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data de Acomp.')
                    ->dateTime(format: 'd/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
               // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('anexos')
                ->label('Ver Anexos')
                ->icon('heroicon-o-paper-clip')
                ->color('gray')
                ->modalHeading('Anexos do Acompanhamento')
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->modalContent(function ($record) {
                    return view('anexosAcomp-table', [
                        'anexos' => $record->anexos->map(function ($anexo) {
                            return [
                                'nome_original' => $anexo->nome_original,
                                'caminho' => $anexo->caminho,
                                'mime_type' => $anexo->mime_type,
                                'url' => asset('storage/' . $anexo->caminho)
                            ];
                        })->toArray()
                    ]);
                })
                ->modalWidth('7xl'),
               /* Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),*/
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}