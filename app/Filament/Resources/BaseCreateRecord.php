<?php

namespace App\Filament\Resources;

use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;

abstract class BaseCreateRecord extends CreateRecord
{
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Simpan')
                ->icon('heroicon-m-plus-circle')
                ->color('primary'),

            $this->getCreateAnotherFormAction()
                ->label('Simpan & Tambah Lagi')
                ->icon('heroicon-m-folder-plus')
                ->color('gray'),

            $this->getCancelFormAction()
                ->label('Batal')
                ->icon('heroicon-m-x-circle')
                ->color('gray'),
        ];
    }
}
