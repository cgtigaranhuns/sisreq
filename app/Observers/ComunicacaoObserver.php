<?php

namespace App\Observers;

use App\Models\Comunicacao;
use App\Mail\NovaComunicacaoDiscente;
use Illuminate\Support\Facades\Mail;


class ComunicacaoObserver
{
    /**
     * Handle the Comunicacao "created" event.
     */
    public function created(Comunicacao $comunicacao): void
    {
        $requerimento = $comunicacao->requerimento;
        $discente = $requerimento->discente;
        
        // Verifica se o discente tem e-mail cadastrado
        if ($discente && $discente->email) {
            Mail::to($discente->email)
                ->send(new NovaComunicacaoDiscente($comunicacao, $discente));
        }
    }

    /**
     * Handle the Comunicacao "updated" event.
     */
    public function updated(Comunicacao $comunicacao): void
    {
        //
    }

    /**
     * Handle the Comunicacao "deleted" event.
     */
    public function deleted(Comunicacao $comunicacao): void
    {
        //
    }

    /**
     * Handle the Comunicacao "restored" event.
     */
    public function restored(Comunicacao $comunicacao): void
    {
        //
    }

    /**
     * Handle the Comunicacao "force deleted" event.
     */
    public function forceDeleted(Comunicacao $comunicacao): void
    {
        //
    }
}