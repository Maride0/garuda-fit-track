<?php

// namespace App\Filament\Widgets;

// use App\Models\HealthScreening;
// use Filament\Tables;
// use Filament\Widgets\TableWidget as BaseWidget;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Support\Carbon;

// class InjuryFeed extends BaseWidget
// {
//     protected function getTableHeading(): ?string
// {
//     $month = (int) request('month', now()->month);
//     $year  = (int) request('year', now()->year);

//     $start = Carbon::create($year, $month, 1)->startOfMonth();

//     return 'Riwayat Cedera Terbaru — ' . $start->translatedFormat('F Y');
// }

// protected function getTableQuery(): Builder
// {
//     $month = (int) request('month', now()->month);
//     $year  = (int) request('year', now()->year);

//     $start = Carbon::create($year, $month, 1)->startOfMonth();
//     $end   = (clone $start)->endOfMonth();

//     return HealthScreening::query()
//         ->with(['athlete', 'therapySchedule'])
//         ->whereBetween('screening_date', [$start->toDateString(), $end->toDateString()])
//         ->where(function ($q) {
//             $q->where('exam_type', 'injury')
//               ->orWhereNotNull('injury_history')
//               ->orWhereNotNull('pain_location');
//         })
//         ->latest('screening_date')
//         ->limit(10);
// }

//     protected function getTableColumns(): array
//     {
//         return [
//             Tables\Columns\TextColumn::make('screening_date')
//                 ->label('Tanggal')
//                 ->date('d M Y')
//                 ->sortable(),

//             Tables\Columns\TextColumn::make('athlete.name')
//                 ->label('Atlet')
//                 ->searchable(),

//             Tables\Columns\TextColumn::make('pain_location')
//                 ->label('Lokasi Cedera')
//                 ->toggleable()
//                 ->wrap(),

//             Tables\Columns\TextColumn::make('injury_history')
//                 ->label('Ringkasan Cedera')
//                 ->limit(60)
//                 ->wrap(),

//             Tables\Columns\TextColumn::make('pain_scale')
//                 ->label('Skala Nyeri')
//                 ->formatStateUsing(fn ($state) =>
//                     $state !== null ? $state . '/10' : '-'
//                 ),

//             Tables\Columns\TextColumn::make('athlete.status')
//                 ->label('Status Atlet')
//                 ->formatStateUsing(fn (?string $state) => match ($state) {
//                     'not_screened'     => 'Belum Discreening',
//                     'fit'              => 'Fit',
//                     'under_monitoring' => 'Dalam Pemantauan',
//                     'active_therapy'   => 'Sedang Terapi',
//                     'restricted'       => 'Terbatas',
//                     default            => ucfirst((string) $state),
//                 })
//                 ->badge(),
//         ];
//     }

//     protected function isTablePaginationEnabled(): bool
//     {
//         // kita pakai limit(10), jadi nggak usah pagination
//         return false;
//     }
// }
