<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'matricula',
        'email',
        'telefone',
        'data_nascimento',
        'cpf',
        'rg',
        'campus_id',
        'curso_id',
        'situacao',
        'periodo',
        'turno',
    ];

    protected $dates = ['data_nascimento'];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    // Relacionamento com Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}