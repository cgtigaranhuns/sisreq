<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class AcompanhamentoNotificacao extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;
    public $destinatario;
    public $anexos;

    public function __construct(array $dados, string $destinatario, $anexos = [])
    {
        $this->dados = $dados;
        $this->destinatario = $destinatario;
        $this->anexos = $anexos instanceof Collection ? $anexos : new Collection($anexos);
    }

    public function build()
    {
        logger('Dados do email', [
            'destinatario' => $this->destinatario,
            'assunto' => $this->dados['assuntoBase'],
            'anexos' => $this->anexos->toArray(),
        ]);
        
        $email = $this->subject($this->getAssunto())
                      ->view('emails.acompanhamento_notificacao', [
                          'requerimento' => $this->dados['requerimento'],
                          'discente' => $this->dados['discente'],
                          'acompanhamento' => $this->dados['acompanhamento'],
                          'destinatario' => $this->destinatario,
                          'assuntoBase' => $this->dados['assuntoBase'],
                          'anexos' => $this->anexos
                      ]);

        foreach ($this->anexos as $anexo) {
            try {
                $path = Storage::disk('public')->path($anexo->caminho);

                logger("Verificando anexo:", [
                    'caminho' => $anexo->caminho,
                    'full_path' => $path,
                    'exists' => file_exists($path),
                ]);

                if (file_exists($path)) {
                    $email->attach($path, [
                        'as' => $anexo->nome_original,
                        'mime' => mime_content_type($path),
                    ]);
                } else {
                    logger("Arquivo não encontrado: " . $path);
                }
            } catch (\Exception $e) {
                logger("Erro ao anexar arquivo: " . $e->getMessage());
            }
        }

        return $email;
    }

    private function getAssunto()
    {
        return $this->destinatario === 'admin'
            ? "[Admin] {$this->dados['assuntoBase']} - ID #{$this->dados['requerimento']->id}"
            : "{$this->dados['assuntoBase']} - ID #{$this->dados['requerimento']->id}";
    }
}