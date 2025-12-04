<?php

namespace App\Filament\Resources\TherapySchedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;



class TherapyScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Terapi')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('athlete_id')
                            ->label('Atlet')
                            ->relationship('athlete', 'name')
                            ->default(fn () => request()->get('athlete_id'))
                            ->required()
                            ->disabled(fn ($record) => $record !== null) // hanya lock saat edit
                            ->dehydrated(),

                        // kalau mau hidden:
                        // Hidden::make('health_screening_id')
                        //     ->default(fn () => request()->get('health_screening_id'))
                        //     ->dehydrated(),

                        TextInput::make('health_screening_id')
                            ->label('Health Screening ID')
                            ->default(fn () => request()->get('health_screening_id'))
                            ->disabled(fn ($record) => $record !== null)
                            ->dehydrated(),

                        TextInput::make('therapy_type')
                            ->label('Jenis Terapi')
                            ->placeholder('Contoh: Fisioterapi Lutut')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'completed'),

                        TextInput::make('therapist_name')
                            ->label('Nama Terapis')
                            ->placeholder('Contoh: dr. Andi Pratama / Fisio Rina')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'completed'),

                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->default(now())
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'completed'),

                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->default(null)
                            ->disabled(fn ($record) => $record?->status === 'completed'),

                        TextInput::make('frequency')
                            ->label('Re-screening dalam (minggu)')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('Contoh: 4')
                            ->helperText('Dipakai untuk menentukan kapan atlet perlu screening ulang selama terapi.')
                            ->nullable()
                            ->disabled(fn ($record) => $record?->status === 'completed'),
                    ]),

                Section::make('Status Terapi')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'planned'   => 'Direncanakan',
                                'active'    => 'Aktif',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->default('planned')
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'completed'),

                        TextInput::make('progress')
                            ->label('Progress (%)')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->disabled(fn ($record) => $record?->status === 'completed'),
                    ]),

                Section::make('Catatan Tambahan')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->placeholder('Opsional — isi jika ada catatan khusus dari terapis...')
                            ->columnSpanFull()
                            ->disabled(fn ($record) => $record?->status === 'completed'),
                    ]),
                                // 🔽 SECTION BARU: RINGKASAN SCREENING
                Section::make('Ringkasan Screening')
                    ->description('Laporan singkat pemeriksaan yang terkait dengan jadwal terapi ini.')
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record && $record->healthScreening) // cuma muncul kalau ada relasi
                    ->schema([
                        Placeholder::make('screening_date')
                            ->label('Tanggal Screening')
                            ->content(function ($record) {
                                $date = $record?->healthScreening?->screening_date;

                                return $date
                                    ? $date->translatedFormat('d M Y')
                                    : '-';
                            }),

                        Placeholder::make('exam_type')
                            ->label('Jenis Pemeriksaan')
                            ->content(fn ($record) => match ($record?->healthScreening?->exam_type) {
                                'routine'     => 'Rutin',
                                'injury'      => 'Cedera',
                                'follow_up'   => 'Follow Up',
                                'competition' => 'Pra Kompetisi',
                                default       => '-',
                            }),

                        Placeholder::make('screening_result')
                            ->label('Hasil Screening')
                            ->content(fn ($record) => match ($record?->healthScreening?->screening_result) {
                                'fit'              => 'Fit',
                                'restricted'       => 'Restricted',
                                'requires_therapy' => 'Butuh Terapi',
                                'active_therapy'   => 'Sedang Terapi',
                                default            => '-',
                            }),

                        Placeholder::make('chief_complaint')
                            ->label('Keluhan Utama')
                            ->content(function ($record) {
                                $text = $record?->healthScreening?->chief_complaint ?? '-';

                                return new HtmlString(
                                    '<div style="white-space: normal; line-height: 1.5;">'
                                    . e($text) .
                                    '</div>'
                                );
                            })
                            ->columnSpanFull(),

                        Placeholder::make('notes_screening')
                            ->label('Catatan Pemeriksaan')
                            ->content(function ($record) {
                                $text = $record?->healthScreening?->notes ?? '-';

                                return new HtmlString(
                                    '<div style="white-space: normal; line-height: 1.5;">'
                                    . e($text) .
                                    '</div>'
                                );
                            })
                            ->columnSpanFull(),

                        // ⬇️ ini tambahan barunya
                        Placeholder::make('report_file')
                            ->label('Lampiran RME')
                            ->content(function ($record) {
                                $path = $record?->healthScreening?->report_file_path;

                                if (! $path) {
                                    return new HtmlString(
                                        '<span class="text-sm text-gray-400">Tidak ada lampiran</span>'
                                    );
                                }

                                $url = Storage::disk('public')->url($path);

                                return new HtmlString(
                                    '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer"
                                        class="text-sm font-medium underline underline-offset-4">
                                        Download / Lihat RME
                                    </a>'
                                );
                            })
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
