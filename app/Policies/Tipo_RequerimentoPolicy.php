<?php

namespace App\Policies;

use App\Models\Tipo_requerimento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Tipo_RequerimentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Tipo de Requerimento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tipo_requerimento $tipoRequerimento): bool
    {
        return $user->hasPermissionTo('Ver Tipo de Requerimento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Tipo de Requerimento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tipo_requerimento $tipoRequerimento): bool
    {
        return $user->hasPermissionTo('Alterar Tipo de Requerimento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tipo_requerimento $tipoRequerimento): bool
    {
        return $user->hasPermissionTo('Deletar Tipo de Requerimento');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tipo_requerimento $tipoRequerimento): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tipo_requerimento $tipoRequerimento): bool
    {
        //
    }
}