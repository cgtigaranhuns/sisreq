<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
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
    }
}