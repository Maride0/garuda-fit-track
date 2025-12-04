<?php

namespace App\Filament\Resources\AthletePerformances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AthletePerformancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('athlete.name')
                    ->label('Athlete')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('metric.name')
                    ->label('Metric')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('trainingProgram.name')
                    ->label('Program')
                    ->placeholder('—')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('test_date')
                    ->label('Test Date')
                    ->date()
                    ->sortable(),

                BadgeColumn::make('phase')
                    ->label('Phase')
                    ->colors([
                        'gray'   => 'baseline',
                        'info'   => 'pre',
                        'warning'=> 'mid',
                        'success'=> 'post',
                        'secondary' => 'other',
                    ])
                    ->sortable(),

                TextColumn::make('value')
                    ->label('Value')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->unit
                            ? "{$state} {$record->unit}"
                            : "{$state} {$record->metric?->default_unit}";
                    })
                    ->sortable(),

                TextColumn::make('source')
                    ->label('Source')
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                // nanti kita bisa tambah: filter metric, athlete, phase
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
