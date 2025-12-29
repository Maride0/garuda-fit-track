<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SessionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sessions';
    protected static ?string $title = 'Jadwal Latihan';

    private static function parseTime(?string $time): ?Carbon
    {
        if (! $time) return null;

        // TimePicker bisa ngasih "H:i" atau "H:i:s"
        foreach (['H:i:s', 'H:i'] as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, $time);
            } catch (\Throwable $e) {
                // lanjut
            }
        }

        return null;
    }

    private static function recalcDuration(callable $set, callable $get): void
    {
        $start = self::parseTime($get('start_time'));
        $end   = self::parseTime($get('end_time'));

        if (! $start || ! $end) {
            return;
        }

        $minutes = $start->diffInMinutes($end, false);

        // kalau end_time lebih kecil (latihan lewat tengah malam), anggap +1 hari
        if ($minutes < 0) {
            $minutes = $start->diffInMinutes($end->copy()->addDay());
        }

        $set('duration_minutes', $minutes);
    }

    private static function recalcStatus(callable $set, callable $get): void
    {
        // jangan override kalau dibatalkan manual
        if ($get('status') === 'cancelled') {
            return;
        }

        $date = $get('date');
        $startTime = self::parseTime($get('start_time'));
        $endTime   = self::parseTime($get('end_time'));

        if (! $date || ! $startTime) {
            return;
        }

        $start = Carbon::parse($date)->setTimeFrom($startTime);
        $now = now();

        // kalau belum ada end_time, status cukup scheduled vs on_going
        if (! $endTime) {
            $set('status', $now->greaterThanOrEqualTo($start) ? 'on_going' : 'scheduled');
            return;
        }

        $end = Carbon::parse($date)->setTimeFrom($endTime);

        // kalau end < start, berarti lewat tengah malam
        if ($end->lessThan($start)) {
            $end->addDay();
        }

        if ($now->lessThan($start)) {
            $set('status', 'scheduled');
        } elseif ($now->betweenIncluded($start, $end)) {
            $set('status', 'on_going');
        } else {
            $set('status', 'completed');
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            DatePicker::make('date')
                ->label('Tanggal Latihan')
                ->required()
                ->reactive()
                ->afterStateUpdated(function (callable $set, callable $get) {
                    self::recalcStatus($set, $get);
                }),

            TimePicker::make('start_time')
                ->label('Waktu Mulai')
                ->seconds(false)
                ->reactive()
                ->afterStateUpdated(function (callable $set, callable $get) {
                    self::recalcDuration($set, $get);
                    self::recalcStatus($set, $get);
                }),

            TimePicker::make('end_time')
                ->label('Waktu Selesai')
                ->seconds(false)
                ->reactive()
                ->afterStateUpdated(function (callable $set, callable $get) {
                    self::recalcDuration($set, $get);
                    self::recalcStatus($set, $get);
                }),

            TextInput::make('duration_minutes')
                ->label('Durasi Latihan (menit)')
                ->numeric()
                ->minValue(10)
                ->maxValue(300)
                ->helperText('Terisi otomatis dari waktu mulai–selesai (boleh kamu edit kalau perlu).'),

            TextInput::make('location')
                ->label('Lokasi Latihan')
                ->maxLength(255),

            Textarea::make('activities_notes')
                ->label('Rencana Latihan / Aktivitas')
                ->rows(4)
                ->columnSpanFull(),

            Select::make('status')
                ->label('Status Sesi')
                ->options([
                    'scheduled' => 'Terjadwal',
                    'on_going'  => 'Sedang Berlangsung',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ])
                ->default('scheduled')
                ->required()
                ->reactive()
                ->afterStateUpdated(function (?string $state, callable $set, callable $get) {
                    // kalau user batalin, biarin
                    if ($state === 'cancelled') {
                        return;
                    }

                    // kalau user pindah dari cancelled, bersihin alasan pembatalan
                    $set('cancel_reason', null);

                    // dan balikkan ke auto-status biar konsisten
                    self::recalcStatus($set, $get);
                }),

            TextInput::make('cancel_reason')
                ->label('Alasan Pembatalan')
                ->maxLength(255)
                ->visible(fn (callable $get) => $get('status') === 'cancelled'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Mulai')
                    ->time('H:i')
                    ->sortable(),

                TextColumn::make('end_time')
                    ->label('Selesai')
                    ->time('H:i')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('duration_minutes')
                    ->label('Durasi')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} menit" : '—'),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'scheduled' => 'Terjadwal',
                        'on_going'  => 'Berlangsung',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default     => $state,
                    })
                    ->colors([
                        'info'    => 'scheduled',
                        'warning' => 'on_going',
                        'success' => 'completed',
                        'danger'  => 'cancelled',
                    ]),
            ])
            ->defaultSort('date', 'asc')
            ->headerActions([
                CreateAction::make()->label('Tambah Sesi Latihan')
                ->modalHeading('Tambah Sesi Latihan')
                ->modalSubmitActionLabel('Simpan')
                ->modalCancelActionLabel('Batal'),
            ])
            ->recordActions([
                EditAction::make()->label('Ubah')
                ->modalSubmitActionLabel('Simpan Perubahan')
                ->modalCancelActionLabel('Batal'),
                DeleteAction::make()->label('Hapus'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus Terpilih'),
                ]),
            ]);
    }
}
