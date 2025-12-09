<?php

namespace App\Filament\Resources\TrainingPrograms;

use App\Filament\Resources\TrainingPrograms\Pages\CreateTrainingProgram;
use App\Filament\Resources\TrainingPrograms\Pages\EditTrainingProgram;
use App\Filament\Resources\TrainingPrograms\Pages\ListTrainingPrograms;
use App\Filament\Resources\TrainingPrograms\Schemas\TrainingProgramForm;
use App\Filament\Resources\TrainingPrograms\Tables\TrainingProgramsTable;
use App\Models\TrainingProgram;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\TrainingPrograms\RelationManagers\AthletesRelationManager;
use App\Filament\Resources\TrainingPrograms\RelationManagers\SessionsRelationManager;
use App\Filament\Resources\TrainingPrograms\RelationManagers\PerformanceEvaluationsRelationManager;

class TrainingProgramResource extends Resource
{
    protected static ?string $model = TrainingProgram::class;

    public static function getPluralLabel(): string
    {
        return 'Program Latihan';
    }

    public static function getLabel(): string
    {
        return 'Program Latihan';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static UnitEnum|string|null $navigationGroup = 'Pengembangan Atlet';

    // ⬅️ urutan ketiga di grup itu
    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TrainingProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingProgramsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SessionsRelationManager::class,
            AthletesRelationManager::class,
            PerformanceEvaluationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingPrograms::route('/'),
            'create' => CreateTrainingProgram::route('/create'),
            'edit' => EditTrainingProgram::route('/{record}/edit'),
        ];
    }
}
