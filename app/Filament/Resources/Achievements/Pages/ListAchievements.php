<?php

namespace App\Filament\Resources\Achievements\Pages;

use App\Filament\Resources\Achievements\AchievementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;

class ListAchievements extends ListRecords
{
    protected static string $resource = AchievementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('exportPdf')
                ->label('Ekspor Prestasi')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
                    DatePicker::make('from_date')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->label('Dari Tanggal'),

                    DatePicker::make('to_date')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->label('Sampai Tanggal'),
                ])
                ->action(function (array $data) {
                    return redirect()->route('achievements.export.pdf', [
                        'from' => $data['from_date'],
                        'to'   => $data['to_date'],
                    ]);
                }),
        ];
    }
}
