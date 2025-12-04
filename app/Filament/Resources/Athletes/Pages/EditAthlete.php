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
            // Nanti aktifkan lagi kalau HealthReportResource sudah ada
            // Actions\Action::make('startScreening')
            //     ->label('Start Health Screening')
            //     ->color('warning')
            //     ->icon('heroicon-o-heart')
            //     ->url(fn () => route('filament.resources.health-reports.create', [
            //         'athlete_id' => $this->record->athlete_id,
            //     ]))
            //     ->visible(fn () => $this->record->status === 'not_screened'),
            Actions\DeleteAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return $this->record->name;
    }
    public function getBreadcrumb(): string
    {
        return 'Detail Athlete';
    }

}
