<?php

namespace App\Filament\Resources\PerformanceMetrics\Pages;

use App\Filament\Resources\PerformanceMetrics\PerformanceMetricResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPerformanceMetric extends EditRecord
{
    protected static string $resource = PerformanceMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
