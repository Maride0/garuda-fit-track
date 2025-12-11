<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class HealthOverviewChart extends ChartWidget
{
    protected ?string $heading = 'Health Overview';

    protected function getData(): array
    {
        // Nanti ini bisa diganti query beneran
        $fit             = 68;
        $requiresTherapy = 18;
        $restricted      = 8;
        $pending         = 34;

        return [
            'datasets' => [
                [
                    'label' => 'Health Status',
                    'data' => [
                        $fit,
                        $requiresTherapy,
                        $restricted,
                        $pending,
                    ],
                    'backgroundColor' => [
                        '#00A651', // Fit
                        '#F4C300', // Requires Therapy
                        '#EE334E', // Restricted
                        '#0081C8', // Pending Screening
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => [
                "Fit ({$fit})",
                "Requires Therapy ({$requiresTherapy})",
                "Restricted ({$restricted})",
                "Pending Screening ({$pending})",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = [
    'sm'  => 1,
    'md'  => 1,
    'lg'  => 1,
    'xl'  => 1,
    '2xl' => 1,
    ];

}
