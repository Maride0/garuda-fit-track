<?php

namespace App\Filament\Resources\ExpensesResource\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use App\Models\Expense;

class ExpensesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextInput::make('expenses_code')
                ->default(fn () => Expense::getExpensesCode())
                ->label('Kode Pengeluaran')
                ->required()
                ->readonly()
                ->disabled()
                ->dehydrated(true),

            DatePicker::make('expense_date')
                ->label('Tanggal Pengeluaran')
                ->displayFormat('d/m/Y')   
                ->native(false)            
                ->required(),

            TextInput::make('applicant_name')
                ->label('Nama Pencatat')
                ->required(),

            Select::make('type')
                ->label('Kategori')
                ->options([
                    'latihan' => 'Latihan',
                    'peralatan' => 'Peralatan',
                    'kesehatan' => 'Kesehatan',
                    'kompetisi' => 'Kompetisi',
                    'akomodasi' => 'Akomodasi',
                    'lainnya' => 'Lainnya',
                ])
                ->required(),

            TextInput::make('amount')
                ->label('Jumlah')
                ->prefix('Rp')
                ->numeric()
                ->required(),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(3)
                ->required(),

            Select::make('status')
                ->label('Status')
                ->options([
                    'paid' => 'Paid',
                    'reimbursed' => 'Reimbursed',
                ])
                ->default('paid')
                ->required(),

            FileUpload::make('receipt')
                ->label('Bukti Transaksi')
                ->directory('receipts')
                ->downloadable()
                ->previewable()
                ->nullable(),
        ]);
    }
}
