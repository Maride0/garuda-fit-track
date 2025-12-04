<?php

namespace App\Filament\Resources\ExpensesResource;

use App\Filament\Resources\ExpensesResource\Pages\CreateExpenses;
use App\Filament\Resources\ExpensesResource\Pages\ListExpenses;
use App\Filament\Resources\ExpensesResource\Schemas\ExpensesForm;
use App\Filament\Resources\ExpensesResource\Tables\ExpensesTable;
use App\Models\Expense;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExpensesResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static UnitEnum|string|null $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 7;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $recordTitleAttribute = 'description';


    public static function form(Schema $schema): Schema
    {
        return ExpensesForm::configure($schema);
    }   

    public static function table(Table $table): Table
    {
        return ExpensesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
        'index' => Pages\ListExpenses::route('/'),
        'create' => Pages\CreateExpenses::route('/create'),
        'view' => Pages\ViewExpenses::route('/{record}'), 
        ];
    }

}
