<?php

namespace App\Filament\Resources\PerformanceMetrics\Pages;

use App\Filament\Resources\PerformanceMetrics\PerformanceMetricResource;
use App\Filament\Resources\BaseCreateRecord;

class CreatePerformanceMetric extends BaseCreateRecord
{
    protected static string $resource = PerformanceMetricResource::class;

    // HAPUS SEMUA mutateFormDataBeforeCreate yang bikin metric_id

    public function getTitle(): string
    {
        return 'Tambah Performa Metrik';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }
}
