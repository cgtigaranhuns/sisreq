<?php
namespace App\Jobs;

use App\Models\Requerimento;
use App\Mail\NovoRequerimentoCriado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendRequerimentoEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $requerimento;
    public $delayInSeconds;

    public function __construct(Requerimento $requerimento, $delayInSeconds = 5)
    {
        $this->requerimento = $requerimento;
        $this->delayInSeconds = $delayInSeconds;
    }

    public function handle()
    {
        try {
            
            $discente = $this->requerimento->discente;
            $adminEmail = env('MAIL_ADMIN');

            // Validações
            if (!$discente) {
                Log::error("Discente não encontrado para o requerimento ID: {$this->requerimento->id}");
                return;
            }

            // E-mail para o ADMIN
            if ($adminEmail) {
                Mail::to($adminEmail)->send(
                    new NovoRequerimentoCriado($this->requerimento, $discente, 'admin')
                );
            }

            // E-mail para o DISCENTE
            if ($discente->email) {
                Mail::to($discente->email)->send(
                    new NovoRequerimentoCriado($this->requerimento, $discente, 'discente')
                );
            }

        } catch (\Exception $e) {
            Log::error("Erro ao enviar e-mails para o requerimento ID: {$this->requerimento->id}. Erro: " . $e->getMessage());
        }
    }

    // Define o delay para a fila
    public function delay()
    {
        return now()->addSeconds($this->delayInSeconds);
    }
}