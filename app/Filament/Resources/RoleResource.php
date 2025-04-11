<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationGroup = 'Segurança';
    protected static ?string $navigationIcon = 'heroicon-s-identification';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Perfis';
    protected static ?string $slug = 'perfis';
    protected static ?string $pluralModelLabel = 'Perfis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')  
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('permissions')
                    ->label('Permissões')
                    ->multiple()
                    ->preload()
                    ->relationship('permissions', 'name')
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('permissions.name')
                    ->label('Permissões')
                    ->badge()
                    ->searchable()
                    ->separator(', ')
                    ->color('success')
                    ->limitList(10), // Limita a exibição inicial
                Tables\Columns\TextColumn::make('created_at')
                ->label('Criado em:')
                    ->dateTime($format = 'd/m/Y H:i:s')
                    ->sortable(),
                    //->toggleable(isToggledHiddenByDefault: true),
               
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}