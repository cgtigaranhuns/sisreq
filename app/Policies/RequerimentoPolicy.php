<?php

namespace App\Policies;

use App\Models\Requerimento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequerimentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('Ver Requerimentos');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Requerimento $requerimento): bool
    {
        return $user->hasPermissionTo('Ver Requerimentos')&&
        ($user->hasRole('Discente') ? $requerimento->discente->matricula === $user->matricula : true);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Criar Requerimentos');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Requerimento $requerimento): bool
    {
        // Se o usuário é Admin, permite a edição sem restrições
       /* if ($user->hasRole('Admin')) {
            return true;
        }*/
        // Verifica se o status não é 'Em_analise' ou 'finalizado'
        $statusPermitidos = !in_array($requerimento->status, ['em_analise', 'finalizado']);
        return $user->hasPermissionTo('Alterar Requerimentos')&&
        ($user->hasRole('Discente') ? $requerimento->discente->matricula === $user->matricula && $statusPermitidos
        : $statusPermitidos);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Requerimento $requerimento): bool
    {
        // Verifica se o status não é 'Em_analise' ou 'finalizado'
        $statusPermitidos = !in_array($requerimento->status, ['em_analise', 'finalizado']);
        return $user->hasPermissionTo('Deletar Requerimentos')&&
        ($user->hasRole('Discente') ? $requerimento->discente->matricula === $user->matricula && $statusPermitidos
        : $statusPermitidos);
    }

    
}