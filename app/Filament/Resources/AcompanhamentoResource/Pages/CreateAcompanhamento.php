<?php

namespace App\Filament\Resources\AcompanhamentoResource\Pages;

use App\Filament\Resources\AcompanhamentoResource;
use Filament\Actions;
use App\Models\acompanhamentos;
use App\Models\AnexoAComp;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateAcompanhamento extends CreateRecord
{
    protected static string $resource = AcompanhamentoResource::class;
    protected static ?string $title = 'Novo Acompanhamento';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // Salvar os anexos após criar o requerimento
    $anexos = $this->data['anexos'] ?? [];

    foreach ($anexos as $anexoPath) {
        try {
            // Define o diretório específico para o requerimento
            $diretorioRequerimento = 'anexos/acompanhamento/' . $this->record->id;
            
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
            AnexoAcomp::create([
                'acompanhamento_id' => $this->record->id,
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

        
    }
}