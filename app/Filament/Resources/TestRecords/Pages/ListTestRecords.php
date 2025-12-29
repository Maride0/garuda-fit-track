<?php

namespace App\Filament\Resources\TestRecords\Pages;

use App\Filament\Resources\TestRecords\TestRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTestRecords extends ListRecords
{
    protected static string $resource = TestRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Catatan Performa'),
        ];
    }
}
