<?php

namespace App\Filament\Resources\PerformanceMetrics\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PerformanceMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Informasi Dasar')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Parameter')
                            ->placeholder('Sprint 20m, Vertical Jump, VO2 Max')
                            ->required(),

                        TextInput::make('code')
                            ->label('Kode Internal')
                            ->placeholder('SPRINT_20M')
                            ->extraAttributes(['style' => 'text-transform: uppercase'])
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('code', strtoupper($state))
                            ),
                    ]),

                Section::make('Klasifikasi Olahraga')
                    ->columns(2)
                    ->schema([
                        Select::make('sport_category')
                            ->label('Kategori Olahraga')
                            ->options([
                                'general'     => 'Umum / Multicabang',
                                'olympic'     => 'Olimpiade',
                                'non_olympic' => 'Non-Olimpiade',
                            ])
                            ->searchable()
                            ->placeholder('Pilih kategori olahraga')
                            ->default('general')
                            ->reactive(),

                        Select::make('sport')
                            ->label('Cabang Olahraga')
                            ->placeholder('Pilih cabang olahraga spesifik')
                            ->options(function (callable $get) {
                                $category = $get('sport_category');

                                if ($category === 'olympic') {
                                    return [
                                        'Anggar'             => 'Anggar',
                                        'Angkat Besi'        => 'Angkat Besi',
                                        'Atletik'            => 'Atletik',
                                        'Balap Sepeda'       => 'Balap Sepeda',
                                        'Berkuda'            => 'Berkuda',
                                        'Bisbol - Sofbol'    => 'Bisbol - Sofbol',
                                        'Bola Basket'        => 'Bola Basket',
                                        'Bola Tangan'        => 'Bola Tangan',
                                        'Bola Voli'          => 'Bola Voli',
                                        'Bulutangkis'        => 'Bulutangkis',
                                        'Dayung'             => 'Dayung',
                                        'Golf'               => 'Golf',
                                        'Gulat'              => 'Gulat',
                                        'Hoki'               => 'Hoki',
                                        'Hoki Es'            => 'Hoki Es',
                                        'Judo'               => 'Judo',
                                        'Kano'               => 'Kano',
                                        'Karate'             => 'Karate',
                                        'Layar'              => 'Layar',
                                        'Loncat Indah'       => 'Loncat Indah',
                                        'Menembak'           => 'Menembak',
                                        'Panahan'            => 'Panahan',
                                        'Pancalomba Modern'  => 'Pancalomba Modern',
                                        'Panjat Tebing'      => 'Panjat Tebing',
                                        'Polo Air'           => 'Polo Air',
                                        'Renang'             => 'Renang',
                                        'Renang Indah'       => 'Renang Indah',
                                        'Renang Maraton'     => 'Renang Maraton',
                                        'Rugby'              => 'Rugby',
                                        'Selancar Ombak'     => 'Selancar Ombak',
                                        'Senam'              => 'Senam',
                                        'Sepak Bola'         => 'Sepak Bola',
                                        'Skateboard'         => 'Skateboard',
                                        'Taekwondo'          => 'Taekwondo',
                                        'Tenis'              => 'Tenis',
                                        'Tenis Meja'         => 'Tenis Meja',
                                        'Tinju'              => 'Tinju',
                                        'Triathlon'          => 'Triathlon',
                                    ];
                                }

                                if ($category === 'non_olympic') {
                                    return [
                                        'Aero Sport'     => 'Aero Sport',
                                        'Billiard'       => 'Billiard',
                                        'Bowling'        => 'Bowling',
                                        'Breakdancing'   => 'Breakdancing',
                                        'Bridge'         => 'Bridge',
                                        'Catur'          => 'Catur',
                                        'Cricket'        => 'Cricket',
                                        'Dansa'          => 'Dansa',
                                        'Dragon Boat'    => 'Dragon Boat',
                                        'Esport'         => 'Esport',
                                        'Floorball'      => 'Floorball',
                                        'Gateball'       => 'Gateball',
                                        'Jetski'         => 'Jetski',
                                        'Jujitsu'        => 'Jujitsu',
                                        'Kabaddi'        => 'Kabaddi',
                                        'Kempo'          => 'Kempo',
                                        'Kick Boxing'    => 'Kick Boxing',
                                        'Korfball'       => 'Korfball',
                                        'Kurash'         => 'Kurash',
                                        'Motor'          => 'Motor',
                                        'Muay Thai'      => 'Muay Thai',
                                        'Pencak Silat'   => 'Pencak Silat',
                                        'Petanque'       => 'Petanque',
                                        'Rugby Sevens'   => 'Rugby Sevens',
                                        'Sambo'          => 'Sambo',
                                        'Sepak Takraw'   => 'Sepak Takraw',
                                        'Sepatu Roda'    => 'Sepatu Roda',
                                        'Soft Tennis'    => 'Soft Tennis',
                                        'Squash'         => 'Squash',
                                        'Wakeboarding'   => 'Wakeboarding',
                                        'Woodball'       => 'Woodball',
                                        'Wushu'          => 'Wushu',
                                    ];
                                }

                                // general / kosong → tidak ada opsi spesifik
                                return [];
                            })
                            ->searchable()
                            ->disabled(fn ($get) =>
                                blank($get('sport_category')) ||
                                $get('sport_category') === 'general'
                            )
                            ->required(fn ($get) =>
                                in_array($get('sport_category'), ['olympic', 'non_olympic'])
                            ),
                    ]),

                Section::make('Pengukuran')
                    ->columns(2)
                    ->schema([
                        TextInput::make('default_unit')
                            ->label('Satuan Dasar')
                            ->placeholder('detik (s), cm, kg, poin')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),

                Section::make('Deskripsi')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Jelaskan cara pelaksanaan tes ini atau catatan tambahan...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
