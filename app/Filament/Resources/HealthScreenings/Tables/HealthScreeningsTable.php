<?php

namespace App\Filament\Resources\HealthScreenings\Tables;

use App\Filament\Resources\TherapySchedules\TherapyScheduleResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class HealthScreeningsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('screening_id')
                    ->label('Nomor Skrining')
                    ->searchable()
                    ->sortable(),
                // Nama Atlet (pakai relasi athlete)
                TextColumn::make('athlete.name')
                    ->label('Athlete')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('screening_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                TextColumn::make('exam_type')
                    ->label('Jenis Pemeriksaan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'routine' => 'Routine Check',
                        'injury' => 'Injury Check',
                        'follow_up' => 'Follow-up',
                        'competition' => 'Competition',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'routine' => 'success',
                        'injury' => 'danger',
                        'follow_up' => 'warning',
                        'competition' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('display_result')
                    ->label('Hasil')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'fit'              => 'Fit',
                        'requires_therapy' => 'Requires Therapy',
                        'active_therapy'   => 'Active Therapy',
                        'restricted'       => 'Restricted',
                        default            => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'fit'              => 'success',
                        'requires_therapy' => 'warning',
                        'active_therapy'   => 'info',   // bebas: info/biru biar beda
                        'restricted'       => 'danger',
                        default            => 'gray',
                    }),

                TextColumn::make('blood_pressure')
                    ->label('BP')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('heart_rate')
                    ->label('HR')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('temperature')
                    ->label('Temp')
                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('pain_location')
                    ->label('Pain Area')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pain_scale')
                    ->label('Pain (0–10)')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('notes')
                    ->limit(20)
                    ->tooltip(fn ($state) => $state)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('exam_type')
                    ->label('Jenis Pemeriksaan')
                    ->options([
                        'routine' => 'Routine',
                        'injury' => 'Injury Check',
                        'follow_up' => 'Follow-up',
                        'competition' => 'Competition',
                    ]),

                SelectFilter::make('screening_result')
                    ->label('Hasil')
                    ->options([
                        'fit' => 'Fit',
                        'requires_therapy' => 'Requires Therapy',
                        'restricted' => 'Restricted',
                    ]),
            ])

            ->recordActions([

                // SET THERAPY SCHEDULE (JIKA PERLU TERAPI)
                // Action::make('therapySchedule')
                //     ->label('Edit Therapy Schedule')
                //     ->icon('heroicon-o-calendar-days')
                //     // cuma muncul kalau SUDAH punya schedule
                //     ->visible(fn ($record) => $record->therapySchedule !== null)
                //     ->url(fn ($record) =>
                //         TherapyScheduleResource::getUrl('edit', [
                //             'record' => $record->therapySchedule,
                //         ])
                //     ),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
