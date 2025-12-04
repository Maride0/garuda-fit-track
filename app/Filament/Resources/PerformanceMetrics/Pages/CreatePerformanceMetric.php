<?php

namespace App\Filament\Resources\PerformanceMetrics\Pages;

use App\Filament\Resources\PerformanceMetrics\PerformanceMetricResource;
use App\Models\PerformanceMetric;
use Filament\Resources\Pages\CreateRecord;


class CreatePerformanceMetric extends CreateRecord
{
    protected static string $resource = PerformanceMetricResource::class;

    // (optional) kalau nggak mau ada "Create & create another"
    // protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $last = PerformanceMetric::query()
            ->orderBy('metric_id', 'desc')
            ->first();

        $nextNumber = $last
            ? ((int) substr($last->metric_id, 3)) + 1
            : 1;

        $data['metric_id'] = 'MET' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $data;
    }

    public function getTitle(): string
    {
        return 'Create Performance Metric';
    }
}
