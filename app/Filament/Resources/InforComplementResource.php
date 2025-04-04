<?php
// app/Filament/Resources/InforComplementResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\InforComplementResource\Pages;
use App\Filament\Resources\InforComplementResource\RelationManagers;
use App\Models\infor_complement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InforComplementResource extends Resource
{
    protected static ?string $model = infor_complement::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    protected static ?string $modelLabel = 'Informação Complementar';

    protected static ?string $pluralModelLabel = 'Informações Complementares';

    protected static ?string $navigationGroup = 'Administrativo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_requerimento')
                    ->relationship('requerimento', 'descricao')
                    ->required(),
                Forms\Components\Textarea::make('descricao')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pendente' => 'Pendente',
                        'em_andamento' => 'Em Andamento',
                        'concluido' => 'Concluído',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('requerimento.descricao')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'gray',
                        'em_andamento' => 'warning',
                        'concluido' => 'success',
                    }),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInforComplements::route('/'),
            'create' => Pages\CreateInforComplement::route('/create'),
            'edit' => Pages\EditInforComplement::route('/{record}/edit'),
        ];
    }
}