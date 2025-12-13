<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\PerformanceEvaluation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AthletePerformanceSnapshot extends Widget
{
    protected string $view = 'filament.widgets.athlete-performance-snapshot';

    protected int|string|array $columnSpan = 'full';

    public function getSnapshots(): Collection
    {
        $latestEvaluations = PerformanceEvaluation::query()
            ->with(['athlete', 'metric'])
            ->orderByDesc('evaluation_date')
            ->get()
            ->unique('athlete_id')
            ->take(8);

        $athleteIds = $latestEvaluations->pluck('athlete_id');

        $histories = PerformanceEvaluation::query()
            ->whereIn('athlete_id', $athleteIds)
            ->whereNotNull('overall_rating')
            ->orderByDesc('evaluation_date')
            ->get()
            ->groupBy('athlete_id');

        return $latestEvaluations->map(function ($eval) use ($histories) {
            $athlete = $eval->athlete;
            $history = $histories[$eval->athlete_id] ?? collect();

            $current = (float) ($eval->overall_rating ?? 0);
            $previous = optional($history->skip(1)->first())->overall_rating;

            $delta = null;
            if ($previous !== null && (float) $previous !== 0.0) {
                $delta = (($current - (float) $previous) / (float) $previous) * 100;
            }

            $trend = 'stable';
            if ($delta !== null) {
                if ($delta > 0.2) $trend = 'up';
                if ($delta < -0.2) $trend = 'down';
            }

            $metricLabel = $eval->metric?->name ?? 'Overall Rating';

            $metricValue = $eval->metric
            ? (
                $eval->value_numeric !== null
                    ? number_format($eval->value_numeric, 1)
                    : ($eval->value_label ?? '—')
            )
            : number_format($current, 1);

            $initials = $athlete?->name
                ? Str::of($athlete->name)->explode(' ')
                    ->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('')
                : 'NA';

            return [
                'name' => $athlete?->name ?? 'Unknown',
                'sport' => $athlete?->sport ?? '-',
                'initials' => $initials,
                'metric_label' => $metricLabel,
                'metric_value' => $metricValue,
                'delta' => $delta !== null ? round($delta, 1) : null,
                'trend' => $trend,
                'spark' => $history->take(8)->pluck('overall_rating')->reverse()->values()->all(),
            ];
        });
    }
}
