<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcompanhamentoNotificacao extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;
    public $destinatario;

    public function __construct(array $dados, string $destinatario)
    {
        $this->dados = $dados;
        $this->destinatario = $destinatario;
    }

    public function build()
    {
        $assunto = $this->destinatario === 'admin'
        ? "[Admin] {$this->dados['assuntoBase']} - Protocolo #{$this->dados['requerimento']->id}"
        : "{$this->dados['assuntoBase']} - Seu requerimento";

    return $this->subject($assunto)
                ->view('emails.acompanhamento_notificacao')
                ->with([
                    'requerimento' => $this->dados['requerimento'],
                    'discente' => $this->dados['discente'],
                    'acompanhamento' => $this->dados['acompanhamento'],
                    'destinatario' => $this->destinatario,
                    'assuntoBase' => $this->dados['assuntoBase'], // Adicione esta linha
                ]);
    }
}