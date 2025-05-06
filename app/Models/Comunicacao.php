<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Comunicacao extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $table = 'comunicacoes';

    protected $fillable = [
        'requerimento_id',
        'user_id',
        'mensagem',
        'observacao',
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
}