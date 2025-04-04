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

class AcompanhamentoResource extends Resource
{
    protected static ?string $model = Acompanhamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Acompanhamento';

    protected static ?string $pluralModelLabel = 'Acompanhamentos';

    protected static ?string $navigationGroup = 'Administrativo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->default(auth()->id()),
                Forms\Components\Select::make('requerimento_id')
                    ->relationship('requerimento', 'descricao')
                    ->required(),
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
// Adicione este método para definir o user_id automaticamente
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->where('user_id', auth()->id());
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
            'edit' => Pages\EditAcompanhamento::route('/{record}/edit'),
        ];
    }
}