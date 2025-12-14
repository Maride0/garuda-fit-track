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
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;



class AthletesTable
{
    public static function configure(Table $table): Table
    {
        $isAdmin = auth()->user()?->role === 'admin';
        return $table
            ->defaultSort('created_at', 'asc')
            ->modifyQueryUsing(function (Builder $query) {
            $query->withCount([
                'achievements as gold_count' => fn ($q) => $q->where('medal_rank', 'gold'),
                'achievements as silver_count' => fn ($q) => $q->where('medal_rank', 'silver'),
                'achievements as bronze_count' => fn ($q) => $q->where('medal_rank', 'bronze'),
            ]);
        })
            ->columns([

                TextColumn::make('athlete_id')
                    ->label('ID Atlet')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                
                TextColumn::make('name')
                    ->label('Atlet')
                    // ->alignCenter()
                    ->html()
                    ->formatStateUsing(fn ($state, $record) =>
                        view('filament.tables.columns.athlete-name', compact('record'))->render()
                    ),

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
                    ->sortable(
                        query: fn (Builder $query, string $direction): Builder =>
                            $query
                                ->orderByRaw("birthdate IS NULL") // null di bawah
                                ->orderByRaw("TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) {$direction}")
                    ),

                TextColumn::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('height')
                    ->label('Tinggi (cm)')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} cm" : '-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('weight')
                    ->label('Berat (kg)')
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

                TextColumn::make('medals_compact')
                    ->label('Medali')
                    ->alignCenter()
                    ->state(function ($record) {
                        $parts = [];

                        if (($record->gold_count ?? 0) > 0)   $parts[] = "🥇 {$record->gold_count}";
                        if (($record->silver_count ?? 0) > 0) $parts[] = "🥈 {$record->silver_count}";
                        if (($record->bronze_count ?? 0) > 0) $parts[] = "🥉 {$record->bronze_count}";

                        return $parts ? implode('  ', $parts) : '—';
                    })
                    ->badge(false)
                    ->tooltip(fn ($record) => $record->medals_summary !== '-' ? $record->medals_summary : null),


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
                    ->label('Skrining Berikutnya')
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
                            return 'Belum ada jadwal Skrining berikutnya (belum pernah screening).';
                        }

                        if ($record->isScreeningOverdue()) {
                            return 'Skrining sudah lewat dari batas waktu yang disarankan.';
                        }

                        if ($record->isScreeningDue()) {
                            return 'Sudah saatnya re-screening.';
                        }

                        return 'Screening berikutnya masih dalam rentang aman.';
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('contact')
                    ->label('Kontak')
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
            ->filters([
                // 1) Status Medis
                SelectFilter::make('medical_status')
                    ->label('Status Medis')
                    ->options([
                        'fit' => 'Fit',
                        'dalam_pemantauan' => 'Dalam Pemantauan',
                        'sedang_terapi' => 'Sedang Terapi',
                        'terbatas' => 'Terbatas',
                        'not_screened' => 'Belum Screening',
                    ])
                    ->native(false),

                // 2) Kategori Olahraga
                SelectFilter::make('sport_category')
                    ->label('Kategori Olahraga')
                    ->options([
                        'olympic' => 'Olympic Sport',
                        'non_olympic' => 'Non-Olympic Sport',
                    ])
                    ->native(false),

                // 3) Cabang Olahraga
                SelectFilter::make('sport')
                    ->label('Cabang Olahraga')
                    ->searchable()
                    ->options(fn () =>
                        \App\Models\Athlete::query()
                            ->select('sport')
                            ->whereNotNull('sport')
                            ->distinct()
                            ->orderBy('sport')
                            ->pluck('sport', 'sport')
                            ->toArray()
                    )
                    ->native(false),

                // 4) Umur (Min–Max)
                // 4) Umur (Min–Max) — dari birthdate (computed age)
            Filter::make('age_range')
                ->label('Umur')
                ->form([
                    TextInput::make('min')
                        ->label('Min Umur')
                        ->numeric()
                        ->minValue(0),

                    TextInput::make('max')
                        ->label('Max Umur')
                        ->numeric()
                        ->minValue(0),
                ])
                ->query(function (Builder $query, array $data) {
                    $min = $data['min'] ?? null;
                    $max = $data['max'] ?? null;

                    $query
                        ->whereNotNull('birthdate')
                        ->when(
                            $min !== null && $min !== '',
                            fn (Builder $q) =>
                                $q->whereRaw(
                                    'TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= ?',
                                    [(int) $min]
                                )
                        )
                        ->when(
                            $max !== null && $max !== '',
                            fn (Builder $q) =>
                                $q->whereRaw(
                                    'TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= ?',
                                    [(int) $max]
                                )
                        );
                })
                ->indicateUsing(function (array $data): array {
                    $out = [];
                    if (!empty($data['min'])) $out[] = 'Umur ≥ ' . $data['min'];
                    if (!empty($data['max'])) $out[] = 'Umur ≤ ' . $data['max'];
                    return $out;
                }),

            // 5) Minimal total medali
            Filter::make('min_medals')
                ->label('Total Medali')
                ->form([
                    TextInput::make('min_total')
                        ->label('Min Total Medali')
                        ->numeric()
                        ->minValue(0),
                ])
                ->query(function (Builder $query, array $data) {
                    $min = $data['min_total'] ?? null;
                    if ($min === null || $min === '') {
                        return;
                    }

                    $query->has('achievements', '>=', (int) $min);
                })
                ->indicateUsing(fn (array $data) => !empty($data['min_total'])
                    ? ['Total Medali ≥ ' . $data['min_total']]
                    : []),
                        ])
            // ✅ ini yang bikin jadi icon funnel / dropdown, bukan panel
            ->filtersLayout(FiltersLayout::Dropdown)

            // (optional) biar indikator filter aktif muncul rapih (biasanya default udah oke)
            // ->persistFiltersInSession()
            
            ->headerActions([
                Action::make('newAthlete')
                    ->label('Tambah Atlet')
                    ->icon('heroicon-o-plus')
                    ->url(fn () => AthleteResource::getUrl('create'))
                    ->extraAttributes(['class' => 'gft-btn-gold']),
            ])
            ->extraAttributes(['class' => 'gft-athletes-table'])
            ->actionsColumnLabel($isAdmin ? 'Aksi' : null)
            ->recordActions($isAdmin ? [
                Action::make('screen')
                    ->label(fn ($record) =>
                        $record->status === 'not_screened'
                            ? 'Screening Awal'
                            : 'Screening Ulang'
                    )
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
