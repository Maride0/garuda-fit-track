<?php

namespace App\Filament\Resources\TrainingPrograms\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms;
use App\Models\PerformanceMetric;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class PerformanceEvaluationsRelationManager extends RelationManager
{
    protected static string $relationship = 'performanceEvaluations';

    protected static ?string $title = 'Program Evaluations';

    public static function getModelLabel(): string
    {
        return 'Program Evaluation';
    }

    /** ============================================
     *  FORM SECTION
     * ============================================ */
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([

                Select::make('athlete_id')
                    ->label('Athlete')
                    ->required()
                    ->searchable()
                    ->options(function (RelationManager $livewire) {
                        $program = $livewire->getOwnerRecord();
                        $program->loadMissing('athletes');

                        return $program->athletes
                            ->pluck('name', 'athlete_id')
                            ->toArray();
                    }),

                DatePicker::make('evaluation_date')
                    ->label('Evaluation Date')
                    ->default(today())
                    ->required(),

                Section::make('Sub-Ratings')
                    ->schema([
                        TextInput::make('discipline_score')
                            ->label('Discipline (0–100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->helperText('0 = sangat buruk, 100 = sangat baik')
                            ->live(onBlur: true)
                            ->required()
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $this->recalculateOverall($get, $set)
                            ),

                        TextInput::make('attendance_score')
                            ->label('Attendance (0–100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->helperText('Ringkasan kedisiplinan hadir selama program')
                            ->live(onBlur: true)
                            ->required()
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $this->recalculateOverall($get, $set)
                            ),

                        TextInput::make('effort_score')
                            ->label('Effort (0–100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $this->recalculateOverall($get, $set)
                            ),

                        TextInput::make('attitude_score')
                            ->label('Attitude (0–100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $this->recalculateOverall($get, $set)
                            ),

                        TextInput::make('tactical_understanding_score')
                            ->label('Tactical Understanding (0–100)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                                $this->recalculateOverall($get, $set)
                            ),
                        TextInput::make('overall_rating')
                            ->label('Overall Rating (0–100)')
                            ->numeric()
                            ->disabled()       // user gak bisa edit
                            ->dehydrated(true)
                            ->required(false),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Optional Metric Evaluation')
                    ->schema([

                        Select::make('metric_id')
                            ->label('Metric (Optional)')
                            ->native(false)
                            ->searchable()
                            ->options(function (RelationManager $livewire) {
                                $program = $livewire->getOwnerRecord();

                                return PerformanceMetric::query()
                                    ->where(function ($q) use ($program) {

                                        // GENERAL metrics
                                        $q->where(function ($q2) {
                                            $q2->where('sport_category', 'general')
                                               ->whereNull('sport');
                                        });

                                        // Sport-specific metrics
                                        if (!empty($program->sport)) {
                                            $q->orWhere('sport', $program->sport);
                                        }
                                    })
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->nullable(),

                        TextInput::make('value_numeric')
                            ->label('Metric Numeric Value')
                            ->numeric()
                            ->nullable(),

                        TextInput::make('value_label')
                            ->label('Metric Text Value')
                            ->nullable(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Textarea::make('coach_notes')
                    ->label('Coach Notes')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
    }

    /** ============================================
     *  TABLE SECTION
     * ============================================ */
    public function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('athlete.name')
                    ->label('Athlete')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('overall_rating')
                    ->label('Rating')
                    ->badge()
                    ->color(fn ($state) =>
                        $state >= 80 ? 'success'
                        : ($state >= 50 ? 'warning' : 'danger')
                    )
                    ->sortable(),

                TextColumn::make('evaluation_date')
                    ->label('Date')
                    ->date(),

                TextColumn::make('metric.name')
                    ->label('Metric')
                    ->placeholder('General Evaluation')
                    ->color('gray'),

                TextColumn::make('value_numeric')
                    ->label('Value'),

                TextColumn::make('coach_notes')
                    ->label('Notes')
                    ->limit(40),
            ])

            ->headerActions([
                CreateAction::make(),
            ])

            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
    private function recalculateOverall(callable $get, callable $set): void
    {
        $fields = [
            'discipline_score',
            'attendance_score',
            'effort_score',
            'attitude_score',
            'tactical_understanding_score',
        ];

        $values = [];

        foreach ($fields as $field) {
            $value = $get($field);

            if ($value !== null && $value !== '') {
                $values[] = (float) $value;
            }
        }

        if (empty($values)) {
            $set('overall_rating', null);
            return;
        }

        $avg = array_sum($values) / count($values);
        $set('overall_rating', round($avg, 1)); // 0–100, 1 decimal
    }
}