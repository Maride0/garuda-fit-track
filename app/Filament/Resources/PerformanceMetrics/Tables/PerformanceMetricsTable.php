<?php

namespace App\Filament\Resources\PerformanceMetrics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class PerformanceMetricsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Metric')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->code),

                BadgeColumn::make('sport_category')
                    ->label('Category')
                    ->colors([
                        'success' => 'olympic',
                        'info'    => 'non_olympic',
                        'warning' => 'para_sport',
                        'gray'    => 'other',
                    ])
                    ->sortable(),

                TextColumn::make('sport')
                    ->label('Sport')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('default_unit')
                    ->label('Unit')
                    ->sortable(),

                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->colors([
                        'success' => true,
                        'danger'  => false,
                    ])
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive'),

                TextColumn::make('metric_id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
                // nanti kita tambahin filter category, active/non-active
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
