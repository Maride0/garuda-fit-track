<?php

// namespace App\Filament\Widgets;

// use App\Models\TherapySchedule;
// use Filament\Widgets\StatsOverviewWidget;
// use Filament\Widgets\StatsOverviewWidget\Stat;
// use Illuminate\Support\Carbon;

// class MonthlyTherapyReport extends StatsOverviewWidget
// {
//     protected function getPeriod(): array
//     {
//         $month = (int) request('month', now()->month);
//         $year  = (int) request('year', now()->year);

//         if ($month < 1 || $month > 12) {
//             $month = now()->month;
//         }

//         if ($year < 2000 || $year > 2100) {
//             $year = now()->year;
//         }

//         $start = Carbon::create($year, $month, 1)->startOfMonth();
//         $end   = (clone $start)->endOfMonth();

//         return [$start, $end];
//     }

//     protected function getHeading(): ?string
//     {
//         [$start, ] = $this->getPeriod();
//         $monthLabel = $start->translatedFormat('F Y');

//         return "Laporan Terapi Bulanan — {$monthLabel}";
//     }

//     protected function getStats(): array
//     {
//         [$start, $end] = $this->getPeriod();

//         $baseQuery = TherapySchedule::query()
//             ->whereBetween('start_date', [$start->toDateString(), $end->toDateString()]);

//         $total      = (clone $baseQuery)->count();
//         $planned    = (clone $baseQuery)->where('status', 'planned')->count();
//         $active     = (clone $baseQuery)->where('status', 'active')->count();
//         $completed  = (clone $baseQuery)->where('status', 'completed')->count();
//         $cancelled  = (clone $baseQuery)->where('status', 'cancelled')->count();

//         $avgProgress = (clone $baseQuery)->avg('progress') ?? 0;
//         $avgProgress = round($avgProgress);

//         return [
//             Stat::make('Total Program Terapi', $total),
//             Stat::make('Terapi Direncanakan', $planned),
//             Stat::make('Terapi Aktif', $active),
//             Stat::make('Terapi Selesai', $completed),
//             Stat::make('Terapi Dibatalkan', $cancelled),
//             Stat::make('Rata-rata Progress (%)', "{$avgProgress}%"),
//         ];
//     }
// }
