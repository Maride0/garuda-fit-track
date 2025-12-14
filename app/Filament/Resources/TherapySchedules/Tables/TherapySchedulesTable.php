<?php

namespace App\Filament\Resources\TherapySchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TherapySchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
         // Tidak boleh buat therapy schedule manual → hide CREATE button
            ->headerActions([])
            
            // ⬇️ ini kuncinya
            ->defaultSort('updated_at', 'desc')

            ->columns([
                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Atlet (relasi)
                TextColumn::make('athlete.name')
                    ->label('Atlet')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('therapy_type')
                    ->label('Jenis Terapi')
                    ->searchable()
                    ->wrap()
                    ->extraAttributes(['class' => 'max-w-none']),

                TextColumn::make('therapist_name')
                    ->label('Nama Terapis')
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date()
                    ->sortable(),

                TextColumn::make('frequency')
                    ->label('Frekuensi'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'planned'   => 'Direncanakan',
                        'active'    => 'Aktif',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default     => $state,
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'planned'   => 'gray',
                        'active'    => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    }),

                TextColumn::make('progress')
                    ->label('Progress')
                    ->suffix('%')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'planned'   => 'Direncanakan',
                        'active'    => 'Aktif',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
