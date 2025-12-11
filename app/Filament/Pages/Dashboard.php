<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\HealthOverviewChart;
use App\Filament\Widgets\ActiveTrainingPrograms;

class Dashboard extends BaseDashboard
{
    // Widget yang muncul di dashboard
    public function getWidgets(): array
    {
        return [
            HealthOverviewChart::class,
            ActiveTrainingPrograms::class,
        ];
    }

    // Layout grid dashboard
    public function getColumns(): int | array
    {
        return [
            'sm'  => 1, // HP kecil
            'md'  => 1, // HP gede / tablet portrait
            'lg'  => 1, // iPad landscape / tablet gede → layout 1:2
            'xl'  => 3, // laptop standar
            '2xl' => 4, // layar super gede (kalau nanti mau tambah widget lain)
        ];
    }

}
