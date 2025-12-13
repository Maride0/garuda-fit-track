<?php

namespace App\Filament\Resources\Athletes\Pages;

use App\Filament\Resources\Athletes\AthleteResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;




class ViewAthlete extends ViewRecord
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
            Action::make('editAthlete')
                    ->label('Edit Athlete')
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->url(fn ($record) => AthleteResource::getUrl('edit', ['record' => $record])),
            DeleteAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return $this->record->name;
    }
}
