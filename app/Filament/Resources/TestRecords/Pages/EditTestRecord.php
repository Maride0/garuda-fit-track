<?php

namespace App\Filament\Resources\TestRecords\Pages;

use App\Filament\Resources\TestRecords\TestRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BaseEditRecord;

class EditTestRecord extends BaseEditRecord
{
    protected static string $resource = TestRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
