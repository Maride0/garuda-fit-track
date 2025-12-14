<?php

namespace App\Filament\Resources\TestRecords\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestRecordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('athlete.name')
                    ->label('Atlet')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('metric.name')
                    ->label('Parameter Tes')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('trainingProgram.name')
                    ->label('Program Latihan')
                    ->placeholder('—')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('test_date')
                    ->label('Tanggal Tes')
                    ->date()
                    ->sortable(),

                BadgeColumn::make('phase')
                    ->label('Fase Pengujian')
                    ->colors([
                        'gray'      => 'baseline',
                        'info'      => 'pre',
                        'warning'   => 'mid',
                        'success'   => 'post',
                        'secondary' => 'other',
                    ])
                    ->sortable(),

                TextColumn::make('value')
                    ->label('Hasil Tes')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->unit
                            ? "{$state} {$record->unit}"
                            : "{$state} {$record->metric?->default_unit}";
                    })
                    ->sortable(),

                TextColumn::make('source')
                    ->label('Sumber Data')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                // nanti bisa ditambah: Atlet, Parameter, Fase
            ])

            ->recordActions([
                EditAction::make()
                    ->label('Ubah'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus'),
                ]),
            ]);
    }
}
