<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as ModelsRole;
//use Spatie\Permission\Models\Role;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Role extends ModelsRole
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'guard_name',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
         ->logOnly(['*'])
         ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}