<?php

namespace App\Filament\Resources\RequerimentoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComunicacaoRelationManager extends RelationManager
{
    protected static string $relationship = 'comunicacoes';
    protected static ?string $title = 'Comunicações';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Comunicações')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Comunicações')
            ->columns([
                Tables\Columns\TextColumn::make('mensagem')
                    ->label('Mensagem')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enviado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Botão para visualizar a comunicação completa
                Tables\Actions\Action::make('visualizar')
                    ->label('')
                    ->tooltip('Visualizar Comunicação')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->modalHeading(fn ($record) => "Comunicação #{$record->id}")
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fechar')
                    ->modalWidth('4xl')
                    ->modalContent(function ($record) {
                        return view('comunicacao-view-modal', [
                            'comunicacao' => $record
                        ]);
                    }),
              //  Tables\Actions\EditAction::make(),
              //  Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
               // Tables\Actions\BulkActionGroup::make([
                 //   Tables\Actions\DeleteBulkAction::make(),
               // ]),//
            ]);
    }
}