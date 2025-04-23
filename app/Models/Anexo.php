<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Anexo extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'requerimento_id',
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
    public function requerimento()
    {
        return $this->belongsTo(Requerimento::class);
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