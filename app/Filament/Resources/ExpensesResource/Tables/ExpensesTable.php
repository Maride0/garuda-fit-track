<?php

namespace App\Filament\Resources\ExpensesResource\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Facades\Storage;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('expenses_code')
                    ->label('Kode')
                    ->sortable(),

                TextColumn::make('expense_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                TextColumn::make('applicant_name')
                    ->label('Nama Pencatat')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Kategori')
                    ->formatStateUsing(fn ($state) => ucwords($state)),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable(),

                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'paid',
                        'warning' => 'reimbursed',
                    ])
                    ->formatStateUsing(fn ($state) => ucfirst($state)),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('lihat_bukti')
                    ->label('Lihat Transaksi')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) =>\App\Filament\Resources\ExpensesResource\Pages\ViewExpenses::getUrl(['record' => $record]))
                    ->openUrlInNewTab(false),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
