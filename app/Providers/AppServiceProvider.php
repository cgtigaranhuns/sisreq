<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Storage;
use App\Models\Requerimento;
use App\Observers\RequerimentoObserver;
use App\Models\Acompanhamento;
use App\Observers\AcompanhamentoObserver;
use App\Models\Comunicacao;
use App\Observers\ComunicacaoObserver;
use App\Models\Anexo;
use App\Observers\AnexoObserver;
use App\Models\Configuracoe;
use App\Observers\ConfiguracoesObserver;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // $this->app->bind(LoginResponseContract::class, LoginResponse::class);

       /*  $this->app->singleton(
        LoginResponse::class,
        \App\Http\Responses\LoginResponse::class
    );*/
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            // Configurações adicionais do Filament, se necessário
        });

        Storage::disk('public')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return Storage::temporaryUrl($path, $expiration, $options);
        });

        Requerimento::observe(RequerimentoObserver::class);
        Acompanhamento::observe(AcompanhamentoObserver::class);
        Comunicacao::observe(ComunicacaoObserver::class);
        Anexo::observe(AnexoObserver::class);
        Configuracoe::observe(ConfiguracoesObserver::class);
       
    }
}