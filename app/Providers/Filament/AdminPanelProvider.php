<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\ActiveTrainingPrograms;
use App\Filament\Widgets\HealthOverviewChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;
use App\Filament\Widgets\UpcomingSessions;
use App\Filament\Widgets\DashboardKpiCards;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->darkMode(true)
            ->authGuard('admin')
            ->brandName('Garuda Fit Track')
            ->brandLogo(asset('images/3.png')) // ✅ ganti ke DARK
            ->brandLogoHeight('4rem')

            ->viteTheme('resources/css/filament/gft-noa-theme.css')
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.hooks.brand-logo-swap'),
            )

            // Resources & pages tetap auto-discover
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\Filament\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\Filament\Pages',
            )
            ->pages([
                Dashboard::class, // App\Filament\Pages\Dashboard
            ])

            // ⬇️ REGISTER widget-nya di panel (supaya Livewire kenal)
            ->widgets([
                DashboardKpiCards::class,
                HealthOverviewChart::class,
                ActiveTrainingPrograms::class,
                UpcomingSessions::class,
            ])

            // Middleware
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
