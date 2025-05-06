<?php

namespace App\Filament\Resources\ComunicacaoResource\Pages;

use App\Filament\Resources\ComunicacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComunicacao extends CreateRecord
{
    protected static string $resource = ComunicacaoResource::class;
    protected static ?string $title = 'Novo Comunicado';
}