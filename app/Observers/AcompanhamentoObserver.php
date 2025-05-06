<?php

namespace App\Observers;

use App\Models\Acompanhamento;
use App\Mail\AcompanhamentoNotificacao;
use Illuminate\Support\Facades\Mail;

class AcompanhamentoObserver
{
    // Disparado quando um novo acompanhamento é criado
    public function created(Acompanhamento $acompanhamento)
    {
        $this->enviarEmails($acompanhamento, "Novo acompanhamento criado");
    }

    // Disparado quando um acompanhamento é atualizado
    public function updated(Acompanhamento $acompanhamento)
    {
        if ($acompanhamento->isDirty('descricao') || $acompanhamento->isDirty('finalizador')) {
            $this->enviarEmails($acompanhamento, "Acompanhamento atualizado");
        }
    }

    private function enviarEmails(Acompanhamento $acompanhamento, string $assuntoBase)
    {
        $requerimento = $acompanhamento->requerimento;
        $discente = $requerimento->discente;
        $adminEmail = env('MAIL_ADMIN');

        // Dados para a view
        $dados = [
            'requerimento' => $requerimento,
            'discente' => $discente,
            'acompanhamento' => $acompanhamento,
            'assuntoBase' => $assuntoBase
        ];

        // Envia e-mail para o admin
        if ($adminEmail) {
            Mail::to($adminEmail)->send(
                new AcompanhamentoNotificacao($dados, 'admin')
            );
        }

        // Envia e-mail para o discente
        if ($discente->email) {
            Mail::to($discente->email)->send(
                new AcompanhamentoNotificacao($dados, 'discente')
            );
        }
    }
}