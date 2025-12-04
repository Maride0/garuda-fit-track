<?php

namespace App\Filament\Resources\ExpensesResource\Pages;

use App\Filament\Resources\ExpensesResource\ExpensesResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Image;

class ViewExpenses extends ViewRecord
{
    protected static string $resource = ExpensesResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }
}
