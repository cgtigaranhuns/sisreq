<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acompanhamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'requerimento_id',
        'user_id',
        'descricao',
        'finalizador'
    ];

    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class, 'requerimento_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function booted()
    {
        static::created(function ($acompanhamento) {
            $requerimento = $acompanhamento->requerimento;
            
            if ($acompanhamento->finalizador) {
                $requerimento->status = 'finalizado';
            } else {
                $requerimento->status = 'em_analise';
            }
            
            $requerimento->save();
        });
    }
}