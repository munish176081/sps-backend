<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\Facades\Vite;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('Splendour In Stone')
            ->brandLogo(asset('images/sis-logo.png'))
            ->brandLogoHeight('60px')
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => '#283C28',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->renderHook(
            'panels::head.end',
            fn (): string => Blade::render('
                <style>
                    .fi-simple-main, .fi-topbar { background-color: #283C28 !important;}
                    .fi-topbar-start img {padding: 5px;}
                    .fi-simple-main { border-radius: 1rem; }
                    .fi-simple-main h1, 
                    .fi-simple-main .fi-simple-header-heading, 
                    .fi-simple-main .text-gray-950, 
                    .fi-simple-main .dark\:text-white { color: #ffffff !important; }
                    .fi-simple-main .fi-fo-field-label-content { color: #ffffff !important; }
                    .fi-simple-main .fi-simple-card { background-color: #283C28 !important; }
                </style>
            '),
        )
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
