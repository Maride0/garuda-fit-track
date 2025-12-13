<?php

namespace App\Filament\Resources\Athletes\Tables;

use App\Filament\Resources\HealthScreenings\HealthScreeningResource;
use App\Filament\Resources\Athletes\AthleteResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use Carbon\Carbon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ViewColumn;

class AthletesTable
{
    public static function configure(Table $table): Table
    {
        $isAdmin = auth()->user()?->role === 'admin';
        return $table
            ->defaultSort('created_at', 'asc')
            ->columns([
               ViewColumn::make('avatar')
                    ->label('')
                    ->view('filament.tables.columns.athlete-avatar')
                    ->toggleable(false),

                TextColumn::make('athlete_id')
                    ->label('ID Atlet')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->label('Nama Atlet')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'male'   => 'Laki-laki',    
                        'female' => 'Perempuan',
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('age')
                    ->label('Umur')
                    ->sortable(),

                TextColumn::make('birthdate')
                    ->label('Birthdate')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('height')
                    ->label('Height (cm)')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} cm" : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('weight')
                    ->label('Weight (kg)')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} kg" : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sport')
                    ->label('Cabang Olahraga')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sport_category')
                    ->label('Kategori Olahraga')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'olympic'     => 'Olympic Sport',
                        'non_olympic' => 'Non-Olympic Sport',
                        default       => '-',
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'olympic'     => 'success',
                        'non_olympic' => 'gray',
                        default       => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('medals_summary')
                    ->label('Medals')
                    ->sortable(false)
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status Medis')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'not_screened'     => 'Belum Discreening',
                        'fit'              => 'Fit',
                        'under_monitoring' => 'Dalam Pemantauan',
                        'active_therapy'   => 'Sedang Terapi',
                        'restricted'       => 'Terbatas',
                        default            => ucfirst((string) $state),
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'not_screened'     => 'gray',
                        'fit'              => 'success',
                        'under_monitoring' => 'warning',
                        'active_therapy'   => 'info',
                        'restricted'       => 'danger',
                        default            => 'gray',
                    })
                    ->sortable(),
                
                TextColumn::make('next_screening_due')
                    ->label('Next Screening')
                    // state yang dipakai kolom ini SELALU string
                    ->getStateUsing(function ($record) {
                        // belum ada jadwal next screening
                        if (! $record->next_screening_due) {
                            return '-';
                        }

                        // ada tanggal → format cantik
                        return Carbon::parse($record->next_screening_due)->format('d M Y');
                    })
                    ->color(function ($state, $record) {
                        // belum ada jadwal screening berikutnya
                        if (! $record->next_screening_due) {
                            return 'grey';
                        }

                        if ($record->isScreeningOverdue()) {
                            return 'danger';
                        }

                        if ($record->isScreeningDue()) {
                            return 'warning';
                        }

                        return 'neutral'; // masih jauh dari due
                    })
                    ->tooltip(function ($state, $record) {
                        if (! $record->next_screening_due) {
                            return 'Belum ada jadwal screening berikutnya (belum pernah screening).';
                        }

                        if ($record->isScreeningOverdue()) {
                            return 'Screening sudah lewat dari batas waktu yang disarankan.';
                        }

                        if ($record->isScreeningDue()) {
                            return 'Sudah saatnya re-screening.';
                        }

                        return 'Screening berikutnya masih dalam rentang aman.';
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('contact')
                    ->label('Contact')
                    ->formatStateUsing(fn ($state) => $state ?: '-')
                    ->url(fn ($state) => $state
                        ? "https://wa.me/" . preg_replace('/\D/', '', $state)
                        : null
                    )
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-phone')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actionsColumnLabel($isAdmin ? 'Aksi' : null)
            ->recordActions($isAdmin ? [
                Action::make('screen')
                    ->label(fn ($record) => $record->status === 'not_screened'
                        ? 'Screening Awal'
                        : 'Screening Ulang')
                    ->icon('heroicon-o-heart')
                    ->color('success')
                    ->url(fn ($record) => HealthScreeningResource::getUrl('create', [
                        'athlete_id' => $record->athlete_id,
                    ])),
            ] : [])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
