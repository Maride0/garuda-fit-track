<?php

namespace App\Filament\Widgets;

use App\Models\TrainingProgram;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActiveTrainingPrograms extends TableWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder =>
                TrainingProgram::query()
                    ->where('status', 'active')
                    ->limit(5) // ⬅️ tampil 5 baris aja
            )

            ->columns([
                TextColumn::make('name')
                    ->label('Program'),
                TextColumn::make('sport')
                    ->label('Olahraga'),
                TextColumn::make('coach_name')
                    ->label('Pelatih'),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->paginated(false)
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ])
            ]);
    }
    protected function getColumns(): int | array
    {
        return 4;
    }
     // lebar widget (optional, kalau mau 8 kolom)
    // ActiveTrainingPrograms
    protected int|string|array $columnSpan = [
        'sm'  => 1,
        'md'  => 1,
        'lg'  => 2,
        'xl'  => 2,
        '2xl' => 3, // misal di layar super gede mau 1:3
    ];
}
