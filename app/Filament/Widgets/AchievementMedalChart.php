<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Achievement;

class AchievementMedalChart extends ChartWidget
{
    protected ?string $heading = 'Achievement Medals Overview';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $gold   = Achievement::where('medal_rank', 'gold')->count();
        $silver = Achievement::where('medal_rank', 'silver')->count();
        $bronze = Achievement::where('medal_rank', 'bronze')->count();

        return [
            'labels' => ['Gold', 'Silver', 'Bronze'],
            'datasets' => [
                [
                    'data' => [$gold, $silver, $bronze],
                ],
            ],
        ];
    }
    protected function getOptions(): array
    {
        return [
            'cutout' => '74%',
        ];
    }
}
