<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Athlete;
use Illuminate\Support\Facades\DB;

class HealthOverviewChart extends ChartWidget
{
    protected ?string $heading = 'Health Overview';
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = [
        'sm'  => 1,
        'md'  => 1,
        'lg'  => 1,
        'xl'  => 1,
        '2xl' => 1,
    ];

    protected function getData(): array
    {
        $row = Athlete::query()
            ->selectRaw("
                SUM(CASE WHEN status = 'fit' THEN 1 ELSE 0 END) AS fit,
                SUM(CASE WHEN status = 'under_monitoring' THEN 1 ELSE 0 END) AS under_monitoring,
                SUM(CASE WHEN status = 'active_therapy' THEN 1 ELSE 0 END) AS active_therapy,
                SUM(CASE WHEN status = 'restricted' THEN 1 ELSE 0 END) AS restricted,
                SUM(CASE WHEN status = 'not_screened' OR status IS NULL THEN 1 ELSE 0 END) AS pending
            ")
            ->first();

        $fit            = (int) ($row->fit ?? 0);
        $underMonitoring= (int) ($row->under_monitoring ?? 0);
        $activeTherapy  = (int) ($row->active_therapy ?? 0);
        $restricted     = (int) ($row->restricted ?? 0);
        $pending        = (int) ($row->pending ?? 0);

        return [
            'datasets' => [
                [
                    'label' => 'Health Status',
                    'data' => [$fit, $underMonitoring, $activeTherapy, $restricted],
                    'backgroundColor' => [
                        '#0081C8', // Fit
                        '#F4C300', // Under Monitoring
                        // 'rgba(0, 0, 0, 1)', // Pending Screening
                        '#00A651', // Active Therapy
                        '#EE334E', // Restricted
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => [
                "Fit ({$fit})",
                "Dalam Pemantauan ({$underMonitoring})",
                // "Pending Screening ({$pending})",
                "Sedang Terapi ({$activeTherapy})",
                "Terbatas ({$restricted})",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getExtraAttributes(): array
    {
        return [
            'class' => 'gft-health-overview',
        ];
    }

    // Ini yang bikin height "beneran nurut":
    protected function getOptions(): array
    {
        return [
            'cutout' => '70%', // 🔥 ini kuncinya
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
