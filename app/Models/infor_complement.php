<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class infor_complement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_requerimento',
        'descricao',
        'status',
        
    ];

    public function requerimento(): BelongsTo
    {
        return $this->belongsTo(requerimentos::class, 'id_requerimento');
    }
}