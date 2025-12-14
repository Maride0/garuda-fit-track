<?php

namespace App\Filament\Resources\Athletes\Pages;

use App\Filament\Resources\Athletes\AthleteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditAthlete extends EditRecord
{
    protected static string $resource = AthleteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToIndex')
                ->label('Kembali ke Athltes')
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
        return 'Edit Atlete';
    }
    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('view', [
            'record' => $this->record,
        ]);
    }

}
