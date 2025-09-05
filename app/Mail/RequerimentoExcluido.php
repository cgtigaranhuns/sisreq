<?php

namespace App\Mail;

use App\Models\Requerimento;
use App\Models\Discente;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequerimentoExcluido extends Mailable
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
        $subject = $this->destinatario === 'discente' 
            ? "Seu requerimento #{$this->requerimento->id} foi excluído"
            : "Requerimento #{$this->requerimento->id} foi excluído";

        return $this->subject($subject)
                    ->view('emails.requerimentoExcluido')
                    ->with([
                        'requerimento' => $this->requerimento,
                        'discente' => $this->discente,
                        'destinatario' => $this->destinatario,
                    ]);
    }
}