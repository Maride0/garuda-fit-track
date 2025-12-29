<?php

namespace App\Filament\Resources\ExpensesResource\Pages;

use App\Filament\Resources\ExpensesResource\ExpensesResource;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BaseCreateRecord;

class CreateExpenses extends BaseCreateRecord
{
    protected static string $resource = ExpensesResource::class;

        public static function getNavigationLabel(): string
    {
        return 'Pengeluaran';
    }

    public function getTitle(): string
    {
        return 'Tambah Pengeluaran';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }
}
