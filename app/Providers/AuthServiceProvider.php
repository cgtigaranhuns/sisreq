<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Campus::class => CampusPolicy::class,
        Discente::class => DiscentePolicy::class,
        Acompanhamento::class => AcompanhamentoPolicy::class,
        Requerimento::class => RequerimentoPolicy::class,
        TipoRequerimento::class => TipoRequerimentoPolicy::class,
        Comunicacao::class => ComunicacaoPolicy::class,
        Curso::class => CursoPolicy::class,
        Configuracoe::class => ConfiguracoesPolicy::class,
       // Tipo_requerimento::class => TipoRequerimentoPolicy::class,
        
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::provider('multi-ldap', function ($app, array $config) {
            return new MultiLdapUserProvider();
        });
    }

    public function register(): void
    {
        // Sobrescrevendo o LoginResponse do Filament
      //  $this->app->bind(LoginResponseContract::class, LoginResponse::class);
    }
}