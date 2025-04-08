<?php

namespace App\Filament\Resources\DiscenteResource\Pages;

use App\Filament\Resources\DiscenteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDiscente extends CreateRecord
{
    protected static string $resource = DiscenteResource::class;
    protected static ?string $title = 'Novo Discente';
}