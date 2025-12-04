<?php

namespace App\Filament\Resources\AthletePerformances\Pages;

use App\Filament\Resources\AthletePerformances\AthletePerformanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAthletePerformance extends EditRecord
{
    protected static string $resource = AthletePerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
