<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcompanhamentoResource\Pages;
use App\Filament\Resources\AcompanhamentoResource\RelationManagers;
use App\Models\Acompanhamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Forms\Components\Select;
use Forms\Components\TextInput;

class AcompanhamentoResource extends Resource
{
    protected static ?string $model = Acompanhamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->default(auth()->id()),
                Forms\Components\Select::make('requerimento_id')
                ->relationship('requerimento', 'id')
                ->required()
                ->live() // Isso faz o campo "ouvir" mudanças
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    // Carrega os dados do requerimento quando um ID é selecionado
                    $requerimento = \App\Models\Requerimento::find($state);
                    
                    if ($requerimento) {
                        $set('discente', $requerimento->discente->nome);
                        $set('tipo_requerimento', $requerimento->tipo_requerimento_id); // Ajuste conforme seu campo real
                    }
                }),
                Forms\Components\Select::make('discente')
                ->label('Discente')
                ->options(function (Forms\Get $get) {
                    $requerimentoId = $get('requerimento_id');
                    if (!$requerimentoId) {
                        return [];
                    }
                    
                    $requerimento = \App\Models\Requerimento::find($requerimentoId);
                    return [$requerimento->discente_id => $requerimento->discente->nome]; // Ajuste conforme sua relação
                })
                ->required()
                ->disabled(),
                
                Forms\Components\Select::make('tipo_requerimento')
                ->label('Tipo')
                ->options(function (Forms\Get $get) {
                    $requerimentoId = $get('requerimento_id');
                    if (!$requerimentoId) {
                        return [];
                    }
                    
                    $requerimento = \App\Models\Requerimento::find($requerimentoId);
                    return [$requerimento->tipo_requerimento_id => $requerimento->tipo_requerimento->descricao]; // Ajuste conforme sua relação
                })
                ->required()
                ->disabled(),
                Forms\Components\Textarea::make('descricao')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('finalizador')
                    ->label('Finalizar Requerimento?')
                    ->onColor('success')
                    ->offColor('gray'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    Tables\Columns\TextColumn::make('requerimento.descricao')
                        ->limit(30)
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('descricao')
                        ->limit(30)
                        ->searchable(),
                    Tables\Columns\TextColumn::make('user.name')
                        ->label('Usuário')
                        ->searchable(),
                    Tables\Columns\IconColumn::make('finalizador')
                        ->label('Finalizado?')
                        ->boolean(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable(),
            ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcompanhamentos::route('/'),
            'create' => Pages\CreateAcompanhamento::route('/create'),
            'view' => Pages\ViewAcompanhamento::route('/{record}'),
            'edit' => Pages\EditAcompanhamento::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}