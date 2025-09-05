<?php

namespace App\Observers;

use App\Models\Anexo;
use App\Mail\RequerimentoAtualizado;
use App\Models\Requerimento;
use App\Models\Discente;
use Illuminate\Support\Facades\Mail;

class AnexoObserver
{
    /**
     * Handle the Anexo "updated" event.
     */
    public function updated(Anexo $anexo): void
    {
        // Verificar se houve mudanças relevantes no anexo
        if ($this->anexoFoiModificado($anexo)) {
            $this->enviarNotificacao($anexo, 'atualizado');
        }
    }

    /**
     * Handle the Anexo "created" event.
     */
    public function created(Anexo $anexo): void
    {
        $this->enviarNotificacao($anexo, 'criado');
    }

    /**
     * Handle the Anexo "deleted" event.
     */
    public function deleted(Anexo $anexo): void
    {
        $this->enviarNotificacao($anexo, 'deletado');
    }

    /**
     * Verifica se o anexo foi realmente modificado (não apenas timestamps)
     */
    private function anexoFoiModificado(Anexo $anexo): bool
    {
        $mudancasRelevantes = array_diff(array_keys($anexo->getChanges()), [
            'updated_at', 'created_at', 'deleted_at'
        ]);

        return !empty($mudancasRelevantes);
    }

    /**
     * Envia notificação para admin e discente
     */
    private function enviarNotificacao(Anexo $anexo, string $acao): void
    {
        // Carregar o requerimento com as relações necessárias
        $requerimento = Requerimento::with(['discente', 'tipo_requerimento', 'informacaoComplementar'])
            ->find($anexo->requerimento_id);

        if (!$requerimento || !$requerimento->discente) {
            return;
        }

        $discente = $requerimento->discente;

        // Enviar email para o admin
        try {
            Mail::to(config('mail.admin_email')) // Configure este email no .env
                ->send(new RequerimentoAtualizado($requerimento, $discente, 'admin', $anexo, $acao));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email para admin: ' . $e->getMessage());
        }

        // Enviar email para o discente
        try {
            if ($discente->email) {
                Mail::to($discente->email)
                    ->send(new RequerimentoAtualizado($requerimento, $discente, 'discente', $anexo, $acao));
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email para discente: ' . $e->getMessage());
        }
    }
}