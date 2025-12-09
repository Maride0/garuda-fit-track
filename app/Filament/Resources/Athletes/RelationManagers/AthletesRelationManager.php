<?php

namespace App\Filament\Resources\Athletes\RelationManagers;

use App\Models\TestRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AthletesRelationManager extends RelationManager
{
    // relasi di model Athlete: testRecords()
    protected static string $relationship = 'testRecords';

    protected static ?string $title = 'Test Records';

    public function form(Schema $schema): Schema
    {
        // Form ini sebenernya nggak kepake lagi
        // karena kita nggak punya Create/Edit di table().
        // Boleh dibiarkan, boleh juga nanti kamu hapus total.
        return $schema
            ->columns(2)
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('metric_id')
                            ->label('Metric')
                            ->relationship('metric', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('training_program_id')
                            ->label('Training Program')
                            ->relationship('trainingProgram', 'name')
                            ->searchable()
                            ->placeholder('Not linked'),

                        DatePicker::make('test_date')
                            ->label('Test Date')
                            ->required(),

                        Select::make('phase')
                            ->label('Phase')
                            ->options([
                                'baseline' => 'Baseline',
                                'pre'      => 'Pre-Test',
                                'mid'      => 'Mid-Test',
                                'post'     => 'Post-Test',
                                'other'    => 'Other',
                            ])
                            ->placeholder('Select phase'),

                        TextInput::make('value')
                            ->label('Value')
                            ->numeric()
                            ->required(),

                        TextInput::make('unit')
                            ->label('Unit')
                            ->placeholder('If empty, uses metric default')
                            ->default(null),
                    ]),

                Section::make('Additional')
                    ->schema([
                        TextInput::make('source')
                            ->label('Source')
                            ->placeholder('field_test, lab_test, match_data, etc.')
                            ->default(null),

                        Textarea::make('notes')
                            ->label('Notes')
                            ->placeholder('Any relevant context or observation…')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Test Records')
            ->defaultSort('test_date', 'desc')
            ->columns([
                TextColumn::make('metric.name')
                    ->label('Metric')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('trainingProgram.name')
                    ->label('Program')
                    ->placeholder('—')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('test_date')
                    ->label('Test Date')
                    ->date()
                    ->sortable(),

                BadgeColumn::make('phase')
                    ->label('Phase')
                    ->colors([
                        'gray'      => 'baseline',
                        'info'      => 'pre',
                        'warning'   => 'mid',
                        'success'   => 'post',
                        'secondary' => 'other',
                    ]),

                TextColumn::make('value')
                    ->label('Value')
                    ->formatStateUsing(function ($state, TestRecord $record) {
                        $unit = $record->unit ?: $record->metric?->default_unit;
                        return $unit ? "{$state} {$unit}" : (string) $state;
                    })
                    ->sortable(),

                TextColumn::make('source')
                    ->label('Source')
                    ->placeholder('—')
                    ->searchable(),
            ])
            // ⬇️ VIEW-ONLY: nggak ada Create/Edit/Delete lagi
            ->emptyStateHeading('No Test Records')
            ->emptyStateDescription('Test Record data is recorded from the Training Programs module.')
            ->emptyStateIcon('heroicon-o-presentation-chart-line');
    }
}
