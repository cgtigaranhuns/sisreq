<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Discente extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
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