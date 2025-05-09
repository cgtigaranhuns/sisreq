<?php

namespace App\Observers;

use App\Models\Acompanhamento;

class AcompanhamentoObserver
{
    public function updating(Acompanhamento $acompanhamento)
    {
        $original = $acompanhamento->getOriginal();
        
        // Verifica se o campo 'processo' foi alterado para true
        if ($acompanhamento->processo && ($original['processo'] != $acompanhamento->processo)) {
            $this->gerarPdfRequerimento($acompanhamento->requerimento);
        }
    }

    protected function gerarPdfRequerimento(Requerimento $requerimento)
    {
        $requerimento->load([
            'discente.campus',
            'discente.curso',
            'tipo_requerimento',
            'informacaoComplementar',
            'anexos'
        ]);

        $pdf = Pdf::loadView('requerimentos.show', [
            'requerimento' => $requerimento
        ]);

        $filename = "requerimento-{$requerimento->id}.pdf";
        $path = "requerimentos/{$filename}";

        Storage::put($path, $pdf->output());
        $requerimento->update(['pdf_path' => $path]);
    }
}