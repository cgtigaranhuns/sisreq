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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;

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
            ->striped()
            ->groups([
                Group::make('tipo_requerimento.descricao')
                ->label('Tipo de Requerimento')
                ->collapsible()
                ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('tipo_requerimento_id', $direction)),
            ]);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->label('Data da Solicit.')
                ->numeric()
                ->dateTime('d/m/Y') 
                ->alignCenter()
                ->searchable(query: function (Builder $query, string $search) {
                    // Tenta converter data no formato brasileiro para o formato do banco
                    $search = str_replace('/', '-', $search);
                    $timestamp = strtotime($search);
                    
                    if ($timestamp !== false) {
                        $mysqlDate = date('Y-m-d', $timestamp);
                        $query->whereDate('created_at', $mysqlDate)
                            ->orWhere('created_at', 'LIKE', "%{$mysqlDate}%");
                    } else {
                        // Fallback: busca simples
                        $query->where('created_at', 'LIKE', "%{$search}%");
                    }
                })
                ->sortable(),
            Tables\Columns\TextColumn::make('discente.nome')
                ->limit(35)
                ->sortable()
                ->searchable()
                ->size(TextColumn\TextColumnSize::ExtraSmall),
            Tables\Columns\TextColumn::make('discente.matricula')
                ->label('Matrícula')
                ->numeric()
                ->sortable()
                ->searchable()
                ->size(TextColumn\TextColumnSize::ExtraSmall),
            Tables\Columns\TextColumn::make('tipo_requerimento.descricao')
                ->label('Tipo do Requerimento')
                ->limit(30)
                ->sortable()
                ->searchable()
                ->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\TextColumn::make('anexos_count')
                    ->label('Anexos')
                    ->aligncenter()
                    ->counts('anexos')
                    ->size(TextColumn\TextColumnSize::ExtraSmall),
                Tables\Columns\IconColumn::make('comunicacoes')
                    ->label('Comunicações')
                    ->alignCenter()
                    ->getStateUsing(function (Requerimento $record): int {
                        return $record->comunicacoes()->count();
                    })
                   /*->icon(fn ($state): string => $state > 0 ? 'heroicon-s-chat-bubble-oval-left-ellipsis' : 'heroicon-s-chat-bubble-oval-left-ellipsis')
                    ->color(fn ($state): string => $state > 0 ? 'success' : 'gray')
                    ->tooltip(fn ($state): string => $state > 0 ? ($state > 1 ? "{$state} comunicações" : "{$state} comunicação"): 'Sem comunicações'),*/
                    ->icon(fn ($state): string => $state > 0 ? 'heroicon-s-check' : '')
                    ->color(fn ($state): string => $state > 0 ? 'success' : '')
                    ->tooltip(fn ($state): string => $state > 0 ? ($state > 1 ? "{$state} comunicações" : "{$state} comunicação"): ''),          
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