<?php

namespace App\Mail;

use App\Models\Requerimento;
use App\Models\Discente;
use App\Models\Anexo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequerimentoAtualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $requerimento;
    public $discente;
    public $destinatario;
    public $anexo;
    public $acao;

    public function __construct(Requerimento $requerimento, Discente $discente, $destinatario, ?Anexo $anexo = null, ?string $acao = null)
    {
        $this->requerimento = $requerimento;
        $this->discente = $discente;
        $this->destinatario = $destinatario;
        $this->anexo = $anexo;
        $this->acao = $acao;
    }

    public function build()
    {
        $subject = $this->getSubject();

        return $this->subject($subject)
                    ->view('emails.requerimentoAtualizado')
                    ->with([
                        'requerimento' => $this->requerimento,
                        'discente' => $this->discente,
                        'destinatario' => $this->destinatario,
                        'anexo' => $this->anexo,
                        'acao' => $this->acao,
                    ]);
    }

    private function getSubject(): string
    {
        $baseSubject = $this->destinatario === 'discente' 
            ? "Seu requerimento #{$this->requerimento->id} foi "
            : "Requerimento #{$this->requerimento->id} foi ";

        switch ($this->acao) {
            case 'criado':
                return $baseSubject . 'adicionado um novo anexo';
            case 'atualizado':
                return $baseSubject . 'atualizado o anexo';
            case 'deletado':
                return $baseSubject . 'removido um anexo';
            default:
                return $baseSubject . 'atualizado';
        }
    }
}