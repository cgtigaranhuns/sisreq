<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup;
use Rmsramos\Activitylog\ActivitylogPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->darkmode(false)
            ->brandLogoHeight('4.3rem')
            ->brandLogo(asset('img/Logo-Garanhuns.png'))
            ->favicon(asset('img/logo-ifpe.png'))
            ->brandName('SISREQ')
            ->colors([
                //'primary' => Color::Amber,
                'primary' => '#3CB371',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
               // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                ->label('Cadastros')
          
                ->collapsed(true),
                //->collapsible(),
                //->sidebarCollapsibleOnDesktop(),
                NavigationGroup::make()
                ->label('Segurança'),
              //  ->icon('heroicon-o-shopping-cart'),
                NavigationGroup::make()
                ->label('Configurações'),
                //->icon('heroicon-o-shopping-cart'),
            ])
            /*->resources([
                config('filament-logger.activity_resource')
            ])*/
           /* ->plugins([
                ActivitylogPlugin::make(),
            ])*/
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}