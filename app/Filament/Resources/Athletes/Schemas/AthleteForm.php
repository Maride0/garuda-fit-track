<?php

namespace App\Filament\Resources\Athletes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AthleteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('athlete_id')
                    ->label('ID Atlet')
                    ->disabled()          // tampil tapi tidak bisa diubah
                    ->dehydrated(false),  // tidak dikirim ke backend (aman),

                TextInput::make('name')
                    ->label('Nama Atlet')
                    ->required(),

                // 1) Sport Category (olympic / non_olympic)
                Select::make('sport_category')
                    ->label('Kategori Olahraga')
                    ->options([
                        'olympic'     => 'Olympic',
                        'non_olympic' => 'Non-Olympic',
                    ])
                    ->required()
                    ->reactive(), // penting: biar sport bisa berubah sesuai kategori

                // 2) Sport (options tergantung sport_category)
                Select::make('sport')
                    ->label('Cabang Olahraga')
                    ->required()
                    ->searchable()
                    ->options(function (callable $get) {
                        $category = $get('sport_category');

                        if ($category === 'olympic') {
                            return [
                                'Anggar'          => 'Anggar',
                                'Angkat Besi'     => 'Angkat Besi',
                                'Atletik'         => 'Atletik',
                                'Balap Sepeda'    => 'Balap Sepeda',
                                'Berkuda'         => 'Berkuda',
                                'Bisbol - Sofbol' => 'Bisbol - Sofbol',
                                'Bola Basket'     => 'Bola Basket',
                                'Bola Tangan'     => 'Bola Tangan',
                                'Bola Voli'       => 'Bola Voli',
                                'Bulutangkis'     => 'Bulutangkis',
                                'Dayung'          => 'Dayung',
                                'Golf'            => 'Golf',
                                'Gulat'           => 'Gulat',
                                'Hoki'            => 'Hoki',
                                'Hoki Es'         => 'Hoki Es',
                                'Judo'            => 'Judo',
                                'Kano'            => 'Kano',
                                'Karate'          => 'Karate',
                                'Layar'           => 'Layar',
                                'Loncat Indah'    => 'Loncat Indah',
                                'Menembak'        => 'Menembak',
                                'Panahan'         => 'Panahan',
                                'Pancalomba Modern' => 'Pancalomba Modern',
                                'Panjat Tebing'   => 'Panjat Tebing',
                                'Polo Air'        => 'Polo Air',
                                'Renang'          => 'Renang',
                                'Renang Indah'    => 'Renang Indah',
                                'Renang Maraton'  => 'Renang Maraton',
                                'Rugby'           => 'Rugby',
                                'Selancar Ombak'  => 'Selancar Ombak',
                                'Senam'           => 'Senam',
                                'Sepak Bola'      => 'Sepak Bola',
                                'Skateboard'      => 'Skateboard',
                                'Taekwondo'       => 'Taekwondo',
                                'Tenis'           => 'Tenis',
                                'Tenis Meja'      => 'Tenis Meja',
                                'Tinju'           => 'Tinju',
                                'Triathlon'       => 'Triathlon',
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

                        // kalau sport_category belum dipilih
                        return [];
                    })
                    ->disabled(fn ($get) => blank($get('sport_category'))),

                DatePicker::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->required()
                    ->minDate(now()->subYears(100))
                    ->maxDate(now()->subYears(5)),


                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->required()
                    ->options([
                        'male'   => 'Laki-laki',
                        'female' => 'Perempuan',
                    ]),

                TextInput::make('height')
                    ->label('Tinggi (cm)')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('weight')
                    ->label('Berat (kg)')
                    ->numeric()
                    ->minValue(0)
                    ->required(),

                TextInput::make('contact')
                    ->label('Kontak')
                    ->tel()
                    ->required()
                    ->unique(
                        table: 'athletes',
                        column: 'contact',
                        ignoreRecord: true, // biar waktu edit nggak dianggap duplikat dirinya sendiri
                    )
                    ->maxLength(20)
                    ->minLength(9),  

                // === STATUS MEDIS (READ ONLY) ===
                Placeholder::make('status_display')
                    ->label('Status Medis')
                    ->content(fn ($record) =>
                        match ($record?->status) {
                            'fit'              => 'Fit',
                            'under_monitoring' => 'Dalam Pemantauan',
                            'active_therapy'   => 'Terapi Aktif',
                            'restricted'       => 'Terbatas',
                            'not_screened', null => 'Belum Discreening',
                            default            => $record->status,
                        }
                    )
                    ->visible(fn ($record) => filled($record)),
                      
                // Select::make('status')
                //     ->label('Status')
                //     ->options([
                //         'not_screened'     => 'Belum Discreening',
                //         'fit'              => 'Fit',
                //         'under_monitoring' => 'Dalam Pemantauan',
                //         'active_therapy'   => 'Terapi Aktif',
                //         'restricted'       => 'Terbatas',
                //     ])
                //     ->default('not_screened')
                //     ->required(),
            ]);
    }
}
