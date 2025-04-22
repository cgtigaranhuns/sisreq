<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequerimentoResource\Pages;
use App\Filament\Resources\RequerimentoResource\RelationManagers;
use App\Models\Requerimento;
use App\Models\Discente;
use App\Models\Tipo_requerimento;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequerimentoResource extends Resource
{
    protected static ?string $model = Requerimento::class;

    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-s-document-arrow-down';
    protected static ?string $navigationLabel = 'Requerimentos';
    protected static ?string $slug = 'requerimentos';
    protected static ?string $pluralModelLabel = 'Requerimentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id') // Campo oculto para o user_id
                    ->default(auth()->id()) // Preenche automaticamente com o ID do usuário logado
                    ->required(),
                Forms\Components\Select::make('discente_id')
                    ->relationship('discente', 'nome')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('tipo_requerimento_id')
                    ->relationship('tipo_requerimento', 'descricao')
                    ->required()
                    ->searchable()
                    ->preload(),
                Textarea::make('anexo')
                    ->label('Anexo(s) - Documentos exigidos' )
                    ->rows(7)
                    //->required()
                    ->maxLength(255),
               /* Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('pendente'),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
              /*  Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),*/
                Tables\Columns\TextColumn::make('discente.nome')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('discente.matricula')
                    ->label('Matricula')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_requerimento.descricao')
                    ->numeric()
                    ->sortable(),
                /*Tables\Columns\TextColumn::make('observacoes')
                    ->searchable(),*/
                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pendente' => 'gray',
                    'em_analise' => 'warning',
                    'finalizado' => 'success',
                })
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListRequerimentos::route('/'),
            'create' => Pages\CreateRequerimento::route('/create'),
            'view' => Pages\ViewRequerimento::route('/{record}'),
            'edit' => Pages\EditRequerimento::route('/{record}/edit'),
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