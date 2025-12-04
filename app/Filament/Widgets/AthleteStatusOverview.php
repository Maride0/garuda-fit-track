<?php

namespace App\Filament\Widgets;

use App\Models\Athlete;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AthleteStatusOverview extends StatsOverviewWidget
{
    protected function getColumns(): int|array
    {
        return 4; // 4 kolom/baris → rapi kayak di mockup
    }

    protected function getStats(): array
    {
        $fit           = Athlete::where('status', 'fit')->count();
        $notFit        = Athlete::where('status', 'restricted')->count();
        $recovery      = Athlete::where('status', 'under_monitoring')->count();
        $activeTherapy = Athlete::where('status', 'active_therapy')->count();

        return [
            Stat::make('Atlet Fit', $fit),
            Stat::make('Atlet Tidak Fit', $notFit),
            Stat::make('Dalam Pemantauan', $recovery),
            Stat::make('Sedang Terapi', $activeTherapy),
        ];
    }
}
