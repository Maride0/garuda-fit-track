<?php

namespace App\Filament\Resources;

use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;

abstract class BaseEditRecord extends EditRecord
{
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus'),
        ];
    }

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
