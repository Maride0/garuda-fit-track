<?php

namespace App\Filament\Resources\Athletes\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\HealthScreenings\HealthScreeningResource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Actions\Action;


class HealthScreeningsRelationManager extends RelationManager
{
    protected static string $relationship = 'healthScreenings';

    protected static ?string $title = 'Riwayat Skrining Kesehatan';

    public function form(Schema $schema): Schema
    {
        // RM ini read-only, jadi nggak pake form
        return $schema->components([]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('screening_id')
                ->label('No. Skrining'),

            TextEntry::make('screening_date')
                ->label('Tanggal')
                ->date(),

            TextEntry::make('exam_type')
                ->label('Jenis Pemeriksaan')
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    'routine'    => 'Routine Check',
                    'injury'     => 'Injury Check',
                    'follow_up'  => 'Follow-up',
                    'competition'=> 'Competition',
                    default      => $state,
                }),

            TextEntry::make('display_result')
                ->label('Hasil')
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    'fit'              => 'Fit',
                    'requires_therapy' => 'Requires Therapy',
                    'active_therapy'   => 'Active Therapy',
                    'restricted'       => 'Restricted',
                    default            => $state,
                }),

            TextEntry::make('notes')
                ->label('Catatan')
                ->placeholder('-')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('screening_id')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('screening_id')
                    ->label('No. Screening')
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
                        'routine'    => 'Routine Check',
                        'injury'     => 'Injury Check',
                        'follow_up'  => 'Follow-up',
                        'competition'=> 'Competition',
                        default      => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'routine'    => 'success',
                        'injury'     => 'danger',
                        'follow_up'  => 'warning',
                        'competition'=> 'info',
                        default      => 'gray',
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
                        'active_therapy'   => 'info',
                        'restricted'       => 'danger',
                        default            => 'gray',
                    }),

                TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(20)
                    ->tooltip(fn ($state) => $state)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('exam_type')
                    ->label('Jenis Pemeriksaan')
                    ->options([
                        'routine'    => 'Routine',
                        'injury'     => 'Injury Check',
                        'follow_up'  => 'Follow-up',
                        'competition'=> 'Competition',
                    ]),

                Tables\Filters\SelectFilter::make('screening_result')
                    ->label('Hasil')
                    ->options([
                        'fit'              => 'Fit',
                        'requires_therapy' => 'Requires Therapy',
                        'restricted'       => 'Restricted',
                        'active_therapy'   => 'Active Therapy',
                    ]),
            ])
            ->headerActions([
                Action::make('screen')
                    ->label(function () {
                        $athlete = $this->getOwnerRecord();

                        return $athlete?->status === 'not_screened'
                            ? 'Screening Awal'
                            : 'Screening Ulang';
                    })
                    ->icon('heroicon-o-heart')
                    ->color('success')
                    ->url(function () {
                        $athlete = $this->getOwnerRecord();

                        return HealthScreeningResource::getUrl('create', [
                            'athlete_id' => $athlete?->athlete_id,
                        ]);
                    })
                    ->visible(fn () => auth()->user()?->role === 'admin'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
                }
}
