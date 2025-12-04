<?php

namespace App\Filament\Resources\ExpensesResource\Pages;

use App\Filament\Resources\ExpensesResource\ExpensesResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Filament\Forms;
use App\Models\Expense;
use Illuminate\Contracts\View\View;


class ListExpenses extends ListRecords
{
    protected static string $resource = ExpensesResource::class;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Pengeluaran')
            ->color('warning')
            ->icon('heroicon-o-plus'),
            
            Action::make('exportPdf')
            ->label('Export PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->form([
                Forms\Components\Select::make('month')
                    ->label('Pilih Bulan')
                    ->required()
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ]),
                Forms\Components\TextInput::make('year')
                    ->label('Tahun')
                    ->numeric()
                    ->required()
                    ->default(date('Y')),
            ])
            ->action(function (array $data) {
                $expenses = \App\Models\Expense::whereMonth('expense_date', $data['month'])
                    ->whereYear('expense_date', $data['year'])
                    ->orderBy('expense_date')
                    ->get();

                $pdf = Pdf::loadView('pdf.expenses-report', [
                    'expenses' => $expenses,
                    'month' => $data['month'],
                    'year' => $data['year'],
                ]);

                return response()->streamDownload(
                    fn () => print($pdf->output()),
                    "Laporan-Pengeluaran-{$data['month']}-{$data['year']}.pdf"
                );
            })
            ->modalHeading('Export Laporan Bulanan')
            ->modalButton('Export')
            ->color('danger'),
    ];
    }

}
