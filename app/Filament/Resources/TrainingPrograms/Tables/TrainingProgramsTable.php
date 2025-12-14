<?php

namespace App\Filament\Resources\TrainingPrograms\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TrainingProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('program_id')
                    ->label('ID')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama Program')
                    ->searchable()
                    ->wrap(),

                BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'daily'           => 'primary',
                        'weekly'          => 'info',
                        'pre_competition' => 'warning',
                        'recovery'        => 'success',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'daily'           => 'Daily',
                        'weekly'          => 'Weekly',
                        'pre_competition' => 'Pre competition',
                        'recovery'        => 'Recovery',
                        default           => $state,
                    }),

                BadgeColumn::make('intensity')
                    ->label('Intensitas')
                    ->colors([
                        'low'    => 'gray',
                        'medium' => 'info',
                        'high'   => 'danger',
                    ])
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

                TextColumn::make('sport')
                    ->label('Cabang Olahraga')
                    ->toggleable(),

                TextColumn::make('team_name')
                    ->label('Tim')
                    ->toggleable(),

                TextColumn::make('coach_name')
                    ->label('Pelatih')
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('planned_sessions')
                    ->label('Rencana Sesi')
                    ->numeric()
                    ->alignRight()
                    ->toggleable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'draft'     => 'gray',
                        'active'    => 'success',
                        'completed' => 'info',
                        'cancelled' => 'danger',
                    ])
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
            ])
            ->defaultSort('program_id', 'desc')
            ->filters([
                // kamu bisa tambahin filter status / type nanti kalau mau
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Ubah'),
            ])
            ->recordActionsColumnLabel('Aksi') // ⬅️ ini yang bikin header kolom "Aksi"

            ->toolbarActions([
                BulkActionGroup::make([
                    
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
