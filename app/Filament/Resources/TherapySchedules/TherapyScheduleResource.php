<?php

namespace App\Filament\Resources\TherapySchedules;

use App\Filament\Resources\TherapySchedules\Pages\CreateTherapySchedule;
use App\Filament\Resources\TherapySchedules\Pages\EditTherapySchedule;
use App\Filament\Resources\TherapySchedules\Pages\ListTherapySchedules;
use App\Filament\Resources\TherapySchedules\Schemas\TherapyScheduleForm;
use App\Filament\Resources\TherapySchedules\Tables\TherapySchedulesTable;
use App\Models\TherapySchedule;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TherapyScheduleResource extends Resource
{
    protected static ?string $model = TherapySchedule::class;

    public static function getPluralLabel(): string
    {
        return 'Jadwal Terapi';
    }
    public static function getLabel(): string
    {
        return 'Jadwal Terapi';
    }

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Kesehatan';
    protected static ?int $navigationSort = 8;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return TherapyScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TherapySchedulesTable::configure($table);
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
            'index' => ListTherapySchedules::route('/'),
            'create' => CreateTherapySchedule::route('/create'),
            'edit' => EditTherapySchedule::route('/{record}/edit'),
        ];
    }
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        // ambil dari query param saat datang dari screening
        if (request()->has('health_screening_id')) {
            $data['health_screening_id'] = request()->get('health_screening_id');
        }

        if (request()->has('athlete_id')) {
            $data['athlete_id'] = request()->get('athlete_id');
        }

        return $data;
    }

}
