<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

use App\Filament\Widgets\AthletePerformanceSnapshot;
use App\Filament\Widgets\DashboardKpiCards;
use App\Filament\Widgets\AchievementMedalChart;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Livewire::component(
            'app.filament.widgets.athlete-performance-snapshot',
            AthletePerformanceSnapshot::class
        );

        Livewire::component(
            'app.filament.widgets.dashboard-kpi-cards',
            DashboardKpiCards::class
        );
        Livewire::component(
            'app.filament.widgets.achievement-medal-chart',
            AchievementMedalChart::class
        );
    }
}
