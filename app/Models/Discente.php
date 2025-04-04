<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discente extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'cpf',
        'rg',
        'campus',
        'curso',
        'situacao',
        'periodo',
        'turno',
    ];

    protected $dates = ['data_nascimento'];
}