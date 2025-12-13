<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use Barryvdh\DomPDF\Facade\Pdf;

class AchievementExportController extends Controller
{
    public function export(Request $request)
    {
        // Validasi tanggal
        $request->validate([
            'from' => 'required|date',
            'to'   => 'required|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to   = $request->to;

        // Ambil data prestasi berdasarkan periode start_date
        $data = Achievement::with('athlete')
            ->when($from, fn($q) => $q->where('start_date', '>=', $from))
            ->when($to, fn($q) => $q->where('start_date', '<=', $to))
            ->orderBy('start_date', 'asc')
            ->get();

        // Generate PDF
        $pdf = Pdf::loadView('export.achievements-report', [
            'data' => $data,
            'from' => $from,
            'to'   => $to,
        ])->setPaper('A4', 'portrait');

        return $pdf->download("Laporan_Prestasi_{$from}_sampai_{$to}.pdf");
    }
}
