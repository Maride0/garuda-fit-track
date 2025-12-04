<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SessionsRelationManager extends RelationManager
{
    // HARUS sama dengan nama relasi di model TrainingProgram: sessions()
    protected static string $relationship = 'sessions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),

                TimePicker::make('start_time')
                    ->label('Waktu Mulai')
                    ->seconds(false),

                TextInput::make('duration_minutes')
                    ->label('Durasi (menit)')
                    ->numeric()
                    ->minValue(10)
                    ->maxValue(300)
                    ->helperText('Contoh: 60, 90, 120 menit.'),

                TextInput::make('location')
                    ->label('Lokasi')
                    ->maxLength(255),

                TextInput::make('participants_count')
                    ->label('Perkiraan Jumlah Atlet')
                    ->numeric()
                    ->minValue(1)
                    ->default(null),

                Textarea::make('activities')
                    ->label('Rencana Latihan / Aktivitas')
                    ->rows(4)
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status Sesi')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('scheduled')
                    ->required(),
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

                TextColumn::make('duration_minutes')
                    ->label('Durasi')
                    ->formatStateUsing(fn ($state) => $state ? $state . ' menit' : '—'),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('participants_count')
                    ->label('Atlet')
                    ->numeric()
                    ->alignRight()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'scheduled' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    ]),
            ])
            ->defaultSort('date', 'asc')
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Sesi Latihan'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
