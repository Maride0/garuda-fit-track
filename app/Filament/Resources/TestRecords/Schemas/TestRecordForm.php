<?php

namespace App\Filament\Resources\TestRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            // Layout halaman: desktop 2 kolom, layar kecil 1 kolom
            ->columns([
                'default' => 1,
                'lg' => 2,
            ])
            ->components([

                // =========================
                // KIRI: Atlet & Parameter
                // =========================
                Section::make('Atlet & Parameter Tes')
                    ->columns(2)
                    ->schema([
                        Select::make('athlete_id')
                            ->label('Atlet')
                            ->relationship('athlete', 'name')
                            ->preload()
                            ->searchable()
                            ->optionsLimit(50)
                            ->placeholder('Pilih atlet')
                            ->helperText('Jika tidak terlihat di daftar, ketik untuk mencari.')
                            ->required(),

                        Select::make('metric_id')
                            ->label('Parameter Tes')
                            ->relationship('metric', 'name')
                            ->preload()
                            ->searchable()
                            ->optionsLimit(50)
                            ->placeholder('Pilih parameter tes')
                            ->helperText('Contoh: Sprint 10 m, CMJ, VO₂ Max, dll.')
                            ->required(),
                    ])
                    ->columnSpan(1),

                // =========================
                // KANAN: Detail Tes + Tambahan
                // =========================
                Section::make('Detail Catatan Tes')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('test_date')
                            ->label('Tanggal Tes')
                            ->helperText('Tanggal pelaksanaan pengujian.')
                            ->required(),

                        Select::make('phase')
                            ->label('Fase Pengujian')
                            ->options([
                                'baseline' => 'Baseline',
                                'pre'      => 'Pra-Tes',
                                'mid'      => 'Tes Tengah',
                                'post'     => 'Pasca-Tes',
                                'other'    => 'Lainnya',
                            ])
                            ->placeholder('Pilih fase')
                            ->helperText('Menunjukkan posisi tes dalam siklus latihan.')
                            ->default(null),

                        TextInput::make('value')
                            ->label('Hasil Tes')
                            ->numeric()
                            ->required()
                            ->placeholder('Contoh: 58')
                            ->helperText('Masukkan nilai hasil pengukuran sesuai parameter.'),

                        TextInput::make('unit')
                            ->label('Satuan')
                            ->placeholder('Otomatis dari parameter…')
                            ->helperText('Opsional. Jika kosong, sistem menggunakan satuan default dari parameter.')
                            ->default(null),

                        Select::make('training_program_id')
                            ->label('Program Latihan')
                            ->relationship('trainingProgram', 'name')
                            ->preload()
                            ->searchable()
                            ->optionsLimit(50)
                            ->placeholder('Tidak terhubung')
                            ->helperText('Pilih jika hasil tes terkait program latihan tertentu.')
                            ->default(null),

                        TextInput::make('source')
                            ->label('Sumber Data')
                            ->columnSpanFull()
                            ->placeholder('Contoh: Tes lapangan / Tes laboratorium / Data pertandingan')
                            ->helperText('Isi sumber pengambilan data agar mudah ditelusuri.')
                            ->default(null),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull()
                            ->rows(4)
                            ->placeholder('Tulis konteks/observasi singkat (mis. kondisi atlet, cuaca, alat ukur, dll.)')
                            ->default(null),
                    ])
                    ->columnSpan(1),
            ]);
    }
}
