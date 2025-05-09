<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Acompanhamento extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'requerimento_id',
        'user_id',
        'descricao',
        'finalizador',
        'processo'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Método para acessar os anexos através do requerimento
    public function anexosDoRequerimento()
    {
        return $this->hasManyThrough(
            \App\Models\Anexo::class,
            \App\Models\Requerimento::class,
            'id',          // Foreign key on Requerimento table
            'requerimento_id', // Foreign key on Anexo table
            'requerimento_id', // Local key on Acompanhamento table
            'id'          // Local key on Requerimento table
        );
        //return $this->through('requerimento')->has('anexos');
    }

    protected static function booted()
    {
        static::created(function ($acompanhamento) {
            $acompanhamento->atualizarStatusRequerimento();
        });

        static::updated(function ($acompanhamento) {
            $acompanhamento->atualizarStatusRequerimento();
        });
        static::deleted(function ($acompanhamento) {
            // Atualiza especificamente para "em_analise" quando deletado
            if ($acompanhamento->requerimento) {
                $acompanhamento->requerimento()->update(['status' => 'em_analise']);
            }
        });
    }

    protected function atualizarStatusRequerimento()
    {
        $requerimento = $this->requerimento;

        if ($this->finalizador) {
            $requerimento->status = 'finalizado';
        } else {
            $requerimento->status = 'em_analise';
        }

        $requerimento->save();
    }

    public function anexos()
    {
        return $this->hasMany(AnexoAcomp::class);
    }
}