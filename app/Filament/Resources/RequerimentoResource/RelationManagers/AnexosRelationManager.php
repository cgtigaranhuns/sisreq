<?php

namespace App\Filament\Resources\RequerimentoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use App\Models\Anexo;

class AnexosRelationManager extends RelationManager
{
    protected static string $relationship = 'anexos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('arquivo')
                    ->label('Arquivo')
                    ->directory('requerimentos/anexos/temp')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->required()
                    
                    ->storeFiles(false),
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
                Tables\Actions\CreateAction::make()
                    ->label('Adicionar Anexo')
                    ->icon('heroicon-o-plus')
                    ->using(function (array $data, string $model): mixed {
                        $requerimentoId = $this->getOwnerRecord()->id;
                        
                        if (isset($data['arquivo'])) {
                            try {
                                // Define o diretório específico para o requerimento
                                $diretorioRequerimento = 'anexos/requerimento/' . $requerimentoId;
                                
                                // Faz o upload do arquivo
                                $caminhoFinal = $data['arquivo']->storeAs(
                                    $diretorioRequerimento,
                                    uniqid() . '_' . $data['arquivo']->getClientOriginalName(),
                                    'public'
                                );
            
                            // Cria o anexo manualmente
                            return $model::create([
                                'requerimento_id' => $requerimentoId,
                                'caminho' => $caminhoFinal,
                                'nome_original' => $data['arquivo']->getClientOriginalName(),
                                'mime_type' => $data['arquivo']->getMimeType(),
                                'tamanho' => $data['arquivo']->getSize(),
                            ]);
            
                            } catch (\Exception $e) {
                                logger()->error('Erro ao processar anexo: ' . $e->getMessage());
                                throw new \Exception('Erro ao processar o arquivo: ' . $e->getMessage());
                            }
                }
    
                throw new \Exception('Nenhum arquivo foi enviado.');
            })
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => Storage::disk('public')->url($record->caminho))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if (Storage::disk('public')->exists($record->caminho)) {
                            Storage::disk('public')->delete($record->caminho);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if (Storage::disk('public')->exists($record->caminho)) {
                                    Storage::disk('public')->delete($record->caminho);
                                }
                            }
                        }),
                ]),
            ]);
    }
}