<?php

namespace App\Filament\Resources\Achievements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AchievementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Nama Atlet (relasi)
                TextColumn::make('athlete.name')
                    ->label('Atlet')
                    ->searchable()
                    ->sortable(),

                // Nama Prestasi
                TextColumn::make('achievement_name')
                    ->label('Prestasi')
                    ->searchable()
                    ->sortable(),

                // Event
                TextColumn::make('event_name')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),

                // Tingkat Kompetisi (badge + label rapi)
                TextColumn::make('competition_level')
                    ->label('Tingkat')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'international'      => 'Internasional',
                        'continental'        => 'Kontinental',
                        'national'           => 'Nasional',
                        'provincial'         => 'Provinsi',
                        'city_regional_club' => 'Kota / Regional / Klub',
                        default              => '-',
                    })
                    ->sortable(),

                // Medal (badge warna kaya RM)
                TextColumn::make('medal_rank')
                    ->label('Medal')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'gold'       => 'warning',
                        'silver'     => 'gray',
                        'bronze'     => 'danger',
                        'non_podium' => 'secondary',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'gold'       => 'Gold',
                        'silver'     => 'Silver',
                        'bronze'     => 'Bronze',
                        'non_podium' => 'Non-Podium',
                    })
                    ->sortable(),

                // Peringkat
                TextColumn::make('rank')
                    ->label('Peringkat')
                    ->sortable(),

                // Tanggal Event (start_date)
                TextColumn::make('start_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])

            ->defaultSort('start_date', 'desc') // terbaru dulu

            ->filters([
                SelectFilter::make('competition_level')
                    ->label('Tingkat Kompetisi')
                    ->options([
                        'international'      => 'Internasional',
                        'continental'        => 'Kontinental',
                        'national'           => 'Nasional',
                        'provincial'         => 'Provinsi',
                        'city_regional_club' => 'Kota / Regional / Klub',
                    ]),

                SelectFilter::make('medal_rank')
                    ->label('Medal')
                    ->options([
                        'gold'       => 'Gold',
                        'silver'     => 'Silver',
                        'bronze'     => 'Bronze',
                        'non_podium' => 'Non-Podium',
                    ]),
            ])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
