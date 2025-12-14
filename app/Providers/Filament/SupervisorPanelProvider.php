<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Athletes\AthleteResource;
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
use App\Filament\Pages\Dashboard;
use App\Filament\Resources\Achievements\AchievementResource;

class SupervisorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('supervisor')
            ->path('supervisor')
            ->login()
            ->darkMode(true)
            ->authGuard('supervisor')

            ->brandName('Garuda Fit Track')
            ->brandLogo(asset('images/3.png'))
            ->brandLogoHeight('4rem')

            ->viteTheme('resources/css/filament/gft-noa-theme.css')
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.hooks.brand-logo-swap'),
            )
            ->colors([
                'primary' => Color::hex('#A52828'),
            ])

            /**
             * ✅ KUNCI: jangan discover resources/pages/widgets
             * biar panel ini cuma punya yang kita daftarin manual
             */
            ->pages([
                Dashboard::class,
            ])
            ->resources([
                AthleteResource::class,
                AchievementResource::class,
            ])
            ->widgets([])

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
