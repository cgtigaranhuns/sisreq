<?php

namespace App\Observers;

use App\Models\Requerimento;
use App\Models\User;
use App\Models\Discente;
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
            $discente = $requerimento->discente; // Assume que o relacionamento existe
            $adminEmail = env('MAIL_ADMIN');
    
            // Validações
            if (!$discente) {
                \Log::error("Discente não encontrado para o requerimento ID: {$requerimento->id}");
                return;
            }
    
            // E-mail para o ADMIN
            if ($adminEmail) {
                Mail::to($adminEmail)->send(
                    new NovoRequerimentoCriado($requerimento, $discente, 'admin')
                );
            }
    
            // E-mail para o DISCENTE
            if ($discente->email) {
                Mail::to($discente->email)->send(
                    new NovoRequerimentoCriado($requerimento, $discente, 'discente')
                );
            }
    
        } catch (\Exception $e) {
            \Log::error("Erro ao enviar e-mails para o requerimento ID: {$requerimento->id}. Erro: " . $e->getMessage());
        }
    }

    /**
     * Handle the Requerimento "updated" event.
     */
    public function updated(Requerimento $requerimento): void
    {
        //
    }

    /**
     * Handle the Requerimento "deleted" event.
     */
    public function deleted(Requerimento $requerimento): void
    {
        //
    }

    /**
     * Handle the Requerimento "restored" event.
     */
    public function restored(Requerimento $requerimento): void
    {
        //
    }

    /**
     * Handle the Requerimento "force deleted" event.
     */
    public function forceDeleted(Requerimento $requerimento): void
    {
        //
    }
}