<?php

namespace App\Mail;

use App\Models\Acompanhamento as ModelAcompanhamento;
use App\Models\Requerimento;
use App\Models\Discente;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Acompanhamento extends Mailable
{
    use Queueable, SerializesModels;

    public $requerimento;
    public $discente;
    public $acompanhamento;
    public $destinatario; // 'admin' ou 'discente'

    public function __construct(Requerimento $requerimento, Discente $discente, ModelAcompanhamento $acompanhamento, $destinatario)
    {
        $this->requerimento = $requerimento;
        $this->discente = $discente;
        $this->acompanhamento = $acompanhamento;
        $this->destinatario = $destinatario;
    }

    public function build()
    {
        $assunto = $this->destinatario === 'admin' 
            ? '[Administrador] Status do Requerimento Atualizado' 
            : 'Seu Requerimento Foi Atualizado';

        return $this->subject($assunto)
                    ->view('emails.acompanhamento')
                    ->with([
                        'requerimento' => $this->requerimento,
                        'discente' => $this->discente,
                        'acompanhamento' => $this->acompanhamento,
                        'destinatario' => $this->destinatario,
                    ]);
    }
}