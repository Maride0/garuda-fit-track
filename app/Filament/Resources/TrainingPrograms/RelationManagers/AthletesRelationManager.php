<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

// ⬇️ pakai Actions, BUKAN Tables\Actions
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\DatePicker;

class AthletesRelationManager extends RelationManager
{
    // HARUS sama dengan nama relasi di model TrainingProgram: athletes()
    protected static string $relationship = 'athletes';

    protected static ?string $title = 'Athletes in Program';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]); // nggak pakai form di sini
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('athlete_id')
                    ->label('ID Atlet')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama Atlet')
                    ->searchable(),

                TextColumn::make('gender')
                    ->label('Gender')
                    ->badge(),

                TextColumn::make('sport_category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(
                        fn ($state) => $state === 'olympic' ? 'Olympic' : 'Non-Olympic'
                    )
                    ->toggleable(),

                TextColumn::make('sport')
                    ->label('Cabang Olahraga')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status Atlet')
                    ->badge(),

                TextColumn::make('pivot.status')
                    ->label('Status di Program')
                    ->badge()
                    ->colors([
                        'active'    => 'success',
                        'completed' => 'info',
                        'dropped'   => 'danger',
                    ])
                    ->toggleable(),

                TextColumn::make('pivot.join_date')
                    ->label('Join Date')
                    ->date('d M Y')
                    ->toggleable(),
            ])
            ->defaultSort('name')
            ->headerActions([
                AttachAction::make()
                    ->label('Tambah Atlet ke Program')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['athlete_id', 'name'])
                    // ⬇️ ini yang penting
                    ->schema(fn (AttachAction $action): array => [
                        // field select atlet (WAJIB)
                        $action->getRecordSelect(),

                        // field pivot join_date
                        DatePicker::make('join_date')
                            ->label('Join Date')
                            ->default(now())
                            ->required(),
                    ]),
            ])
            ->recordActions([
                DetachAction::make()
                    ->label('Keluarkan dari Program'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->label('Keluarkan Banyak Atlet'),
                ]),
            ]);
    }
}
