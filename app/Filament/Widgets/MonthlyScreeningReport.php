<?php

// namespace App\Filament\Widgets;

// use App\Models\HealthScreening;
// use Filament\Widgets\StatsOverviewWidget;
// use Filament\Widgets\StatsOverviewWidget\Stat;
// use Illuminate\Support\Carbon;

// class MonthlyScreeningReport extends StatsOverviewWidget
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

//         $monthLabel = $start->translatedFormat('F Y'); // contoh: "November 2025"
//         return "Laporan Kesehatan Bulanan — {$monthLabel}";
//     }

//     protected function getStats(): array
//     {
//         [$start, $end] = $this->getPeriod();

//         $baseQuery = HealthScreening::query()
//             ->whereBetween('screening_date', [$start->toDateString(), $end->toDateString()]);

//         $total         = (clone $baseQuery)->count();
//         $fit           = (clone $baseQuery)->where('screening_result', 'fit')->count();
//         $restricted    = (clone $baseQuery)->where('screening_result', 'restricted')->count();
//         $activeTherapy = (clone $baseQuery)->where('screening_result', 'active_therapy')->count();
//         $followUp      = (clone $baseQuery)->where('exam_type', 'follow_up')->count();

//         return [
//             Stat::make('Total Pemeriksaan', $total),
//             Stat::make('Hasil Fit', $fit),
//             Stat::make('Hasil Terbatas', $restricted),
//             Stat::make('Hasil Active Therapy', $activeTherapy),
//             Stat::make('Pemeriksaan Follow-up', $followUp),
//         ];
//     }
//     protected function getColumns(): int|array
//     {
//         return 3;
//     }

// }
