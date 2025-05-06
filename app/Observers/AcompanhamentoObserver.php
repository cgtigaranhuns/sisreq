<?php

namespace App\Observers;

use App\Models\Acompanhamento;
use App\Mail\Acompanhamento as MailAcompanhamento;
use Illuminate\Support\Facades\Mail;

class AcompanhamentoObserver
{
    /**
     * Handle the Acompanhamento "created" event.
     */
    public function created(Acompanhamento $acompanhamento): void
    {
         // Dispara se o status do requerimento foi alterado
        // if ($acompanhamento->isDirty('status')) {
            $requerimento = $acompanhamento->requerimento;
            $discente = $requerimento->discente;
            $adminEmail = env('MAIL_ADMIN');

            // Envia e-mail para o ADMIN
            if ($adminEmail) {
                Mail::to($adminEmail)->send(
                    new MailAcompanhamento($requerimento, $discente, $acompanhamento, 'admin')
                );
            }

            // Envia e-mail para o DISCENTE
            if ($discente->email) {
                Mail::to($discente->email)->send(
                    new MailAcompanhamento($requerimento, $discente, $acompanhamento, 'discente')
                );
            }
       // }
    }

    /**
     * Handle the Acompanhamento "updated" event.
     */
    public function updated(Acompanhamento $acompanhamento): void
    {
        //
    }

    /**
     * Handle the Acompanhamento "deleted" event.
     */
    public function deleted(Acompanhamento $acompanhamento): void
    {
        //
    }

    /**
     * Handle the Acompanhamento "restored" event.
     */
    public function restored(Acompanhamento $acompanhamento): void
    {
        //
    }

    /**
     * Handle the Acompanhamento "force deleted" event.
     */
    public function forceDeleted(Acompanhamento $acompanhamento): void
    {
        //
    }
}