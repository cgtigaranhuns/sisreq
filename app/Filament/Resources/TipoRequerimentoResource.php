<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoRequerimentoResource\Pages;
use App\Filament\Resources\TipoRequerimentoResource\RelationManagers;
use App\Models\Tipo_requerimento;
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
    protected static ?string $model = Tipo_requerimento::class;

    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-s-newspaper';
    protected static ?string $navigationLabel = 'Tipos de Requerimentos';
    protected static ?string $slug = 'T_requeirimentos';
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
                ->label('Informações complementares')
                    ->required(),
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