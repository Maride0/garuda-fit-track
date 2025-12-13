<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Athlete;
use App\Models\HealthScreening;
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
        // Ambil screening TERBARU per athlete (pakai MAX(created_at) biar gampang)
        $latestPerAthlete = HealthScreening::query()
            ->select('athlete_id', DB::raw('MAX(created_at) as latest_created_at'))
            ->groupBy('athlete_id');

        // Join ke health_screenings untuk dapat display_result dari yang latest
        $latestScreenings = HealthScreening::query()
            ->joinSub($latestPerAthlete, 'ls', function ($join) {
                $join->on('health_screenings.athlete_id', '=', 'ls.athlete_id')
                     ->on('health_screenings.created_at', '=', 'ls.latest_created_at');
            });

        // Count per hasil
        $counts = $latestScreenings
            ->select('health_screenings.screening_result', DB::raw('COUNT(*) as total'))
            ->groupBy('health_screenings.screening_result')
            ->pluck('total', 'screening_result');

        $fit             = (int) ($counts['fit'] ?? 0);
        $requiresTherapy = (int) ($counts['requires_therapy'] ?? 0);
        $activeTherapy   = (int) ($counts['active_therapy'] ?? 0);
        $restricted      = (int) ($counts['restricted'] ?? 0);

        // Pending = athlete yang belum punya screening sama sekali (atau status not_screened)
        $pending = Athlete::query()
            ->whereDoesntHave('healthScreenings')
            ->orWhere('status', 'not_screened')
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Health Status',
                    'data' => [$fit, $requiresTherapy, $activeTherapy, $restricted, $pending],
                    'backgroundColor' => [
                        '#00A651', // Fit
                        '#F4C300', // Requires Therapy
                        '#00B3B8', // Active Therapy
                        '#EE334E', // Restricted
                        '#0081C8', // Pending Screening
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => [
                "Fit ({$fit})",
                "Requires Therapy ({$requiresTherapy})",
                "Active Therapy ({$activeTherapy})",
                "Restricted ({$restricted})",
                "Pending Screening ({$pending})",
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


}
