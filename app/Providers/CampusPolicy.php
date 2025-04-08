<?php

namespace App\Policies;

use App\Models\Campus;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Campus');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campus $campus): bool
    {
        return $user->hasPermissionTo('Ver Campus');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Campus');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campus $campus): bool
    {
        return $user->hasPermissionTo('Alterar Campus');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campus $campus): bool
    {
        return $user->hasPermissionTo('Deletar Campus');
    }

    
}