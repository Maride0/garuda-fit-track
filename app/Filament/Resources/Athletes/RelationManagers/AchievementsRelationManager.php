<?php

namespace App\Filament\Resources\Athletes\RelationManagers;

use Filament\Schemas\Components\Section; 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Facades\Http;

class AchievementsRelationManager extends RelationManager
{
    protected static string $relationship = 'achievements';

    protected static ?string $title = 'Prestasi';
    protected static ?string $label = 'Prestasi';
    protected static ?string $pluralLabel = 'Prestasi';

    /*
     * FORM (Filament 4.2 pakai Schema)
     */
    public function form(Schema $schema): Schema
{
    return $schema
        ->columns(1) // ⬅️ root: 1 kolom aja, biar semua section ditumpuk ke bawah
        ->components([

            // ID di paling atas, full width
            TextInput::make('achievement_id')
                ->label('ID Prestasi')
                ->disabled()
                ->dehydrated(false)
                ->default(fn () => \App\Models\Achievement::generateNextId())
                ->columnSpanFull(),
            // SECTION 1 — Informasi Prestasi
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

                    FileUpload::make('evidence_file')
                        ->label('Unggah Berkas (sertifikat / bukti)')
                        ->directory('achievements')
                        ->openable()
                        ->downloadable()
                        ->nullable(),
                ])
                ->columns(2)
                ->columnSpanFull(),

            // SECTION 3 — Detail Prestasi
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
                        ->dehydrated() // ⬅️ paksa selalu disimpan
                        ->disabled(fn ($get) => $get('medal_rank') !== 'non_podium'),

                    TextInput::make('result')
                        ->label('Hasil (Skor / Waktu / Jarak)')
                        ->nullable(),
                ])
                ->columns(3)
                ->columnSpanFull(),

            // SECTION 2 — Informasi Kegiatan
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

                ])->columns(2)->columnSpanFull(),
        ]);
}

    /*
     * TABLE
     */
    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('event_name')
                    ->label('Event')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('competition_level')
                    ->label('Tingkat')
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

                TextColumn::make('achievement_name')
                    ->label('Prestasi')
                    ->searchable(),

                TextColumn::make('medal_rank')
                    ->label('Medal')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'gold'       => 'warning',
                        'silver'     => 'gray',
                        'bronze'     => 'danger',
                        'non_podium' => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'gold'       => 'Gold',
                        'silver'     => 'Silver',
                        'bronze'     => 'Bronze',
                        'non_podium' => 'Non-Podium',
                    }),

                TextColumn::make('rank')
                    ->label('Peringkat'),

                TextColumn::make('start_date')
                    ->label('Tanggal')
                    ->date('d M Y'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Prestasi')
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
