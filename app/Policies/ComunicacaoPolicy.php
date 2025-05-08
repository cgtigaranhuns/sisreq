<?php

namespace App\Policies;

use App\Models\Comunicacao;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComunicacaoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Comunicação');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comunicacao $comunicacao): bool
    {
        return $user->hasPermissionTo('Ver Comunicação')&&
        ($user->hasRole('Discente') ? $comunicacao->requerimento->discente->matricula === $user->matricula : true);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Comunicação');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comunicacao $comunicacao): bool
    {
        return $user->hasPermissionTo('Alterar Comunicação');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comunicacao $comunicacao): bool
    {
        return $user->hasPermissionTo('Deletar Comunicação');
    }

}