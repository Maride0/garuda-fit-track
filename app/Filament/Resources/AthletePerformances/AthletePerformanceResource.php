<?php

namespace App\Filament\Resources\AthletePerformances;

use App\Filament\Resources\AthletePerformances\Pages\CreateAthletePerformance;
use App\Filament\Resources\AthletePerformances\Pages\EditAthletePerformance;
use App\Filament\Resources\AthletePerformances\Pages\ListAthletePerformances;
use App\Filament\Resources\AthletePerformances\Schemas\AthletePerformanceForm;
use App\Filament\Resources\AthletePerformances\Tables\AthletePerformancesTable;
use App\Models\AthletePerformance;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AthletePerformanceResource extends Resource
{
    protected static ?string $model = AthletePerformance::class;

    // ganti ke icon yang lebih cocok
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static UnitEnum|string|null $navigationGroup = 'Athlete Management';
    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = null; 
    // record perf sebenarnya tidak punya “judul”
    // jadi kita biarkan null → Filament tidak memaksakan

    public static function form(Schema $schema): Schema
    {
        return AthletePerformanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AthletePerformancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAthletePerformances::route('/'),
            'create' => CreateAthletePerformance::route('/create'),
            'edit'   => EditAthletePerformance::route('/{record}/edit'),
        ];
    }
}
