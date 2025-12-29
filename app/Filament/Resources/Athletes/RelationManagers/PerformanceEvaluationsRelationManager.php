<?php

namespace App\Filament\Resources\Athletes\RelationManagers;

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


class PerformanceEvaluationsRelationManager extends RelationManager
{
    protected static string $relationship = 'performanceEvaluations';

    protected static ?string $title = 'Evaluasi Program';

    public function form(Schema $schema): Schema
    {
        // Di halaman Athlete kita mau tab ini jadi history aja (read-only),
        // jadi nggak perlu form.
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('program.name')
                    ->label('Program')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('evaluation_date')
                    ->label('Tanggal Evaluasi')
                    ->date(),

                TextColumn::make('overall_rating')
                    ->label('Nilai')
                    ->badge()
                    ->color(fn ($state) =>
                        $state >= 8 ? 'success'
                        : ($state >= 5 ? 'warning' : 'danger')
                    ),

                TextColumn::make('discipline_score')
                    ->label('Disiplin')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('effort_score')
                    ->label('Usaha')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('attitude_score')
                    ->label('Sikap')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('tactical_understanding_score')
                    ->label('Taktik')
                    ->alignCenter()
                    ->toggleable(),

                TextColumn::make('coach_notes')
                    ->label('Catatan Pelatih')
                    ->limit(40),
            ])
            ->headerActions([
                // nggak ada Create di sini — input tetap lewat Training Program
            ])
            ->actions([
                // kalau mau boleh kasih Edit/Delete di sini, tapi bisa juga dikosongkan
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}