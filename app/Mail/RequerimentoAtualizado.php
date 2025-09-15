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
    public $tipo; // 'requerimento' ou 'anexo'

    public function __construct(Requerimento $requerimento, Discente $discente, $destinatario, ?Anexo $anexo = null, ?string $acao = null, ?string $tipo = 'requerimento')
    {
        $this->requerimento = $requerimento;
        $this->discente = $discente;
        $this->destinatario = $destinatario;
        $this->anexo = $anexo;
        $this->acao = $acao;
        $this->tipo = $tipo;
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
                        'tipo' => $this->tipo,
                    ]);
    }

    private function getSubject(): string
{
    // Se for uma ação de anexo, trata especificamente
    if ($this->tipo === 'anexo') {
        $baseSubject = $this->destinatario === 'discente' 
            ? "Seu requerimento #{$this->requerimento->id}: "
            : "Requerimento #{$this->requerimento->id}: ";

        switch ($this->acao) {
            case 'criado':
                return $baseSubject . 'Novo anexo adicionado';
            case 'atualizado':
                return $baseSubject . 'Anexo atualizado';
            case 'deletado':
                return $baseSubject . 'Anexo removido';
            default:
                return $baseSubject . 'Alteração no anexo';
        }
    }

    // Se for ação do requerimento (mantém a lógica original)
    $baseSubject = $this->destinatario === 'discente' 
        ? "Seu requerimento #{$this->requerimento->id} Foi "
        : "Requerimento #{$this->requerimento->id} Foi ";

    switch ($this->acao) {
        case 'criado':
            return $baseSubject . 'criado';
        case 'atualizado':
            return $baseSubject . 'atualizado';
        case 'deletado':
            return $baseSubject . 'excluído';
        default:
            return $baseSubject . 'atualizado';
    }
}
}