<?php

namespace App\Filament\Resources\PerformanceMetrics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PerformanceMetricsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Parameter')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->code),

                BadgeColumn::make('sport_category')
                    ->label('Kategori')
                    ->colors([
                        'success' => 'olympic',
                        'info'    => 'non_olympic',
                        'warning' => 'para_sport',
                        'gray'    => 'other',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'general'     => 'Umum / Multicabang',
                        'olympic'     => 'Olimpiade',
                        'non_olympic' => 'Non-Olimpiade',
                        'para_sport'  => 'Para Sport',
                        'other'       => 'Lainnya',
                        default       => '-',
                    })
                    ->sortable(),

                TextColumn::make('sport')
                    ->label('Cabang Olahraga')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('default_unit')
                    ->label('Satuan')
                    ->sortable(),

                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->colors([
                        'success' => true,
                        'danger'  => false,
                    ])
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Nonaktif'),

                TextColumn::make('metric_id')
                    ->label('ID Parameter')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label('Ubah'),
            ])
            ->recordActionsColumnLabel('Aksi') // ⬅️ ini yang bikin header kolom "Aksi"

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ]);
    }
}
