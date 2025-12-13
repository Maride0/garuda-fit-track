<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class AthletesRelationManager extends RelationManager
{
    protected static string $relationship = 'athletes';

    protected static ?string $title = 'Atlet Program Latihan';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('athlete_id')->label('ID Atlet')->searchable(),
                TextColumn::make('name')->label('Nama Atlet')->searchable(),
                TextColumn::make('gender')->label('Gender')->badge(),
                TextColumn::make('sport_category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'olympic' ? 'Olympic' : 'Non-Olympic'),
                TextColumn::make('sport')->label('Cabang Olahraga')->searchable(),
                TextColumn::make('status')->label('Status Atlet')->badge(),
                TextColumn::make('pivot.status')->label('Status di Program')->badge(),
                TextColumn::make('pivot.join_date')->label('Tanggal Bergabung')->date('d M Y'),
            ])
            ->defaultSort('name')
            ->headerActions([
                AttachAction::make()
                    ->label('Tambah Atlet ke Program')

                    // ⬇️ Ini FILTER MAGIC NYA
                    ->recordSelectOptionsQuery(function (Builder $query, $livewire) {
                        $program = $livewire->getOwnerRecord();

                        return $query
                            ->where('sport_category', $program->sport_category)
                            ->where('sport', $program->sport);
                    })

                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['athlete_id', 'name'])
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        DatePicker::make('join_date')
                            ->label('Tanggal Bergabung')
                            ->default(now())
                            ->required(),
                    ]),
            ])
            ->recordActions([
                DetachAction::make()->label('Keluarkan dari Program'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()->label('Keluarkan Banyak Atlet'),
                ]),
            ]);
    }
}
