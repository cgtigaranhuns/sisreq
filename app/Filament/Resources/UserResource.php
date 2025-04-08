<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Segurança';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $slug = 'usuarios';
    protected static ?string $pluralModelLabel = 'Usuários';

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
                    ->required()
                    ->maxLength(255),
              //  Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->label(label: 'Senha')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Forms\Components\Toggle::make('status')
                    ->required()
                    ->default(true),
                Forms\Components\Select::make('roles')
                    ->label('Perfil')
                  //  ->multiple()
                    ->preload()
                    ->relationship('roles', 'name', fn(builder $query) => auth()->user()->hasRole('Admin')? null :
                    $query->where('name', '!=', 'Admin')),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function (Builder $query) {
            $user = auth()->user();
            // Se o usuário for do perfil "usuário", filtra os registros pelo user_id
            if ($user->hasRole(['Admin','TI'])) {
                $query;
            }else {
                $query->where('id', $user->id)->where('status', 1);
            }
        })
        ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('matricula')
                ->searchable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
               
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                /*Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),*/
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                    Tables\Columns\TextColumn::make('roles.name')
                ->label('Perfil')
                ->searchable(),
               /* Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),*/
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}