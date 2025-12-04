<?php

namespace App\Filament\Resources\PerformanceMetrics\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PerformanceMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                
                Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Metric Name')
                            ->placeholder('Sprint 20m, Vertical Jump, VO2 Max')
                            ->required(),

                        TextInput::make('code')
                            ->label('Internal Code')
                            ->placeholder('SPRINT_20M')
                            ->extraAttributes(['style' => 'text-transform: uppercase'])
                            ->afterStateUpdated(fn ($state, callable $set) => 
                                $set('code', strtoupper($state))
                            ),
                    ]),

                Section::make('Sport Classification')
                    ->columns(2)
                    ->schema([
                        Select::make('sport_category')
                            ->label('Sport Category')
                            ->options([
                                'olympic' => 'Olympic',
                                'non_olympic' => 'Non-Olympic',
                                'para_sport' => 'Para Sport',
                                'other' => 'Other',
                            ])
                            ->searchable()
                            ->placeholder('Select category')
                            ->default(null),

                        TextInput::make('sport')
                            ->label('Specific Sport')
                            ->placeholder('Panahan, Bola Basket, Renang')
                            ->default(null),
                    ]),

                Section::make('Measurement')
                    ->columns(2)
                    ->schema([
                        TextInput::make('default_unit')
                            ->label('Default Unit')
                            ->placeholder('s, cm, kg, points')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Describe how this test is performed or additional notes...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
