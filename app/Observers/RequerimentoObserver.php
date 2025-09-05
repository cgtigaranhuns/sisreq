<?php

namespace App\Observers;

use App\Models\Requerimento;
use App\Models\User;
use App\Models\Discente;
use App\Jobs\SendRequerimentoEmails;
use App\Jobs\SendRequerimentoUpdateEmails;
use App\Jobs\SendRequerimentoDeleteEmails;
use App\Mail\NovoRequerimentoCriado;
use Illuminate\Support\Facades\Mail;

class RequerimentoObserver
{
    /**
     * Handle the Requerimento "created" event.
     */
    public function created(Requerimento $requerimento): void
    {
      try {
        // Despacha o Job com delay de 30 segundos
        SendRequerimentoEmails::dispatch($requerimento)->delay(now()->addSeconds(5));
        } catch (\Exception $e) {
            \Log::error("Erro ao despachar job de e-mail para o requerimento ID: {$requerimento->id}. Erro: " . $e->getMessage());
        }
        }
    /**
     * Handle the Requerimento "updated" event.
     */
    public function updated(Requerimento $requerimento): void
    {
        //
        try {
            // Despacha o Job para atualização com delay de 5 segundos
            SendRequerimentoUpdateEmails::dispatch($requerimento)->delay(now()->addSeconds(5));
        } catch (\Exception $e) {
            \Log::error("Erro ao despachar job de e-mail de atualização para o requerimento ID: {$requerimento->id}. Erro: " . $e->getMessage());
        }
    }

    /**
     * Handle the Requerimento "deleted" event.
     */
    public function deleted(Requerimento $requerimento): void
    {
        //
        try {
            // Despacha o Job para exclusão com delay de 5 segundos
            SendRequerimentoDeleteEmails::dispatch($requerimento)->delay(now()->addSeconds(5));
        } catch (\Exception $e) {
            \Log::error("Erro ao despachar job de e-mail de exclusão para o requerimento ID: {$requerimento->id}. Erro: " . $e->getMessage());
        }
    }

    /**
     * Handle the Requerimento "restored" event.
     */
    public function restored(Requerimento $requerimento): void
    {
        //
        /*
        // Opcional: enviar e-mail quando um requerimento for restaurado
        try {
            SendRequerimentoUpdateEmails::dispatch($requerimento, 'restaurado')->delay(now()->addSeconds(5));
        } catch (\Exception $e) {
            \Log::error("Erro ao despachar job de e-mail de restauração para o requerimento ID: {$requerimento->id}. Erro: " . $e->getMessage());
        }
            */
    }

    /**
     * Handle the Requerimento "force deleted" event.
     */
    public function forceDeleted(Requerimento $requerimento): void
    {
        //
        /*
        // Opcional: enviar e-mail quando um requerimento for excluído permanentemente
        try {
            SendRequerimentoDeleteEmails::dispatch($requerimento, true)->delay(now()->addSeconds(5));
        } catch (\Exception $e) {
            \Log::error("Erro ao despachar job de e-mail de exclusão permanente para o requerimento ID: {$requerimento->id}. Erro: " . $e->getMessage());
        }*/
    }
}