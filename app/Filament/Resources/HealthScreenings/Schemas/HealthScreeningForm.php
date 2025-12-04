<?php

namespace App\Filament\Resources\HealthScreenings\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Section;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;      
use Filament\Forms\Components\Placeholder; 
use Filament\Forms\Components\FileUpload;

use App\Models\TherapySchedule;    
        

class HealthScreeningForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Wizard::make([
                    /*
                    |--------------------------------------------------------------------------
                    | STEP 1 — Informasi Screening + Vital Signs
                    |--------------------------------------------------------------------------
                    */
                    Step::make('Informasi Screening & Vital Signs')
                        ->schema([
                            Hidden::make('lock_athlete')
                                ->default(fn () => request()->has('athlete_id'))
                                ->dehydrated(false),
                            Section::make('Informasi Screening')
                                ->columns(3)
                                ->schema([
                                    Select::make('athlete_id')
                                        ->label('Atlet')
                                        ->relationship('athlete', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->default(fn () => request()->get('athlete_id'))
                                        ->live()
                                        ->disabled(fn ($get, $record) =>
                                            // ⬇️ kalau datang dari link athlete → selalu terkunci sepanjang life form
                                            $get('lock_athlete')
                                            // screening sudah di-lock
                                            || ($record?->is_locked ?? false)
                                            // atau kalau exam_type follow-up
                                            || $get('exam_type') === 'follow_up'
                                        )
                                        ->dehydrated()
                                        ->dehydrateStateUsing(fn ($state) => $state),

                                    DatePicker::make('screening_date')
                                        ->label('Tanggal Screening')
                                        ->default(now())
                                        ->required()
                                        ->placeholder('Pilih tanggal screening')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    Select::make('exam_type')
                                        ->label('Jenis Pemeriksaan')
                                        ->options(function ($get) {
                                            // opsi dasar, tanpa follow-up dulu
                                            $options = [
                                                'routine'     => 'Routine Check',
                                                'injury'      => 'Injury Check',
                                                'competition' => 'Competition',
                                            ];

                                            $athleteId = $get('athlete_id');
                                            $current   = $get('exam_type');

                                            // kalau belum ada atlet, ga usah tawarin follow-up
                                            if (! $athleteId) {
                                                // tapi kalau lagi edit dan state-nya sudah follow_up, tetap tampilkan
                                                if ($current === 'follow_up') {
                                                    $options['follow_up'] = 'Follow-up';
                                                }

                                                return $options;
                                            }

                                            // cek apakah atlet ini punya jadwal terapi planned/active
                                            $hasActiveSchedule = TherapySchedule::query()
                                                ->where('athlete_id', $athleteId)
                                                ->whereIn('status', ['planned', 'active'])
                                                ->exists();

                                            // follow_up muncul kalau:
                                            // - ada jadwal terapi aktif/planned, ATAU
                                            // - state sekarang sudah follow_up (edit mode)
                                            if ($hasActiveSchedule || $current === 'follow_up') {
                                                // kalau kamu mau urutan sama seperti sebelumnya, bisa disisip:
                                                $options = [
                                                    'routine'     => 'Routine Check',
                                                    'injury'      => 'Injury Check',
                                                    'follow_up'   => 'Follow-up',
                                                    'competition' => 'Competition',
                                                ];
                                            }

                                            return $options;
                                        })
                                        ->required()
                                        ->placeholder('Pilih jenis pemeriksaan')
                                        ->live()
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),
                                ]),

                            Section::make('Vital Signs')
                                ->columns(3)
                                ->schema([
                                    TextInput::make('blood_pressure')
                                        ->label('Blood Pressure')
                                        ->placeholder('Contoh: 120/80')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    TextInput::make('heart_rate')
                                        ->label('Heart Rate (bpm)')
                                        ->numeric()
                                        ->placeholder('Contoh: 72')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    TextInput::make('temperature')
                                        ->label('Temperature (°C)')
                                        ->numeric()
                                        ->placeholder('Contoh: 36.5')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    TextInput::make('respiration_rate')
                                        ->label('Respiration Rate')
                                        ->numeric()
                                        ->placeholder('Contoh: 16')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    TextInput::make('oxygen_saturation')
                                        ->label('Oxygen Saturation (%)')
                                        ->numeric()
                                        ->placeholder('Contoh: 98')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),
                                ]),
                        ]),

                    /*
                    |--------------------------------------------------------------------------
                    | STEP 2 — Keluhan & Cedera + Konteks Latihan
                    |--------------------------------------------------------------------------
                    */
                    Step::make('Keluhan & Konteks Latihan')
                        ->schema([
                            Section::make('Keluhan & Cedera')
                                ->columns(2)
                                ->schema([
                                    Textarea::make('chief_complaint')
                                        ->label('Keluhan Utama')
                                        ->columnSpanFull()
                                        ->placeholder('Tuliskan keluhan utama atlet saat ini')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    Textarea::make('injury_history')
                                        ->label('Riwayat Cedera')
                                        ->columnSpanFull()
                                        ->placeholder('Riwayat cedera sebelumnya, lokasi, waktu, dll.')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    TextInput::make('pain_location')
                                        ->label('Lokasi Nyeri')
                                        ->placeholder('Contoh: lutut kanan, pergelangan kaki kiri')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    TextInput::make('pain_scale')
                                        ->label('Skala Nyeri (0–10)')
                                        ->numeric()
                                        ->placeholder('Contoh: 4')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),
                                ]),

                            Section::make('Konteks Latihan')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('training_load')
                                        ->label('Beban Latihan')
                                        ->placeholder('Contoh: sedang, 2 sesi intensitas tinggi')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),

                                    TextInput::make('training_frequency')
                                        ->label('Frekuensi Latihan')
                                        ->placeholder('Contoh: 5x per minggu')
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),
                                ]),
                        ]),

                    /*
                    |--------------------------------------------------------------------------
                    | STEP 3 — Hasil Pemeriksaan + Notes + Conditional Therapy Schedule
                    |--------------------------------------------------------------------------
                    */
                    Step::make('Hasil Pemeriksaan & Tindak Lanjut')
                        ->schema([
                            Section::make('Hasil Pemeriksaan')
                                ->columns(1)
                                ->schema([
                                    Select::make('screening_result')
                                        ->label('Hasil Screening')
                                        ->options(function ($record) {
                                            $options = [
                                                'fit'             => 'Fit',
                                                'restricted'      => 'Restricted',
                                                'requires_therapy'=> 'Requires Therapy',
                                            ];

                                            // 🟡 Kalau record punya value active_therapy → tambahkan hanya untuk ditampilkan
                                            if ($record && $record->screening_result === 'active_therapy') {
                                                $options['active_therapy'] = 'Active Therapy';
                                            }

                                            return $options;
                                        })
                                        ->required()
                                        ->placeholder('Pilih hasil screening')
                                        ->live()
                                        ->disabled(fn ($record) => $record?->is_locked ?? false)
                                ]),
                                Section::make('Jadwal Terapi')
                                    ->visible(fn ($get) =>
                                        $get('exam_type') !== 'follow_up'
                                        && in_array($get('screening_result'), ['requires_therapy', 'active_therapy'], true)
                                    )
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('therapy_type_form')
                                            ->label('Jenis Terapi')
                                            ->placeholder('Contoh: fisioterapi, terapi manual')
                                            // WAJIB di CREATE saat masih requires_therapy
                                            ->required(fn ($get, $record) =>
                                                $record === null
                                                && $get('exam_type') !== 'follow_up'
                                                && $get('screening_result') === 'requires_therapy'
                                            )
                                            ->afterStateHydrated(function (TextInput $component, $state) {
                                                // PREFILL di EDIT dari therapySchedule
                                                if ($state !== null) {
                                                    return;
                                                }

                                                $record = $component->getRecord();
                                                if (! $record || ! $record->therapySchedule) {
                                                    return;
                                                }

                                                $component->state($record->therapySchedule->therapy_type);
                                            })
                                            ->disabled(fn ($record) => $record?->is_locked ?? false),

                                        TextInput::make('therapist_name_form')
                                            ->label('Nama Terapis')
                                            ->placeholder('Nama terapis yang menangani')
                                            ->afterStateHydrated(function (TextInput $component, $state) {
                                                if ($state !== null) {
                                                    return;
                                                }

                                                $record = $component->getRecord();
                                                if (! $record || ! $record->therapySchedule) {
                                                    return;
                                                }

                                                $component->state($record->therapySchedule->therapist_name);
                                            })
                                            ->disabled(fn ($record) => $record?->is_locked ?? false),

                                        DatePicker::make('therapy_start_date_form')
                                            ->label('Mulai Terapi')
                                            ->placeholder('Pilih tanggal mulai terapi')
                                            ->required(fn ($get, $record) =>
                                                $record === null
                                                && $get('exam_type') !== 'follow_up'
                                                && $get('screening_result') === 'requires_therapy'
                                            )
                                            ->afterStateHydrated(function (DatePicker $component, $state) {
                                                if ($state !== null) {
                                                    return;
                                                }

                                                $record = $component->getRecord();
                                                if (! $record || ! $record->therapySchedule) {
                                                    return;
                                                }

                                                $component->state($record->therapySchedule->start_date);
                                            })
                                            ->disabled(fn ($record) => $record?->is_locked ?? false),

                                        DatePicker::make('therapy_end_date_form')
                                            ->label('Selesai Terapi')
                                            ->placeholder('Pilih tanggal selesai (opsional)')
                                            ->afterStateHydrated(function (DatePicker $component, $state) {
                                                if ($state !== null) {
                                                    return;
                                                }

                                                $record = $component->getRecord();
                                                if (! $record || ! $record->therapySchedule) {
                                                    return;
                                                }

                                                $component->state($record->therapySchedule->end_date);
                                            })
                                            ->disabled(fn ($record) => $record?->is_locked ?? false),

                                        TextInput::make('therapy_frequency_form')
                                            ->label('Re-screening dalam (minggu)')
                                            ->numeric()
                                            ->minValue(1)
                                            ->columnSpanFull()
                                            ->placeholder('Contoh: 4')
                                            ->afterStateHydrated(function (TextInput $component, $state) {
                                                if ($state !== null) {
                                                    return;
                                                }

                                                $record = $component->getRecord();
                                                if (! $record || ! $record->therapySchedule) {
                                                    return;
                                                }

                                                $component->state($record->therapySchedule->frequency);
                                            })
                                            ->disabled(fn ($record) => $record?->is_locked ?? false),
                                    ]),

                            Section::make('Follow Up Terapi Sebelumnya')
                            ->visible(fn ($get) => $get('exam_type') === 'follow_up')
                            ->columns(1)
                            ->schema([
                                Hidden::make('follow_up_therapy_schedule_id')
                                    ->default(function ($get, $record) {
                                        // Kalau edit dan sudah ada, jangan di-overwrite
                                        if ($record && $record->follow_up_therapy_schedule_id) {
                                            return $record->follow_up_therapy_schedule_id;
                                        }

                                        $athleteId = $get('athlete_id');
                                        if (! $athleteId) {
                                            return null;
                                        }

                                        $schedule = TherapySchedule::query()
                                            ->where('athlete_id', $athleteId)
                                            ->whereIn('status', ['planned', 'active'])
                                            ->latest('start_date')
                                            ->first();

                                        return $schedule?->id;
                                    }),

                                Placeholder::make('follow_up_therapy_summary')
                                    ->label('Terapi yang Di-follow Up')
                                    ->content(function ($get) {
                                        $scheduleId = $get('follow_up_therapy_schedule_id');

                                        if (! $scheduleId) {
                                            return 'Tidak ditemukan jadwal terapi aktif untuk atlet ini. '
                                                . 'Pastikan jadwal terapi sudah dibuat dan berstatus planned/active.';
                                        }

                                        $schedule = TherapySchedule::find($scheduleId);
                                        if (! $schedule) {
                                            return 'Data jadwal terapi tidak ditemukan.';
                                        }

                                        $start = $schedule->start_date?->format('d M Y') ?? '-';
                                        $end   = $schedule->end_date?->format('d M Y') ?? 'Belum ditentukan';

                                        return
                                            "Terapi : {$schedule->therapy_type}\n" .
                                            "Terapis: " . ($schedule->therapist_name ?: '-') . "\n" .
                                            "Periode: {$start} s/d {$end}\n" .
                                            "Frekuensi (minggu): " . ($schedule->frequency ?? '-') . "\n" .
                                            "Status : {$schedule->status}\n" .
                                            "Progress: {$schedule->progress}%";
                                    })
                            ]),
                            Section::make('Catatan Tambahan')
                                ->schema([
                                    Textarea::make('notes')
                                        ->label('Catatan')
                                        ->columnSpanFull()
                                        ->placeholder('Catatan tambahan, rekomendasi, atau observasi lain')
                                ]),
                            Section::make('Lampiran RME')
                                ->schema([
                                    FileUpload::make('report_file_path')
                                        ->label('Lampiran RME / Laporan (Opsional)')
                                        ->directory('health-reports')
                                        ->disk('public')               // <-- WAJIB
                                        // ->preserveFilenames()
                                        ->downloadable()
                                        ->openable()
                                        ->acceptedFileTypes(['application/pdf']) // ⬅️ HANYA PDF
                                        ->helperText('Upload PDF / gambar hasil pemeriksaan atau RME terkait screening ini.')
                                        ->columnSpanFull()
                                        ->disabled(fn ($record) => $record?->is_locked ?? false),
                                ]),
                        ]),
                ])
                    ->skippable()
                    ->columnSpanFull(),

            ]);
    }
}
