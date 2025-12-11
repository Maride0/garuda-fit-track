<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class HealthOverviewSummary extends Widget
{
    // ⬇⬇⬇ Tambahin ini
    protected static bool $isDiscovered = false;

    protected string $view = 'filament.widgets.health-overview-summary';

    protected ?string $heading = 'Health Breakdown';

    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected function getViewData(): array
    {
        $fit = 68;
        $requiresTherapy = 18;
        $restricted = 8;
        $pending = 34;

        return [
            'fit'             => $fit,
            'requiresTherapy' => $requiresTherapy,
            'restricted'      => $restricted,
            'pending'         => $pending,
        ];
    }
}
