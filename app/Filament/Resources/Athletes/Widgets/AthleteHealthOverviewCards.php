<?php

namespace App\Filament\Resources\Athletes\Widgets;

use Filament\Widgets\Widget;
use App\Models\Athlete;

class AthleteHealthOverviewCards extends Widget
{
    protected string $view = 'filament.resources.athletes.widgets.athlete-health-overview-cards';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'totalAthletes'   => Athlete::count(),
            'athleteFit'      => Athlete::where('status', 'fit')->count(),
            'inTherapy'       => Athlete::where('status', 'active_therapy')->count(),
            'restricted'      => Athlete::where('status', 'restricted')->count(),
            'underMonitoring' => Athlete::where('status', 'under_monitoring')->count(),
            'notScreened'     => Athlete::where('status', 'not_screened')->count(),
        ];
    }
}
