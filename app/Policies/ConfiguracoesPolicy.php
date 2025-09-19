<?php

namespace App\Policies;

use App\Models\Configuracoe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConfiguracoesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Parâmetros');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Configuracoe $configuracoe): bool
    {
        return $user->hasPermissionTo('Ver Parâmetros');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Configuracoe $configuracoe): bool
    {
        return $user->hasPermissionTo('Alterar Parâmetros');
    }
}