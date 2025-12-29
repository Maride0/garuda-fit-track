<?php

namespace App\Filament\Resources\TestRecords\Pages;

use App\Filament\Resources\TestRecords\TestRecordResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BaseCreateRecord;

class CreateTestRecord extends BaseCreateRecord
{
    protected static string $resource = TestRecordResource::class;

    public function getTitle(): string
    {
        return 'Tambah Catatan Performa';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }
}
