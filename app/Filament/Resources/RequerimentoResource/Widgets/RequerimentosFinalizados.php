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

class RequerimentosFinalizados extends BaseWidget
{

    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Finalizados';
    protected function getTableQuery(): Builder
    {

        $user = auth()->user();
       
        if ($user->hasRole('Discente')) {
        return Requerimento::query()
            ->where('status', 'finalizado')->where('user_id', $user->id)->orderBY('id', 'desc');
        }else {
            return Requerimento::query()
            ->where('status', 'finalizado')->orderBY('id', 'desc');
        }
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
                    ->sortable(),
                    Tables\Columns\TextColumn::make('discente.matricula')
                    ->label('Matricula')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipo_requerimento.descricao')
                    ->Label('Tipo do Requerimento')
                    ->limit(35)
                    ->sortable(),
                Tables\Columns\TextColumn::make('anexos_count')
                    ->label('Anexos')
                    ->aligncenter()
                    ->counts('anexos'),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
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
        return 'Pendentes';
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
    }
}