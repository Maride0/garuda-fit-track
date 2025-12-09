<?php

namespace App\Filament\Resources\TestRecords\Pages;

use App\Filament\Resources\TestRecords\TestRecordResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTestRecord extends CreateRecord
{
    protected static string $resource = TestRecordResource::class;
}
