<?php

namespace App\Filament\Resources\PerformanceMetrics\Pages;

use App\Filament\Resources\PerformanceMetrics\PerformanceMetricResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPerformanceMetrics extends ListRecords
{
    protected static string $resource = PerformanceMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
