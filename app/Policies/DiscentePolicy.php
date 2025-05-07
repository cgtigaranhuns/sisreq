<?php

namespace App\Policies;

use App\Models\Discente;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiscentePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //return $user->hasPermissionTo('Ver Todos Discentes');
        return $user->hasPermissionTo('Ver Discente');// && !$user->hasRole('Discente');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Discente $discente): bool
    {
        
        return $user->hasPermissionTo('Ver Discente') &&
           ($user->hasRole('Discente') ? $discente->matricula === $user->matricula : true);
        
       // return $user->hasPermissionTo('Ver Discente');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Discente') && !$user->hasRole('Discente');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Discente $discente): bool
    {
       return $user->hasPermissionTo('Alterar Discente') &&
        ($user->hasRole('Discente') ? $discente->matricula === $user->matricula : true);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Discente $discente): bool
    {
        return $user->hasPermissionTo('Deletar Discente') && !$user->hasRole('Discente');
    }

    
}