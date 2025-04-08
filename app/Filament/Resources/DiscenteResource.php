<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscenteResource\Pages;
use App\Filament\Resources\DiscenteResource\RelationManagers;
use App\Models\Discente;
use App\Models\Cursos;
use App\Models\Campus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscenteResource extends Resource
{
    protected static ?string $model = Discente::class;

    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
   // protected static ?string $navigationLabel = 'Proventos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('matricula')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('data_nascimento'),
                Forms\Components\TextInput::make('cpf')
                    ->mask('999.999.999-99')
                    ->label('CPF')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rg')
                    ->label('RG')
                    ->maxLength(255),
                    Forms\Components\Select::make('campus_id')
                    ->label('Campus')
                    ->relationship('campus', 'nome'),
                    //->disabled()
                    //->default(1),
                   // ->maxLength(255),
                Forms\Components\Select::make('curso_id')
                    ->label('Curso')
                    ->relationship('curso', 'nome'),
                    //->maxLength(255),
                    
                Forms\Components\TextInput::make('situacao')
                    ->label('Situação')
                    ->maxLength(255),
                Forms\Components\TextInput::make('periodo')
                    ->label('Período')
                    ->numeric(),
                Forms\Components\Select::make('turno')
                   // ->maxLength(255)
                    ->options(
                        [
                            'N' => 'Noturno',
                            'V' => 'Vespertino',
                            'M' => 'Matutino',
                    ]
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('matricula')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_nascimento')
                    ->date($format = 'd/m/y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rg')
                    ->label('RG')
                    ->searchable(),
                Tables\Columns\TextColumn::make('campus.nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('curso.nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('situacao')
                    ->label ('Situação')
                    ->color(function ($record) {
                        if ($record->situacao == 'Matriculado') {
                            return 'success';
                        } else {
                            return 'secondary';
                        }
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('periodo')
                    ->label('Período')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('turno')
                    ->searchable(),
              /*  Tables\Columns\TextColumn::make('deleted_at')
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
                    ->toggleable(isToggledHiddenByDefault: true),*/
            ])
            ->filters([
               // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->modalHeading('Tem certeza?')
                ->modalDescription('Essa ação não pode ser desfeita.')
                ->modalButton('Excluir')
                ->modalWidth('md') // ✅ Correção: Usando o enum corretamente
                //->label('')
                ->tooltip('Excluir'),
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
            'index' => Pages\ListDiscentes::route('/'),
            'create' => Pages\CreateDiscente::route('/create'),
            'view' => Pages\ViewDiscente::route('/{record}'),
            'edit' => Pages\EditDiscente::route('/{record}/edit'),
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