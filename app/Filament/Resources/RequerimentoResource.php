<?php

// app/Filament/Resources/RequerimentoResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\RequerimentoResource\Pages;
//use App\Filament\Resources\RequerimentoResource\RelationManagers;
use App\Models\requerimentos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Tabs;

class RequerimentoResource extends Resource
{
    protected static ?string $model = requerimentos::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Administrativo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('discente')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('curso')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'em_analise' => 'Em Andamento',
                        'concluido' => 'Concluído',
                    ])
                    ->required(),
                
                // Botão para ativar informações complementares
                Forms\Components\Toggle::make('tem_informacoes_complementares')
                    ->label('Adicionar informações complementares?')
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if (!$state) {
                            $set('descricao_complementar', null);
                            $set('status_complementar', null);
                        }
                    }),
                
                // Campos condicionais para informações complementares
                Forms\Components\Fieldset::make('Informações Complementares')
                    ->schema([
                        Forms\Components\Textarea::make('descricao_complementar')
                            ->label('Descrição')
                            ->hidden(fn (Forms\Get $get): bool => !$get('tem_informacoes_complementares')),
                        Forms\Components\Select::make('status_complementar')
                            ->label('Status')
                            ->options([
                                'pendente' => 'Pendente',
                                'em_analise' => 'Em Andamento',
                                'concluido' => 'Concluído',
                            ])
                            ->hidden(fn (Forms\Get $get): bool => !$get('tem_informacoes_complementares')),
                    ])
                    ->hidden(fn (Forms\Get $get): bool => !$get('tem_informacoes_complementares')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pendente'))
        //->badge(Requerimento::query()->where('status', 'pendente')->count())
      
            ->columns([
                Tables\Columns\TextColumn::make('descricao'),
                    //->searchable(),
                Tables\Columns\TextColumn::make('discente'),
                   //->searchable(),
                Tables\Columns\TextColumn::make('curso'),
                   // ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'gray',
                        'em_analise' => 'warning',
                        'finalizado' => 'success',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
          //  RelationManagers\InforComplementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequerimentos::route('/'),
            'create' => Pages\CreateRequerimento::route('/create'),
            'edit' => Pages\EditRequerimento::route('/{record}/edit'),
        ];
    }
}