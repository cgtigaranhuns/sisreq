<?php

namespace App\Observers;

use App\Models\Anexo;
use App\Mail\RequerimentoAtualizado;
use App\Models\Requerimento;
use App\Models\Discente;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AnexoObserver
{
    /**
     * Handle the Anexo "updated" event.
     */
    public function updated(Anexo $anexo): void
    {
        // Verificar se houve mudanças relevantes no anexo
        if ($this->anexoFoiModificado($anexo)) {
            // Prevenir que o timestamp do requerimento seja atualizado
            Requerimento::withoutEvents(function () use ($anexo) {
                $this->enviarNotificacao($anexo, 'atualizado');
            });
        }
    }

    /**
     * Handle the Anexo "created" event.
     */
    public function created(Anexo $anexo): void
    {
        // Verificar se o anexo foi criado junto com o requerimento
        if (!$this->anexoCriadoComRequerimento($anexo)) {
            // Prevenir que o timestamp do requerimento seja atualizado
            Requerimento::withoutEvents(function () use ($anexo) {
                $this->enviarNotificacao($anexo, 'criado');
            });
        }
    }

    /**
     * Handle the Anexo "deleted" event.
     */
    public function deleted(Anexo $anexo): void
    {
        // Prevenir que o timestamp do requerimento seja atualizado
        Requerimento::withoutEvents(function () use ($anexo) {
            $this->enviarNotificacao($anexo, 'deletado');
        });
    }

    /**
     * Verifica se o anexo foi criado junto com o requerimento
     */
    private function anexoCriadoComRequerimento(Anexo $anexo): bool
    {
        $requerimento = Requerimento::find($anexo->requerimento_id);
        
        if (!$requerimento) {
            return false;
        }

        // Verificar se as datas de criação são iguais (com tolerância de alguns segundos)
        $diferencaTempo = Carbon::parse($anexo->created_at)->diffInSeconds(
            Carbon::parse($requerimento->created_at)
        );

        // Considerar que foi criado junto se a diferença for menor que 30 segundos
        return $diferencaTempo <= 30;
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

        // Enviar email para o admin - especificando que é ação de anexo
        try {
            Mail::to(config('mail.admin'))
                ->send(new RequerimentoAtualizado($requerimento, $discente, 'admin', $anexo, $acao, 'anexo'));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email para admin: ' . $e->getMessage());
        }

        // Enviar email para o discente - especificando que é ação de anexo
        try {
            if ($discente->email) {
                Mail::to($discente->email)
                    ->send(new RequerimentoAtualizado($requerimento, $discente, 'discente', $anexo, $acao, 'anexo'));
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email para discente: ' . $e->getMessage());
        }
    }
}