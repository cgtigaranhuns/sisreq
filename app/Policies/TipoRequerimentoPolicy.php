<?php

namespace App\Policies;

use App\Models\TipoRequerimento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TipoRequerimentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Tipo Requerimento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TipoRequerimento $tipoRequerimento): bool
    {
        return $user->hasPermissionTo('Ver Tipo Requerimento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Tipo Requerimento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TipoRequerimento $tipoRequerimento): bool
    {
        return $user->hasPermissionTo('Alterar Tipo Requerimento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TipoRequerimento $tipoRequerimento): bool
    {
        return $user->hasPermissionTo('Deletar Tipo Requerimento');
    }

    
}