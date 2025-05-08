<?php

namespace App\Filament\Resources\AcompanhamentoResource\Pages;

use App\Filament\Resources\AcompanhamentoResource;
use App\Mail\AcompanhamentoNotificacao;
use App\Models\Acompanhamento; // Importação adicionada
use App\Models\AnexoAcomp;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CreateAcompanhamento extends CreateRecord
{
    protected static string $resource = AcompanhamentoResource::class;
    protected static ?string $title = 'Novo Acompanhamento';
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // Salvar os anexos após criar o requerimento
        $anexos = $this->data['anexos'] ?? [];

        DB::transaction(function () use ($anexos) {
            $anexosSalvos = [];

            foreach ($anexos as $anexoPath) {
                try {
                    $diretorioRequerimento = 'anexos/acompanhamento/' . $this->record->id;
                    Storage::disk('public')->makeDirectory($diretorioRequerimento);
                    
                    $nomeOriginal = basename($anexoPath);
                    $nomeUnico = uniqid() . '_' . $nomeOriginal;
                    $caminhoFinal = $diretorioRequerimento . '/' . $nomeUnico;
                    
                    Storage::disk('public')->move($anexoPath, $caminhoFinal);
                    
                    $fullPath = Storage::disk('public')->path($caminhoFinal);
                    
                    $anexo = AnexoAcomp::create([
                        'acompanhamento_id' => $this->record->id,
                        'caminho' => $caminhoFinal,
                        'nome_original' => $nomeOriginal,
                        'mime_type' => mime_content_type($fullPath),
                        'tamanho' => filesize($fullPath),
                    ]);
                    
                    $anexosSalvos[] = $anexo;
                    
                } catch (\Exception $e) {
                    Log::error('Erro ao processar anexo: ' . $e->getMessage());
                    continue;
                }
            }
            
            // Envia os emails com os anexos salvos
            $this->enviarEmails($this->record, $anexosSalvos, "Novo acompanhamento criado");
        });
    }

    private function enviarEmails(\App\Models\Acompanhamento $acompanhamento, array $anexos, string $assuntoBase)
    {
        // Carrega os relacionamentos necessários
        $acompanhamento->load([
            'requerimento.discente',
            'requerimento.tipo_requerimento',
            'user'
        ]);

        $dados = [
            'requerimento' => $acompanhamento->requerimento,
            'discente' => $acompanhamento->requerimento->discente,
            'acompanhamento' => $acompanhamento,
            'assuntoBase' => $assuntoBase
        ];

        $adminEmail = env('MAIL_ADMIN');
        $discenteEmail = $acompanhamento->requerimento->discente->email;

        Log::debug('Preparando envio de emails', [
            'acompanhamento_id' => $acompanhamento->id,
            'anexos_count' => count($anexos)
        ]);

        if ($adminEmail) {
            Mail::to($adminEmail)->send(
                new AcompanhamentoNotificacao($dados, 'admin', $anexos)
            );
        }

        if ($discenteEmail) {
            Mail::to($discenteEmail)->send(
                new AcompanhamentoNotificacao($dados, 'discente', $anexos)
            );
        }
    }
}