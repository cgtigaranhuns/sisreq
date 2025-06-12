<?php

namespace App\Mail;

use App\Models\Requerimento;
use App\Models\Discente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovoRequerimentoCriado extends Mailable
{
    use Queueable, SerializesModels;

    public $requerimento;
    public $discente;
    public $destinatario; // 'admin' ou 'discente'

    public function __construct(Requerimento $requerimento, Discente $discente, $destinatario)
    {
        $this->requerimento = $requerimento;
        $this->discente = $discente;
        $this->destinatario = $destinatario;
    }

    public function build()
    {
        $assunto = $this->destinatario === 'admin' 
            ? '[#'.$this->requerimento->id .'] - Novo Requerimento - '.$this->requerimento->tipo_requerimento->descricao
            : 'Seu Requerimento Foi Registrado - #'.$this->requerimento->id;

        return $this->subject($assunto)
                    ->view('emails.novo_requerimento') // View do e-mail
                    ->with([
                        'requerimento' => $this->requerimento,
                        'discente' => $this->discente,
                        'destinatario' => $this->destinatario,
                    ]);
    }
}