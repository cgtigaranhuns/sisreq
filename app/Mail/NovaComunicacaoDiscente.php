<?php

namespace App\Mail;

use App\Models\Comunicacao;
use App\Models\Discente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovaComunicacaoDiscente extends Mailable
{
    use Queueable, SerializesModels;

    public $comunicacao;
    public $discente;

    public function __construct(Comunicacao $comunicacao, Discente $discente)
    {
        $this->comunicacao = $comunicacao;
        $this->discente = $discente;
    }

    public function build()
    {
        return $this->subject('Nova Mensagem sobre Seu Requerimento - #'. $this->comunicacao->requerimento->id)
                    ->view('emails.nova_comunicacao');
    }
}