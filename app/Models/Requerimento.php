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
        'num_processo',
        'processo_sei',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Prevenir que operações em anexos atualizem o timestamp do requerimento
        static::updating(function ($model) {
            // Se estiver apenas atualizando o timestamp, não disparar eventos
            if (count(array_diff(array_keys($model->getDirty()), ['updated_at'])) === 0) {
                return false;
            }
        });
    }

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
        return $this->belongsTo(TipoRequerimento::class);
    }

     // Status possíveis
     const STATUS_PENDENTE = 'pendente';
     const STATUS_EM_ANALISE = 'em_analise';
     const STATUS_FINALIZADO = 'finalizado';
 
     public function informacaoComplementar()
     {
         return $this->hasOne(infor_complement::class, 'requerimento_id', 'id');
         //return $this->hasOne(infor_complement::class);
     }
         // Adicione dentro da classe
     public function acompanhamentos()
     {
         return $this->hasMany(Acompanhamento::class);
     }
 
     // Nova relação com anexos
    public function anexos()
    {
        return $this->hasMany(Anexo::class);
    }
     // Verifica se o requerimento pode ser editado
     public function podeSerEditado(): bool
     {
         return $this->status !== self::STATUS_FINALIZADO;
     }
}