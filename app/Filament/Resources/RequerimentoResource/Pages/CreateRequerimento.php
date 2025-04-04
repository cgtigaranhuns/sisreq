<?php
// app/Filament/Resources/RequerimentoResource/Pages/CreateRequerimento.php
namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use App\Models\infor_complement;
use App\Models\requerimentos;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequerimento extends CreateRecord
{
    protected static string $resource = RequerimentoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove os campos que não pertencem ao modelo Requerimento
        unset($data['tem_informacoes_complementares']);
        unset($data['descricao_complementar']);
        unset($data['status_complementar']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Verifica se há informações complementares para salvar
        if ($this->data['tem_informacoes_complementares'] && 
            !empty($this->data['descricao_complementar'])) {
            
            infor_complement::create([
                'id_requerimento' => $this->record->id,
                'descricao' => $this->data['descricao_complementar'],
                'status' => $this->data['status_complementar'] ?? 'pendente',
            ]);
        }
    }
}