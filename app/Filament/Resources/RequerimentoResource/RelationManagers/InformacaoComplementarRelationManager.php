<?php

namespace App\Filament\Resources\RequerimentoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InformacaoComplementarRelationManager extends RelationManager
{
    protected static string $relationship = 'informacaoComplementar';

    protected static ?string $title = 'Informações Complementares';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('descricao')
                    ->label('Descrição')
                    ->rows(7)
                    ->columnSpanFull(),
                // Adicione outros campos da tabela infor_complements aqui
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->label('')
                    ->limit(1000)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                      /*  if (strlen($state) <= $column->getLimit()) {
                            return null;
                        }*/
                        return $state;
                    }),
                // Adicione outras colunas da tabela infor_complements aqui
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                 Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}