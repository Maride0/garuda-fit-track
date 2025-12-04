<?php

namespace App\Filament\Resources\Achievements\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;

class AchievementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                // ============================
                // ID Prestasi
                // ============================
                TextInput::make('achievement_id')
                    ->label('ID Prestasi')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(fn () => \App\Models\Achievement::generateNextId())
                    ->columnSpanFull(),

                // ============================
                // Atlet (hanya di Resource)
                // ============================
                Select::make('athlete_id')
                    ->label('Atlet')
                    ->relationship(
                        name: 'athlete',
                        titleAttribute: 'name',
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpanFull(),

                // ============================
                // SECTION 1 — Informasi Prestasi
                // ============================
                Section::make('Informasi Prestasi')
                    ->schema([
                        TextInput::make('achievement_name')
                            ->label('Nama Prestasi')
                            ->required(),

                        TextInput::make('event_number')
                            ->label('Nomor Pertandingan / Event')
                            ->nullable(),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->nullable(),

                        FileUpload::make('evidence_file') // atau nama kolommu
                            ->label('Unggah Berkas (sertifikat / bukti)')
                            ->disk('public')
                            ->directory('achievements')      // bebas, mis: 'achievements/certificates'
                            ->preserveFilenames()
                            ->acceptedFileTypes(['application/pdf']) // ⬅️ HANYA PDF
                            ->downloadable()
                            ->openable(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                // ============================
                // SECTION 2 — Detail Prestasi
                // ============================
                Section::make('Detail Prestasi')
                    ->schema([
                        Select::make('medal_rank')
                            ->label('Medal / Rank')
                            ->options([
                                'gold'       => 'Gold',
                                'silver'     => 'Silver',
                                'bronze'     => 'Bronze',
                                'non_podium' => 'Non-Podium',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state === 'gold')       $set('rank', 1);
                                elseif ($state === 'silver') $set('rank', 2);
                                elseif ($state === 'bronze') $set('rank', 3);
                                elseif ($state === 'non_podium') $set('rank', null);
                            })
                            ->required(),

                        TextInput::make('rank')
                            ->label('Peringkat')
                            ->numeric()
                            ->minValue(1)
                            ->nullable()
                            ->dehydrated()
                            ->disabled(fn ($get) => $get('medal_rank') !== 'non_podium'),

                        TextInput::make('result')
                            ->label('Hasil (Skor / Waktu / Jarak)')
                            ->nullable(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                // ============================
                // SECTION 3 — Informasi Kegiatan
                // ============================
                Section::make('Informasi Kegiatan')
                    ->schema([
                        TextInput::make('event_name')
                            ->label('Nama Event')
                            ->required(),

                        Select::make('competition_level')
                            ->label('Tingkat Kompetisi')
                            ->options([
                                'international'      => 'Internasional',
                                'continental'        => 'Kontinental',
                                'national'           => 'Nasional',
                                'provincial'         => 'Provinsi',
                                'city_regional_club' => 'Kota / Regional / Klub',
                            ])
                            ->required(),

                        TextInput::make('organizer')
                            ->label('Penyelenggara')
                            ->required(),

                        TextInput::make('location')
                            ->label('Lokasi')
                            ->nullable(),

                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required(),

                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required(),
    
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
