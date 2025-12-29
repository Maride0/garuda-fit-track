<?php

namespace App\Filament\Resources\Athletes\Pages;

use App\Filament\Resources\Athletes\AthleteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;
use App\Filament\Resources\BaseEditRecord;

class EditAthlete extends BaseEditRecord
{
    protected static string $resource = AthleteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToIndex')
                ->label('Kembali ke Atlet')
                ->icon('heroicon-o-arrow-left')
                ->url(AthleteResource::getUrl())
                ->color('gray'),
         ];
    }
    public function getTitle(): string
    {
        return $this->record->name;
    }
    public function getBreadcrumb(): string
    {
        return 'Edit Atlet';
    }
    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('view', [
            'record' => $this->record,
        ]);
    }

}
