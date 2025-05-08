<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AnexoAcomp extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'acompanhamento_id',
        'caminho',
        'nome_original',
        'mime_type',
        'tamanho',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
    public function acompanhamento()
    {
        return $this->belongsTo(Acompanhamento::class, 'acompanhamento_id');
    }

    // Método para obter o caminho completo do arquivo
   /* public function getCaminhoCompletoAttribute()
    {
        return storage_path('app/public/' . $this->caminho);
    }*/

    // Método para URL acessível publicamente
    public function getUrlAttribute()
    {
        return asset('storage/' . str_replace('public/', '', $this->caminho));
    }

   
}