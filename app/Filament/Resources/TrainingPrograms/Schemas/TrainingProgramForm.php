<?php

namespace App\Filament\Resources\TrainingPrograms\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Models\TrainingProgram;

class TrainingProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ─────────────────────────────────────────
                // SECTION 1 — Informasi Program (2 kolom)
                // ─────────────────────────────────────────
                Section::make('Informasi Program')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Program')
                            ->required(),

                        Select::make('type')
                            ->label('Tipe Program')
                            ->options([
                                'daily'           => 'Daily',
                                'weekly'          => 'Weekly',
                                'pre_competition' => 'Pre competition',
                                'recovery'        => 'Recovery',
                            ])
                            ->default('weekly')
                            ->required(),

                        Select::make('intensity')
                            ->label('Intensitas')
                            ->options([
                                'low'    => 'Low',
                                'medium' => 'Medium',
                                'high'   => 'High',
                            ])
                            ->default('medium')
                            ->required(),

                        TextInput::make('planned_sessions')
                            ->label('Jumlah Sesi Rencana')
                            ->numeric(),

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

                        TextInput::make('team_name')
                            ->label('Nama Tim'),

                        TextInput::make('coach_name')
                            ->label('Nama Pelatih'),

                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required(),

                        DatePicker::make('end_date')
                            ->label('Tanggal Selesai'),
                    ]),

                // ─────────────────────────────────────────
                // SECTION 2 — Tujuan & Status (2 kolom)
                // ─────────────────────────────────────────
                Section::make('Tujuan & Status Program')
                    ->columns()
                    ->schema([
                        Textarea::make('goal')
                            ->label('Tujuan program')
                            ->rows(5)
                            ->columnSpan(1),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft'     => 'Draft',
                                'active'    => 'Active',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
            ]);
    }
}
