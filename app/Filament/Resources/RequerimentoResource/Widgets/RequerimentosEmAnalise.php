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
use App\Filament\Resources\AcompanhamentoResource;
use App\Filament\Resources\ComunicacaoResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;

use App\Models\TipoRequerimento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class RequerimentosEmAnalise extends BaseWidget
{
    
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Em Análise';
    protected function getTableQuery(): Builder
    {

        $user = auth()->user();
      
        if ($user->hasRole('Discente')) {
        return Requerimento::query()
            ->where('status', 'em_analise')->where('user_id', $user->id)->orderBY('id', 'desc');
        }else {
            return Requerimento::query()
            ->where('status', 'em_analise')->orderBY('id', 'desc');
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
                        'em_analise' => 'Em Análise',
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
            ->tooltip('Comunicação')
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
    }*/
   
}