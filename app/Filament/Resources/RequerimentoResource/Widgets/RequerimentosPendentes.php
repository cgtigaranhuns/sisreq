<?php

namespace App\Filament\Resources\RequerimentoResource\Widgets;

use App\Models\Requerimento;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\RequerimentoResource;
use App\Filament\Resources\AcompanhamentoResource;
use Filament\Tables\Actions\Action;

class RequerimentosPendentes extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Pendentes';
    /*protected static ?string $headingColor = 'primary'; 
    protected static ?string $headingAlignment = 'center'; // Centraliza o título */

    protected function getTableQuery(): Builder
    {
        $query = Requerimento::query()
            ->where('status', 'pendente')
            ->orderBy('id', 'desc');

        if (auth()->user()->hasRole('Discente')) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('#')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('discente.nome')
                ->limit(35)
                ->sortable(),
            Tables\Columns\TextColumn::make('discente.matricula')
                ->label('Matrícula')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('tipo_requerimento.descricao')
                ->label('Tipo do Requerimento')
                ->limit(35)
                ->sortable(),
            Tables\Columns\TextColumn::make('anexos_count')
                ->label('Anexos')
                ->alignCenter()
                ->counts('anexos'),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pendente' => 'Pendente',
                     default => $state,
                })
                ->color(fn (string $state): string => match ($state) {
                    'pendente' => 'danger',
                    'em_analise' => 'warning',
                    'finalizado' => 'success',
                })
                ->searchable(),
        ];
    }

   
    
    protected function getTableActions(): array
    {
        return [
            Action::make('acompanhamento')
            ->label('')
            ->hidden(auth()->user()->hasRole('Discente') ?? false)
            ->tooltip('Acompanhamento')
            ->icon('heroicon-s-ticket')
            ->color('warning')
            ->requiresConfirmation() 
            ->modalHeading('Confirmar Acompanhamento')
            ->modalDescription('Deseja realmente iniciar o Acompanhamento deste Requerimento?')
            ->modalSubmitActionLabel('Confirmar')
            ->modalCancelActionLabel('Cancelar')
            ->action(function (Requerimento $record) {
                return redirect()->to(
                    AcompanhamentoResource::getUrl('create', [
                        'requerimento_id' => $record->id
                    ])
                );
            }),
            ViewAction::make()
            ->label('')
            ->tooltip('Visualizar')
                ->url(fn (Requerimento $record): string => RequerimentoResource::getUrl('view', ['record' => $record])),
            
            EditAction::make()
            ->label('')
            ->tooltip('Editar')
                ->url(fn (Requerimento $record): string => RequerimentoResource::getUrl('edit', ['record' => $record])),
            
            DeleteAction::make()
                ->modalHeading('Tem certeza?')
                ->modalDescription('Essa ação não pode ser desfeita.')
                ->modalButton('Excluir')
                ->modalWidth('md')
                ->requiresConfirmation()
                ->label('')
                ->tooltip('Excluir')
                ->action(fn (Requerimento $record) => $record->delete()),
        ];
    }

    protected function getTableRecordUrlUsing(): ?\Closure
    {
        return fn (Requerimento $record): string => RequerimentoResource::getUrl('view', ['record' => $record]);
    }
}