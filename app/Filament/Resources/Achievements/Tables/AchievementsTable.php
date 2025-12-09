<?php

namespace App\Filament\Resources\Achievements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AchievementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Nama Atlet (relasi)
                TextColumn::make('athlete.name')
                    ->label('Atlet')
                    ->searchable()
                    ->sortable(),

                // Cabang Olahraga (diambil dari atlet)
                TextColumn::make('athlete.sport')
                    ->label('Cabang Olahraga')
                    ->searchable()
                    ->sortable(),

                // Nama Prestasi
                TextColumn::make('achievement_name')
                    ->label('Nama Prestasi')
                    ->searchable()
                    ->sortable(),

                // Nama Event / Kejuaraan
                TextColumn::make('event_name')
                    ->label('Nama Event')
                    ->searchable()
                    ->sortable(),

                // Tingkat Kompetisi (badge + label rapi)
                TextColumn::make('competition_level')
                    ->label('Tingkat Kompetisi')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'international'      => 'Internasional',
                        'continental'        => 'Kontinental',
                        'national'           => 'Nasional',
                        'provincial'         => 'Provinsi',
                        'city_regional_club' => 'Kota / Regional / Klub',
                        default              => '-',
                    })
                    ->sortable(),

                // Medali (badge warna)
                TextColumn::make('medal_rank')
                    ->label('Medali')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'gold'       => 'warning',
                        'silver'     => 'gray',
                        'bronze'     => 'danger',
                        'non_podium' => 'secondary',
                        default      => 'secondary',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'gold'       => 'Emas',
                        'silver'     => 'Perak',
                        'bronze'     => 'Perunggu',
                        'non_podium' => 'Tanpa Podium',
                        default      => '-',
                    })
                    ->sortable(),

                // Peringkat
                TextColumn::make('rank')
                    ->label('Peringkat')
                    ->sortable(),

                // Tanggal Event (start_date)
                TextColumn::make('start_date')
                    ->label('Tanggal Event')
                    ->date('d M Y')
                    ->sortable(),
            ])

            ->defaultSort('start_date', 'desc') // terbaru dulu

            ->filters([
                // Filter Tingkat Kompetisi
                SelectFilter::make('competition_level')
                    ->label('Tingkat Kompetisi')
                    ->options([
                        'international'      => 'Internasional',
                        'continental'        => 'Kontinental',
                        'national'           => 'Nasional',
                        'provincial'         => 'Provinsi',
                        'city_regional_club' => 'Kota / Regional / Klub',
                    ]),

                // Filter Medali
                SelectFilter::make('medal_rank')
                    ->label('Medali')
                    ->options([
                        'gold'       => 'Emas',
                        'silver'     => 'Perak',
                        'bronze'     => 'Perunggu',
                        'non_podium' => 'Tanpa Podium',
                    ]),

                // 🔽 Filter Cabang Olahraga (Cabor) – berdasarkan field athlete.sport
                SelectFilter::make('athlete.sport')
                    ->label('Cabang Olahraga')
                    ->options([
                        // Olympic sports
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

                        // Non-olympic sports
                        'Aero Sport'         => 'Aero Sport',
                        'Billiard'           => 'Billiard',
                        'Bowling'            => 'Bowling',
                        'Breakdancing'       => 'Breakdancing',
                        'Bridge'             => 'Bridge',
                        'Catur'              => 'Catur',
                        'Cricket'            => 'Cricket',
                        'Dansa'              => 'Dansa',
                        'Dragon Boat'        => 'Dragon Boat',
                        'Esport'             => 'Esport',
                        'Floorball'          => 'Floorball',
                        'Gateball'           => 'Gateball',
                        'Jetski'             => 'Jetski',
                        'Jujitsu'            => 'Jujitsu',
                        'Kabaddi'            => 'Kabaddi',
                        'Kempo'              => 'Kempo',
                        'Kick Boxing'        => 'Kick Boxing',
                        'Korfball'           => 'Korfball',
                        'Kurash'             => 'Kurash',
                        'Motor'              => 'Motor',
                        'Muay Thai'          => 'Muay Thai',
                        'Pencak Silat'       => 'Pencak Silat',
                        'Petanque'           => 'Petanque',
                        'Rugby Sevens'       => 'Rugby Sevens',
                        'Sambo'              => 'Sambo',
                        'Sepak Takraw'       => 'Sepak Takraw',
                        'Sepatu Roda'        => 'Sepatu Roda',
                        'Soft Tennis'        => 'Soft Tennis',
                        'Squash'             => 'Squash',
                        'Wakeboarding'       => 'Wakeboarding',
                        'Woodball'           => 'Woodball',
                        'Wushu'              => 'Wushu',
                    ]),
            ])

            ->recordActions([
                EditAction::make()
                    ->label('Ubah'),
                DeleteAction::make()
                    ->label('Hapus'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ]);
    }
}
