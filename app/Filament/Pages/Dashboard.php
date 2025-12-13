<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\AthletePerformanceSnapshot;
use App\Filament\Widgets\HealthOverviewChart;
use App\Filament\Widgets\ActiveTrainingPrograms;
use App\Filament\Widgets\UpcomingSessions;
use App\Filament\Widgets\DashboardKpiCards;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            DashboardKpiCards::class,
            HealthOverviewChart::class,
            ActiveTrainingPrograms::class,
            AthletePerformanceSnapshot::class,
            UpcomingSessions::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'sm'  => 1,
            'md'  => 1,
            'lg'  => 1,
            'xl'  => 3,
            '2xl' => 4,
        ];
    }
}
