<?php

namespace App\Filament\Resources\PerformanceMetrics;

use App\Filament\Resources\PerformanceMetrics\Pages\CreatePerformanceMetric;
use App\Filament\Resources\PerformanceMetrics\Pages\EditPerformanceMetric;
use App\Filament\Resources\PerformanceMetrics\Pages\ListPerformanceMetrics;
use App\Filament\Resources\PerformanceMetrics\Schemas\PerformanceMetricForm;
use App\Filament\Resources\PerformanceMetrics\Tables\PerformanceMetricsTable;
use App\Models\PerformanceMetric;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PerformanceMetricResource extends Resource
{
    protected static ?string $model = PerformanceMetric::class;

    // Ganti icon kalau mau, ini placeholder lucu
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;
    protected static UnitEnum|string|null $navigationGroup = 'Athlete Management';
    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PerformanceMetricForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerformanceMetricsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPerformanceMetrics::route('/'),
            'create' => CreatePerformanceMetric::route('/create'),
            'edit'   => EditPerformanceMetric::route('/{record}/edit'),
        ];
    }

    /**
     * Override createRecord() supaya metric_id auto-generate.
     */
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $last = PerformanceMetric::query()
            ->orderBy('metric_id', 'desc')
            ->first();

        $nextNumber = $last
            ? ((int) substr($last->metric_id, 3)) + 1
            : 1;

        $data['metric_id'] = 'MET' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $data;
    }
}
