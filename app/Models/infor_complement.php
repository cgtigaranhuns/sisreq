<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class infor_complement extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'id',
        'id_requerimento',
        'descricao',
        'status',
        
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
    public function requerimento(): BelongsTo
    {
        return $this->belongsTo(Requerimento::class, 'id_requerimento');
    }
}