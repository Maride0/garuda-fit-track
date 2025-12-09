<?php

namespace App\Filament\Resources\TestRecords;

use App\Filament\Resources\TestRecords\Pages\CreateTestRecord;
use App\Filament\Resources\TestRecords\Pages\EditTestRecord;
use App\Filament\Resources\TestRecords\Pages\ListTestRecords;
use App\Filament\Resources\TestRecords\Schemas\TestRecordForm;
use App\Filament\Resources\TestRecords\Tables\TestRecordsTable;
use App\Models\TestRecord;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TestRecordResource extends Resource
{
    protected static ?string $model = TestRecord::class;

    public static function getPluralLabel(): string
    {
        return 'Catatan Tes Performa';
    }

    public static function getLabel(): string
    {
        return 'Catatan Tes Performa';
    }

    // ganti ke icon yang lebih cocok
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPresentationChartBar;

    protected static UnitEnum|string|null $navigationGroup = 'Pengembangan Atlet';
    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = null; 
    // record perf sebenarnya tidak punya “judul”
    // jadi kita biarkan null → Filament tidak memaksakan

    public static function form(Schema $schema): Schema
    {
        return TestRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestRecordsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTestRecords::route('/'),
            'create' => CreateTestRecord::route('/create'),
            'edit'   => EditTestRecord::route('/{record}/edit'),
        ];
    }
}
