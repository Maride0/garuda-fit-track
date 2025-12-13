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
    protected static ?string $heading = 'Upcoming Schedule';

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
                    ->with('program.athletes') // <— ini penting
                    ->orderBy('date')
                    ->orderBy('start_time')
            )
            ->paginated(false)
            ->defaultPaginationPageOption(6)
            ->columns([
                // Schedule / Activity
                TextColumn::make('activities_notes')
                    ->label('Schedule')
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
                    ->limit(42)
                    ->tooltip(fn (TrainingSession $record) => $record->activities_notes ?: null),

                // Program
                TextColumn::make('program.name')
                    ->label('Program')
                    ->wrap(),

                // Date
                TextColumn::make('date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),

                // Duration (pakai accessor kamu)
                TextColumn::make('duration_label')
                    ->label('Duration'),

                TextColumn::make('athletes')
                    ->label('Athletes')
                    ->state(function (TrainingSession $record) {
                        $count = $record->program?->athletes?->count() ?? 0;
                        return $count . ' atlet';
                    }),


                // Status
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'scheduled' => 'Scheduled',
                        'on_going'  => 'On Going',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        default     => ucfirst($state),
                    })
                    ->colors([
                        'info'    => 'scheduled',
                        'warning' => 'on_going',
                        'success' => 'completed',
                        'danger'  => 'cancelled',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
