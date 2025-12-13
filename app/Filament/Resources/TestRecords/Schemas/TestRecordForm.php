<?php

namespace App\Filament\Resources\TestRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                Section::make('Athlete & Metric')
                    ->columns(2)
                    ->schema([
                        Select::make('athlete_id')
                            ->label('Athlete')
                            ->relationship('athlete', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('metric_id')
                            ->label('Metric')
                            ->relationship('metric', 'name')
                            ->searchable()
                            ->required(),
                    ]),

                    Section::make('Test Record Details')
                        ->columns(2)
                        ->schema([
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
                            ->placeholder('Select phase')
                            ->default(null),

                        TextInput::make('value')
                            ->label('Value')
                            ->numeric()
                            ->required()
                            ->placeholder('e.g. 3.52'),

                        TextInput::make('unit')
                            ->label('Unit')
                            ->placeholder('Auto from metric…')
                            ->helperText('Optional. If empty, system uses metric’s default unit.')
                            ->default(null),

                        Select::make('training_program_id')
                            ->label('Training Program')
                            ->relationship('trainingProgram', 'name')
                            ->searchable()
                            ->placeholder('Not linked'),
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
}
