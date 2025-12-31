<?php

namespace App\Filament\Resources\PerformanceMetrics\Pages;

use App\Filament\Resources\PerformanceMetrics\PerformanceMetricResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BaseEditRecord;

class EditPerformanceMetric extends BaseEditRecord
{
    protected static string $resource = PerformanceMetricResource::class;

    protected function getHeaderActions(): array
{
    return [
        \Filament\Actions\DeleteAction::make()
            ->label('Hapus'),
    ];
}

}
