<?php

namespace App\Http\Middleware;


use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class CustomFilamentAuthenticate extends FilamentAuthenticate
{
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
        parent::__construct($auth);
    }

    protected function authenticate($request, array $guards): void
    {
        // Use diretamente o guard do Filament
        if (Auth::guard(Filament::getAuthGuard())->check()) {
            return;
        }

        $this->redirectToLogin($request);
    }
    
    // Adicione este método para obter o guard do Filament
    protected function getGuard()
    {
        return Filament::getAuthGuard();
    }
    
    // Adicione este método para redirecionar para a página de login
    protected function redirectToLogin(Request $request)
    {
        if ($request->expectsJson()) {
            abort(401);
        }

        $this->unauthenticated($request, [$this->getGuard()]);
    }
    
    // Sobrescreva o método unauthenticated para redirecionar para a página de login do Filament
    protected function unauthenticated($request, array $guards)
    {
        return redirect()->route('filament.admin.auth.login');
    }
}