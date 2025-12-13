<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use App\Models\Athlete;
use App\Models\Achievement;

class DashboardKpiCards extends Widget
{
    protected string $view = 'filament.widgets.dashboard-kpi-cards';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $medals = Achievement::query()
            ->selectRaw("
                SUM(CASE WHEN medal_rank = 1 THEN 1 ELSE 0 END) as gold_count,
                SUM(CASE WHEN medal_rank = 2 THEN 1 ELSE 0 END) as silver_count,
                SUM(CASE WHEN medal_rank = 3 THEN 1 ELSE 0 END) as bronze_count
            ")
            ->first();

        return [
            'totalAthletes' => Athlete::count(),
            'gold'   => (int) ($medals->gold_count ?? 0),
            'silver' => (int) ($medals->silver_count ?? 0),
            'bronze' => (int) ($medals->bronze_count ?? 0),
        ];
    }
}
