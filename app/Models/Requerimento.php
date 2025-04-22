<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Requerimento extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'id',
        'user_id',
        'discente_id',
        'tipo_requerimento_id',
        'observacoes',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function discente()
    {
        return $this->belongsTo(Discente::class);
    }

    // Relacionamento com Curso
    public function tipo_requerimento()
    {
        return $this->belongsTo(Tipo_requerimento::class);
    }
}