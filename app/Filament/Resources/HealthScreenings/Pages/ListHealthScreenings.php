<?php

namespace App\Filament\Resources\HealthScreenings\Pages;

use App\Filament\Resources\HealthScreenings\HealthScreeningResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHealthScreenings extends ListRecords
{
    protected static string $resource = HealthScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
