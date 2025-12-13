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

class SupervisorPanelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            // ✅ ID harus match sama User::canAccessPanel()
            ->id('supervisor')

            // ✅ URL panel
            ->path('supervisor')

            // ✅ enable login page untuk panel ini
            ->login()

            // ✅ setelah login landing ke sini
            ->authGuard('supervisor')

            ->brandLogo(asset('images/2.png'))
            ->brandLogoHeight('4rem')


            // ✅ pake theme kamu biar konsisten
            ->viteTheme('resources/css/filament/gft-noa-theme.css')
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.hooks.brand-logo-swap'),
            )

            // (opsional) warna primary sama kayak admin biar nyatu
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
