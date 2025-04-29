<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoRequerimentoResource\Pages;
use App\Filament\Resources\TipoRequerimentoResource\RelationManagers;
use App\Models\TipoRequerimento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoRequerimentoResource extends Resource
{
    protected static ?string $model = TipoRequerimento::class;

    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-s-newspaper';
    protected static ?string $navigationLabel = 'Tipos de Requerimentos';
    //protected static ?string $slug = 'T_requerimentos';
    protected static ?string $pluralModelLabel = 'Tipos de Requerimentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                ->label('Descrição')
                    ->required()
                    ->maxLength(255),
                Textarea::make('anexo')
                    ->label('Anexo(s) - Documentos exigidos' )
                    ->rows(7)
                    //->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('infor_complementares')
                ->label('Adicionar informações complementares?')
                ->live()
                //->visible(false)
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    if (!$state) {
                        $set('template', null);
                       // $set('status_complementar', null);
                    }
                }),
            
                // Campos condicionais para informações complementares
                Forms\Components\Fieldset::make('Modelo de Informações Complementares')
                    ->schema([
                        Forms\Components\Textarea::make('template')
                            ->label('Descrição')
                            ->rows(7)
                            ->hidden(fn (Forms\Get $get): bool => !$get('infor_complementares')),
                    
                    ])
                    ->hidden(fn (Forms\Get $get): bool => !$get('infor_complementares')),
                Forms\Components\Toggle::make('status')
                    ->default('true') 	
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\IconColumn::make('infor_complementares')
                ->label('Informações complementares')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label('')
                ->tooltip('Visualizar'),
                Tables\Actions\EditAction::make()
                ->label('')
                ->tooltip('Editar'),
                // Ação de exclusão
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Tem certeza?')
                    ->modalDescription('Essa ação não pode ser desfeita.')
                    ->modalButton('Excluir')
                    ->modalWidth('md') // ✅ Correção: Usando o enum corretamente
                    ->label('')
                    ->tooltip('Excluir')
                    ->requiresConfirmation(), // Se deseja confirmação antes de excluir*/
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
            'index' => Pages\ListTipoRequerimentos::route('/'),
            'create' => Pages\CreateTipoRequerimento::route('/create'),
            'view' => Pages\ViewTipoRequerimento::route('/{record}'),
            'edit' => Pages\EditTipoRequerimento::route('/{record}/edit'),
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