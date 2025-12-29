<?php

namespace App\Filament\Resources\HealthScreenings\Pages;

use App\Filament\Resources\HealthScreenings\HealthScreeningResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class ListHealthScreenings extends ListRecords
{
    protected static string $resource = HealthScreeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Skrining Kesehatan'),

            Action::make('export')
                ->label('Ekspor PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->form([
            DatePicker::make('from')
                ->displayFormat('d/m/Y')
                ->label('Dari Tanggal')
                ->native(false)
                ->default(now()),

            DatePicker::make('to')
                ->displayFormat('d/m/Y')
                ->label('Sampai Tanggal')
                ->native(false)
                ->default(now()),

            Select::make('result')
                ->label('Hasil Pemeriksaan')
                ->options([
                    'fit'             => 'Fit',
                    'restricted'      => 'Restricted',
                    'active_therapy'  => 'Active Therapy',
                    'injury_check'    => 'Injury Check',
                    'follow_up'       => 'Follow-up',
                ])
                ->placeholder('Semua Hasil')
        ])
    ->action(function (array $data) {
                return redirect()->route('health.export.pdf', $data);
            }),
        ];
        
    }
}
