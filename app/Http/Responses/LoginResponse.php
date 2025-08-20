<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as Responsable;
use Illuminate\Http\RedirectResponse;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse
    {
       // $user = auth()->user();
        
        // Redireciona para requerimentos independente da role
        return redirect()->intended('filament.admin.resources.requerimentos.index');
        
        // Ou se quiser diferenciar por role:
        /*
        if ($user->hasRole('discente')) {
            return redirect()->route('filament.admin.resources.meus-requerimentos.index');
        }
        
        return redirect()->route('filament.admin.resources.requerimentos.index');
        */
    }
}