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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            // Branding NOA
            ->brandLogo(asset('images/Logo NOA Indonesia.png'))
            ->brandLogoHeight('6rem')

            // Warna utama Garuda crimson
            ->colors([
                'primary' => Color::hex('#A52828'),
            ])

            // Custom Filament theme kamu
            ->viteTheme('resources/css/filament/gft-noa-theme.css')

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
                HealthOverviewChart::class,
                ActiveTrainingPrograms::class,
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
