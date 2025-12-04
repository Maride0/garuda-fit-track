<?php

namespace App\Filament\Resources\AthletePerformances\Pages;

use App\Filament\Resources\AthletePerformances\AthletePerformanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAthletePerformances extends ListRecords
{
    protected static string $resource = AthletePerformanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
