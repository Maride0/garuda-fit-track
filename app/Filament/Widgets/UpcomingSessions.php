<?php

namespace App\Filament\Widgets;

use App\Models\TrainingSession;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingSessions extends TableWidget
{
    protected static ?string $heading = 'Jadwal Latihan Mendatang';

    protected int|string|array $columnSpan = 'full';

    protected function getExtraAttributes(): array
    {
        return [
            'class' => 'gft-table-card gft-upcoming-schedule-card',
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->extraAttributes([
                'class' => 'gft-upcoming-schedule-table',
            ])
            ->query(fn (): Builder =>
                TrainingSession::query()
                    ->upcoming()
                    ->with('program.athletes')
                    ->orderBy('date')
                    ->orderBy('start_time')
            )
            ->paginated()
            ->columns([
                // Jadwal / Kegiatan
                TextColumn::make('activities_notes')
                    ->label('Jadwal / Kegiatan')
                    ->state(function (TrainingSession $record): string {
                        $notes = trim((string) $record->activities_notes);

                        if ($notes !== '') {
                            return $notes;
                        }

                        $start = $record->start_time
                            ? \Carbon\Carbon::parse($record->start_time)->format('H:i')
                            : '—';

                        $end = $record->end_time
                            ? \Carbon\Carbon::parse($record->end_time)->format('H:i')
                            : '—';

                        $location = $record->location ? " • {$record->location}" : '';

                        return "{$start} – {$end}{$location}";
                    })
                    ->wrap()
                    ->limit()
                    ->tooltip(fn (TrainingSession $record) => $record->activities_notes ?: null),

                // Program
                TextColumn::make('program.name')
                    ->label('Program Latihan')
                    ->wrap(),

                // Tanggal
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                // Durasi
                TextColumn::make('duration_label')
                    ->label('Durasi'),

                // Atlet
                TextColumn::make('athletes')
                    ->label('Jumlah Atlet')
                    ->state(function (TrainingSession $record) {
                        $count = $record->program?->athletes?->count() ?? 0;
                        return $count . ' atlet';
                    }),

                // Status
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'scheduled' => 'Terjadwal',
                        'on_going'  => 'Sedang Berlangsung',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default     => ucfirst($state),
                    })
                    ->colors([
                        'info'    => 'scheduled',
                        'warning' => 'on_going',
                        'success' => 'completed',
                        'danger'  => 'cancelled',
                    ]),
            ])
            ->filters([])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
