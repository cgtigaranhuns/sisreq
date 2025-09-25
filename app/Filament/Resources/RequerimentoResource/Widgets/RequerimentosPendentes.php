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
use App\Filament\Resources\ComunicacaoResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoRequerimento;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Grouping\Group;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

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
            ->orderBy('id', 'asc');

        if (auth()->user()->hasRole('Discente')) {
            $query->where('user_id', auth()->id());
        }

        return $query;
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
                ->alignCenter()
                ->counts('anexos')
                ->size(TextColumn\TextColumnSize::ExtraSmall),
                // Nova coluna para comunicações
            // Coluna corrigida para comunicações
            Tables\Columns\IconColumn::make('comunicacoes')
                ->label('Comunicações')
                ->alignCenter()
               // ->size(IconColumn\IconColumnSize::Small)
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
            Action::make('pdf')
            ->label('')
            ->hidden(auth()->user()->hasRole('Discente') ?? false)
            ->tooltip('Gerar PDF')
            ->icon('heroicon-s-printer')
            ->color('success')
            ->action(function (Requerimento $record) {
                // Carrega os relacionamentos necessários
                $record->load([
                    'discente.campus',
                    'discente.curso',
                    'tipo_requerimento',
                    'informacaoComplementar',
                    'anexos'
                ]);
        
                // Busca todos os tipos de requerimento
                $tipos = TipoRequerimento::where('status', 1)->where('deleted_at','=', null)->orderBy('descricao')->get()->keyBy('id');
                // Obtém os IDs dos tipos selecionados
                //$tiposSelecionados = $record->tipo_requerimento->pluck('id')->toArray();
        
                // Gera o PDF com os dados
                $pdf = Pdf::loadView('requerimentos.show', [
                    'requerimento' => $record,
                    'tipos' => $tipos,
                   // 'tiposSelecionados' => $record->tipo_requerimento->pluck('id')->toArray()
                ]);
               // dd($record->tipo_requerimento->pluck('id')->toArray());
                // Define o nome do arquivo
                $filename = "requerimento-{$record->id}.pdf";
        
                // Retorna a resposta de download
                return Response::streamDownload(
                    fn () => print($pdf->output()),
                    $filename,
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                    ]
                );
            }),
            Action::make('comunicacao')
            ->label('')
            ->hidden(auth()->user()->hasRole('Discente') ?? false)
            ->tooltip('Enviar Comunicação')
            ->icon('heroicon-s-chat-bubble-oval-left-ellipsis')
            ->color('info')
            ->requiresConfirmation() 
            ->modalHeading('Confirmar Comunicação')
            ->modalDescription('Deseja enviar um comunicado para este Requerimento?')
            ->modalSubmitActionLabel('Confirmar')
            ->modalCancelActionLabel('Cancelar')
            ->action(function (Requerimento $record) {
                return redirect()->to(
                    ComunicacaoResource::getUrl('create', [
                        'requerimento_id' => $record->id
                    ])
                );
            }),
            Action::make('acompanhamento')
            ->label('')
            ->hidden(auth()->user()->hasRole('Discente') ?? false)
            ->tooltip('Registrar Acompanhamento')
            ->icon('heroicon-s-ticket')
            ->color('warning')
            ->requiresConfirmation() 
            ->modalHeading('Confirmar Acompanhamento')
            ->modalDescription('Deseja iniciar o Acompanhamento deste Requerimento?')
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
     protected function getHeading(): string
    {
        return 'Pendentes';
    }

   /* protected function getTableRecordUrlUsing(): ?\Closure
    {
        return fn (Requerimento $record): string => RequerimentoResource::getUrl('view', ['record' => $record]);
    }
    /*
    public static function canView(Model $record): bool
    {
        return Gate::allows('view', $record);
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('update', $record);
    }*/
   
}