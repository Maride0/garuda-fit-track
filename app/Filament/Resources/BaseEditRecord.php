<?php

namespace App\Filament\Resources;

use Filament\Resources\Pages\EditRecord;

abstract class BaseEditRecord extends EditRecord
{
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Simpan Perubahan')
                ->icon('heroicon-m-pencil-square')
                ->color('primary') 
                ->size('lg'),

            $this->getCancelFormAction()
                ->label('Batal')
                ->icon('heroicon-m-x-circle')
                ->color('gray'),
        ];
    }
}
