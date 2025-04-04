<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class requerimentos extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'descricao',
        'discente',
        'curso',
        'status',
    ];

    // Status possíveis
    const STATUS_PENDENTE = 'pendente';
    const STATUS_EM_ANALISE = 'em_analise';
    const STATUS_FINALIZADO = 'finalizado';

    public function informacaoComplementar(): HasOne
    {
        return $this->hasOne(infor_complement::class, 'id_requerimento', 'id');
    }
        // Adicione dentro da classe
    public function acompanhamentos(): HasMany
    {
        return $this->hasMany(Acompanhamento::class);
    }

    // Verifica se o requerimento pode ser editado
    public function podeSerEditado(): bool
    {
        return $this->status !== self::STATUS_FINALIZADO;
    }
}