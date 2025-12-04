<?php

namespace App\Filament\Resources\TherapySchedules\Pages;

use App\Filament\Resources\TherapySchedules\TherapyScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTherapySchedules extends ListRecords
{
    protected static string $resource = TherapyScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return []; // tidak ada CreateAction lagi
    }
}
