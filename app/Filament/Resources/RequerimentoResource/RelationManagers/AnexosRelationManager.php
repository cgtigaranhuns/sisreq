<?php

namespace App\Filament\Resources\RequerimentoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AnexosRelationManager extends RelationManager
{
    protected static string $relationship = 'anexos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('caminho')
                    ->label('Arquivo')
                    ->directory('requerimentos/anexos')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nome_original')
            ->columns([
                Tables\Columns\TextColumn::make('nome_original')
                    ->label('Arquivo'),
                Tables\Columns\TextColumn::make('tamanho')
                    ->label('Tamanho')
                    ->formatStateUsing(fn ($state) => round($state / 1024, 2) . ' KB'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Upload')
                    ->dateTime(format: 'd/m/Y H:i:s'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}