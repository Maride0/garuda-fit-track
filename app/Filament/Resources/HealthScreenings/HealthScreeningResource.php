<?php

namespace App\Filament\Resources\HealthScreenings;

use App\Filament\Resources\HealthScreenings\Pages\CreateHealthScreening;
use App\Filament\Resources\HealthScreenings\Pages\EditHealthScreening;
use App\Filament\Resources\HealthScreenings\Pages\ListHealthScreenings;
use App\Filament\Resources\HealthScreenings\Schemas\HealthScreeningForm;
use App\Filament\Resources\HealthScreenings\Tables\HealthScreeningsTable;
use App\Models\HealthScreening;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HealthScreeningResource extends Resource
{
    protected static ?string $model = HealthScreening::class;

    protected static UnitEnum|string|null $navigationGroup = 'Health Management';
    protected static ?int $navigationSort = 5;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    public static function getRecordTitle($record): ?string
    {
        if (! $record) {
            return null;
        }

        return 'Screening ' . $record->screening_id;
    }
    protected static ?string $recordTitleAttribute = 'screening_id';
    
    public static function form(Schema $schema): Schema
    {
        return HealthScreeningForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HealthScreeningsTable::configure($table);
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
            'index' => ListHealthScreenings::route('/'),
            'create' => CreateHealthScreening::route('/create'),
            'edit' => EditHealthScreening::route('/{record}/edit'),
        ];
    }
}
