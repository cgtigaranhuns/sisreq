<?php

namespace App\Filament\Resources\RequerimentoResource\Widgets;


use App\Models\Requerimento;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\RequerimentoResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;

class RequerimentosFinalizados extends BaseWidget
{

    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Finalizados';
    protected function getTableQuery(): Builder
    {

        $user = auth()->user();
       
        if ($user->hasRole('Discente')) {
        return Requerimento::query()
            ->where('status', 'finalizado')->where('user_id', $user->id)->orderBY('id', 'asc');
        }else {
            return Requerimento::query()
            ->where('status', 'finalizado')->orderBY('id', 'desc');
        }
    }
     // MÉTODO PUBLIC PARA RESOLVER O ERRO
    public function getTable(): \Filament\Tables\Table
    {
        return parent::getTable()
            ->striped();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discente.nome')
                    //->numeric()
                    ->limit(35)
                    ->sortable()
                    ->searchable(),
                    Tables\Columns\TextColumn::make('discente.matricula')
                    ->label('Matrícula')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo_requerimento.descricao')
                    ->Label('Tipo do Requerimento')
                    ->limit(35)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('anexos_count')
                    ->label('Anexos')
                    ->aligncenter()
                    ->counts('anexos'),
                Tables\Columns\IconColumn::make('comunicacoes')
                    ->label('Comunicações')
                    ->alignCenter()
                    ->getStateUsing(function (Requerimento $record): int {
                        return $record->comunicacoes()->count();
                    })
                    ->icon(fn ($state): string => $state > 0 ? 'heroicon-s-chat-bubble-oval-left-ellipsis' : 'heroicon-s-chat-bubble-oval-left-ellipsis')
                    ->color(fn ($state): string => $state > 0 ? 'success' : 'gray')
                    ->tooltip(fn ($state): string => $state > 0 ? "{$state} comunicação(ões)" : 'Sem comunicações'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->alignCenter()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'finalizado' => 'Finalizado',
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

    protected function getHeading(): string
    {
        return 'Finalizados';
    }
    
    protected function getTableActions(): array
    {
        return [
           
            // Ação de visualização
            ViewAction::make()
            ->label('')
            ->tooltip('Visualizar')
            ->url(fn (Requerimento $record): string => RequerimentoResource::getUrl('view', ['record' => $record])),
            
            // Ação de edição
          //  EditAction::make(),
            
            // Ação de exclusão
          /*  DeleteAction::make()
            ->modalHeading('Tem certeza?')
                ->modalDescription('Essa ação não pode ser desfeita.')
                ->modalButton('Excluir')
                ->modalWidth('md') // ✅ Correção: Usando o enum corretamente
                //->label('')
                ->tooltip('Excluir')
                ->requiresConfirmation(), // Se deseja confirmação antes de excluir*/
        ];
    }/*
    public static function canView(Model $record): bool
    {
        return Gate::allows('view', $record);
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('update', $record);
    }
   */
}