<?php

namespace App\Filament\Resources\RequerimentoResource\Pages;

use App\Filament\Resources\RequerimentoResource;
use App\Models\Anexo;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditRequerimento extends EditRecord
{
    protected static string $resource = RequerimentoResource::class;
    protected static ?string $title = 'Editar Requerimento';

    protected function afterSave(): void
    {
        // Salvar os novos anexos após editar o requerimento
        $anexos = $this->data['anexos'] ?? [];

        foreach ($anexos as $anexoPath) {
            $fullPath = Storage::disk('public')->path($anexoPath);

            Anexo::create([
                'requerimento_id' => $this->record->id,
                'caminho' => $anexoPath,
                'nome_original' => basename($anexoPath),
                'mime_type' => mime_content_type($fullPath),
                'tamanho' => filesize($fullPath),
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
          //  Actions\DeleteAction::make(),
        ];
    }
}