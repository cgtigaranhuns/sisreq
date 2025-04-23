<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use App\Models\infor_complement;
use App\Models\requerimentos;
use App\Models\Anexo;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateRequerimento extends CreateRecord
{
    protected static string $resource = RequerimentoResource::class;

    protected function afterCreate(): void
    {
        // Salvar os anexos após criar o requerimento
    $anexos = $this->data['anexos'] ?? [];

    foreach ($anexos as $anexoPath) {
        try {
            // Define o diretório específico para o requerimento
            $diretorioRequerimento = 'anexos/requerimento/' . $this->record->id;
            
            // Cria o diretório se não existir
            Storage::disk('public')->makeDirectory($diretorioRequerimento);
            
            // Obtém o nome original do arquivo
            $nomeOriginal = basename($anexoPath);
            
            // Gera um nome único para o arquivo
            $nomeUnico = uniqid() . '_' . $nomeOriginal;
            
            // Cria o caminho final
            $caminhoFinal = $diretorioRequerimento . '/' . $nomeUnico;
            
            // Move o arquivo para o diretório do requerimento
            Storage::disk('public')->move($anexoPath, $caminhoFinal);
            
            // Obtém informações do arquivo
            $fullPath = Storage::disk('public')->path($caminhoFinal);
            
            // Salva no banco de dados
            Anexo::create([
                'requerimento_id' => $this->record->id,
                'caminho' => $caminhoFinal,
                'nome_original' => $nomeOriginal,
                'mime_type' => mime_content_type($fullPath),
                'tamanho' => filesize($fullPath),
            ]);
            
        } catch (\Exception $e) {
            logger()->error('Erro ao processar anexo: ' . $e->getMessage());
            continue;
        }
    }

        if ($this->data['tem_informacoes_complementares'] && 
            !empty($this->data['descricao_complementar'])) {
            
            infor_complement::create([
                'id_requerimento' => $this->record->id,
                'descricao' => $this->data['descricao_complementar'],
               // 'status' => $this->data['status_complementar'] ?? 'pendente',
            ]);
        }
    }
}