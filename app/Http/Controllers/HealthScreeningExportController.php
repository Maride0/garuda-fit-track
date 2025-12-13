<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthScreening;
use Barryvdh\DomPDF\Facade\Pdf;

class HealthScreeningExportController extends Controller
{
    public function export(Request $request)
    {
        // ✅ DEFAULT TANGGAL = HARI INI (mirip Evaluation Program)
        $from = $request->filled('from')
            ? $request->from
            : now()->toDateString();

        $to = $request->filled('to')
            ? $request->to
            : now()->toDateString();

        $query = HealthScreening::with('athlete')
            ->whereBetween('screening_date', [$from, $to]);

        // FILTER HASIL (opsional)
        if ($request->filled('result')) {
            $query->where('screening_result', $request->result);
        }

        $data = $query
            ->orderBy('screening_date', 'asc')
            ->get();

        $pdf = Pdf::loadView('export.health-report', [
            'data'   => $data,
            'from'   => $from,
            'to'     => $to,
            'result' => $request->result,
        ])->setPaper('A4', 'portrait');

        return $pdf->download(
            "Laporan_Skrining_Kesehatan_{$from}_sampai_{$to}.pdf"
        );
    }
}
